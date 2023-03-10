<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ExcelfileValidator  ;
use App\Helpers\Thumbnail;
use App\Http\Controllers\UserController;
use App\Http\Requests\ProductRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ProductController extends UserController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @param ExcelRepository $excelRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(ProductRepository $productRepository,
                                CategoryRepository $categoryRepository,
                                ExcelRepository $excelRepository,
                                OptionRepository $optionRepository)
    {

        $this->middleware('authorized:products.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:products.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:products.delete', ['only' => ['delete']]);

        parent::__construct();

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->excelRepository = $excelRepository;
        $this->optionRepository = $optionRepository;

        view()->share('type', 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('product.products');
        return view('user.product.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      if(str_contains(url()->current(),"createservice")) {
        $title = trans('product.newservice');
      } else {
        $title = trans('product.new');
      }




        $this->generateParams();



        return view('user.product.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if ($request->hasFile('product_image_file')) {
            $file = $request->file('product_image_file');
            $file = $this->productRepository->uploadProductImage($file);

            $request->merge([
                'product_image' => $file->getFileInfo()->getFilename(),
            ]);

            $this->generateProductThumbnail($file);
        }
        if($request->is_service == "yes") {
          $request->is_service = 1;
          //$request->replace(['is_service' => 1]);
          $request->merge(['quantity_on_hand' => 0]);

          $request->merge(['is_service' => 1]);
          $request->merge(['quantity_available' => 0]);
        } else {
          $request->is_service = 0;

          $request->merge(['is_service' => 0]);

          //$request->replace(['is_service' => 0]);
        }
        //echo $request->sale_price;
        //exit();



        $this->productRepository->create($request->except('product_image_file'));

        return redirect("product");
    }

    public function edit($product)
    {
        $product = $this->productRepository->find($product);
        $title = trans('product.edit');

        $this->generateParams();

        return view('user.product.edit', compact('title', 'product'));
    }

    public function update(ProductRequest $request, $product)
    {
        $product = $this->productRepository->find($product);
        if ($request->hasFile('product_image_file')) {
            $file = $request->file('product_image_file');
            $file = $this->productRepository->uploadProductImage($file);

            $request->merge([
                'product_image' => $file->getFileInfo()->getFilename(),
            ]);

            $this->generateProductThumbnail($file);
        }


        if($request->is_service == "yes") {
          $request->is_service = 1;
          //$request->replace(['is_service' => 1]);
          $request->merge(['quantity_on_hand' => 0]);

          $request->merge(['is_service' => 1]);
          $request->merge(['quantity_available' => 0]);
        } else {
          $request->is_service = 0;

          $request->merge(['is_service' => 0]);

          //$request->replace(['is_service' => 0]);
        }

      //var_dump($request);
      //exit();
        $product->update($request->except('product_image_file'));

        return redirect("product");
    }


    public function show($product)
    {
        $product = $this->productRepository->find($product);
        $action = "show";
        $title = trans('product.view');
        return view('user.product.show', compact('title', 'product', 'action'));
    }

    public function delete($product)
    {
        $product = $this->productRepository->find($product);
        $title = trans('product.delete');
        return view('user.product.delete', compact('title', 'product'));
    }

    public function destroy($product)
    {
        $product = $this->productRepository->find($product);
        $product->delete();
        return redirect("product");
    }

    public function data(Datatables $datatables)
    {
        $products = $this->productRepository
            ->with('category','invoiceProducts','quotationProducts','qTemplateProducts','salesOrderProducts')->all()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'product_name' => $p->product_name,
                    'category' => is_null($p->category) ? '': $p->category->name,
                    'product_type' => $p->product_type,
                    'is_service' => $p->is_service,
                    'status' => $p->status,
                    'quantity_on_hand' => ($p->quantity_on_hand > 0)?$p->quantity_on_hand:'NA',
                    'quantity_available' => ($p->quantity_available > 0)?$p->quantity_available:'NA',
                    'sale_price' => $p->sale_price,
                    'count_uses' => $p->invoiceProducts->count() +
                                    $p->quotationProducts->count() +
                                    $p->qTemplateProducts->count() +
                                    $p->salesOrderProducts->count()
                ];
            });
        return $datatables->collection($products)
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'products.write\']) || Sentinel::inRole(\'admin\'))
                                        @if($is_service)
                                        <a href="{{ url(\'product/\' . $id . \'/editservice\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                        @else
                                        <a href="{{ url(\'product/\' . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                        @endif
                                            <i class="fa fa-fw fa-pencil text-warning "></i> </a>
                                     @endif
                                     <a href="{{ url(\'product/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}">
                                            <i class="fa fa-fw fa-eye text-primary"></i></a>
                                     @if((Sentinel::getUser()->hasAccess([\'products.delete\']) || Sentinel::inRole(\'admin\')) && $count_uses==0)
                                        <a href="{{ url(\'product/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                     @endif')
            ->removeColumn('count_uses')
            ->rawColumns(['actions'])->make();
    }

    /**
     * @param $file
     */
    private function generateProductThumbnail($file)
    {
        $sourcePath = $file->getPath() . '/' . $file->getFilename();
        $thumbPath = $file->getPath() . '/thumb_' . $file->getFilename();
        Thumbnail::generate_image_thumbnail($sourcePath, $thumbPath);
    }

    private function generateParams()
    {



      if(str_contains(url()->current(),"createservice") or str_contains(url()->current(),"editservice")) {
        view()->share('formisservice', "yes");
        $product_types = $this->optionRepository->getAll()
            ->where('category', 'product_type')
            ->where('value','Service')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title','value')->prepend(trans('product.product_type'), '');
      } else {
        view()->share('formisservice', "no");
        $product_types = $this->optionRepository->getAll()
            ->where('category', 'product_type')
            ->where('value','<>','Service')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title','value')->prepend(trans('product.product_type'), '');
      }
        $statuses = $this->optionRepository->getAll()
            ->where('category', 'product_status')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title','value')->prepend(trans('Select Status'), '');


        $categories = $this->categoryRepository->getAll()
            ->orderBy("id", "desc")
            ->get()
	        ->map(function ($category) {
		        return [
			        'title' => $category->name,
			        'value'   => $category->id,
		        ];
	        })->pluck('title','value')->prepend(trans('product.category_id'), '');

        view()->share('statuses', $statuses);
        view()->share('product_types', $product_types);
        view()->share('categories', $categories);
    }

    public function getImport()
    {
		//return 'jimmy';
        $title = trans('product.import');
        return view('user.product.import', compact('title'));
    }

    public function postImport(Request $request)
    {

        if(! ExcelfileValidator::validate( $request ))
        {
            return response('invalid File or File format', 500);
        }

        $reader = $this->excelRepository->load($request->file('file'));
         $data = $reader->all()->map(function ($product) {
                return [
                    'product_name' => $product->product_name,
                    'product_type' => $product->product_type,
                    'status' => $product->status,
                    'quantity_on_hand' => ($product->quantity_on_hand > 0)?$product->quantity_on_hand:'NA',
                    'quantity_available' => ($product->quantity_available > 0)?$product->quantity_available:'NA',
                    'sale_price' => $product->sale_price,
                    'description' => $product->description,
                    'description_for_quotations' => $product->description_for_quotations,
                    'variants' => $this->getProductVariants($product->variants),
                ];
            }) ;

        $categories = $this->categoryRepository->getAll()
            ->orderBy("id", "desc")
            ->get()
            ->map(function ($category) {
                return [
                    'title' => $category->name,
                    'id' => $category->id,
                ];
            });
        $productTypes = $this->optionRepository->getAll()
            ->where('category', 'product_type')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title','value');

        $statuses = $this->optionRepository->getAll()
            ->where('category', 'product_status')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title','value');

        return response()->json(compact('data', 'categories','productTypes','statuses'), 200);
    }

    public function postAjaxStore(ProductRequest $request)
    {
       $product =  $this->productRepository->create($request->except('created', 'errors', 'selected' , 'variants'));

         if (!empty($request->variants)) {

            foreach ($request->variants as $key => $item) {
                $productVariant = new ProductVariant();
                $productVariant->attribute_name = $item[0];
                $productVariant->product_attribute_value = $item[1] ;
                $product->productVariants()->save($productVariant);
            }
        }
        return response()->json([], 200);
    }

    public function downloadExcelTemplate()
    {
        if (ob_get_length()) ob_end_clean();
        $path = base_path('resources/excel-templates/products.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        return 'File not found!';
    }

    private function getProductVariants($variants = [])
    {
        if (isset($variants)) {
            $variants = array_map(
                function ($v) {
                    return explode(':', $v);
                },
                explode(',', $variants)
            );
        }

        return $variants;
    }

}
