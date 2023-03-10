<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Common;
use App\Http\Controllers\UserController;
use App\Http\Requests\DeliveryRequest;
use App\Mail\SendQuotation;
use App\Repositories\CompanyRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\EmailRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\DeliveryOrderRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\QuotationTemplateRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Efriandika\LaravelSettings\Facades\Settings;
use Yajra\Datatables\Datatables;

class DeliveryOrderController extends UserController
{
    /**
     * @var QuotationRepository
     */
    private $salesOrderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    private $deliveryOrderRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var QuotationTemplateRepository
     */
    private $quotationTemplateRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    private $invoiceRepository;

    private $emailRepository;

    private $customerRepository;

    /**
     * @param SalesOrderRepository $salesOrderRepository
     * @param UserRepository $userRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param ProductRepository $productRepository
     * @param CompanyRepository $companyRepository
     * @param QuotationTemplateRepository $quotationTemplateRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(SalesOrderRepository $salesOrderRepository,
                                UserRepository $userRepository,
                                SalesTeamRepository $salesTeamRepository,
                                ProductRepository $productRepository,
                                CompanyRepository $companyRepository,
                                QuotationTemplateRepository $quotationTemplateRepository,
                                OptionRepository $optionRepository,
                                InvoiceRepository $invoiceRepository,
                                DeliveryOrderRepository $deliveryOrderRepository,
                                CustomerRepository $customerRepository,
                                EmailRepository $emailRepository
    )
    {

        $this->middleware('authorized:sales_orders.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:sales_orders.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:sales_orders.delete', ['only' => ['delete']]);

        parent::__construct();

        $this->salesOrderRepository = $salesOrderRepository;
        $this->userRepository = $userRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->deliveryOrderRepository = $deliveryOrderRepository;
        $this->productRepository = $productRepository;
        $this->companyRepository = $companyRepository;
        $this->quotationTemplateRepository = $quotationTemplateRepository;
        $this->optionRepository = $optionRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->customerRepository = $customerRepository;
        $this->emailRepository = $emailRepository;

        view()->share('type', 'delivery');
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('delivery.delivery_orders');
        return view('user.delivery.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      //

      if(!empty(request()->session()->get('saleid'))) {
        $saleid = request()->session()->get('saleid');
        $saleorder = $this->salesOrderRepository->find($saleid);
      } else {
        $saleid = request()->session()->get('saleid');
        $saleorder = $this->salesOrderRepository->find(2);
          //return redirect("sales_order/draft_salesorders");
      }

      //exit();

        $title = trans('delivery.create');

        $this->generateParams();
      view()->share('saleorder', $saleorder);
        return view('user.delivery.create', compact('title'));
    }


    public function store(DeliveryRequest $request)
    {
        /*$saleorder = $this->salesOrderRepository->getAll()->withDeleteList()->get()->count();
        if($saleorder == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->salesOrderRepository->getAll()->withDeleteList()->get()->last()->id;
        }
        $start_number = Settings::get('sales_start_number');
        $saleorder_no = Settings::get('sales_prefix') . (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);
        */
      $getobj =  $this->deliveryOrderRepository->create(['delivery_date'=>$request->delivery_date,'salejob_id' => $request->salejob_id,'approved_by' => $request->approved_by,'received_by' => $request->received_by,'delivered_by' => $request->delivered_by]);
  $soobj = $this->salesOrderRepository->find(  $getobj->salejob_id);

        $soobj->update(['is_ondelivery' => '1']);



            return redirect("delivery");

    }

    public function edit($id)
    {

  $delorder = $this->deliveryOrderRepository->find($id);



        $saleorder = $this->salesOrderRepository->find($delorder->salejob_id);



        $title = trans('jobs_order.edit');


      view()->share('saleorder', $saleorder);
      view()->share('deliveryorder', $delorder);

        $this->generateParams();

        return view('user.delivery.create', compact('title'));
    }

    public function update(DeliveryRequest $request,$deliveryorder)
    {

  $getobj = $this->deliveryOrderRepository->find($deliveryorder);
    $getobj->update(['delivery_date'=>$request->delivery_date,'salejob_id' => $request->salejob_id,'approved_by' => $request->approved_by,'received_by' => $request->received_by,'delivered_by' => $request->delivered_by]);
            return redirect("delivery");
    }

    public function show($saleorder)
    {


      $delorder = $this->deliveryOrderRepository->find($saleorder);



            $saleorder = $this->salesOrderRepository->find($delorder->salejob_id);






          view()->share('saleorder', $saleorder);
          view()->share('deliveryorder', $delorder);

        $title = trans('jobs_order.show');

        $action = 'show';
        return view('user.delivery.show', compact('title', 'action'));
    }

    public function delete($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $title = trans('jobs_order.delete');
        $this->generateParams();
        return view('user.jobs_order.delete', compact('title', 'saleorder'));
    }

    public function destroy($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $saleorder->update(['is_delete_list' => 1]);
        return redirect('jobsorder_delete_list');
    }

    public function data(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $d_order = $this->deliveryOrderRepository->getAll()
            ->get()
            ->map(function ($dOrder) use ($dateFormat){
                return [
                    'id' => $dOrder->id,
                    'sale_number' => $this->salesOrderRepository->find($dOrder->salejob_id)->sale_number,
                    'customer' => $this->salesOrderRepository->find($dOrder->salejob_id)->customer->full_name,
                    'date' => date($dateFormat, strtotime($dOrder->delivery_date)),
                    'approved_by' => $dOrder->approved_by,
                    'received_by' => $dOrder->received_by,
                    'delivered_by' => $dOrder->delivered_by,
                    'status' => $dOrder->status,

                ];
            });
        return $datatables->collection($d_order)
        ->addColumn('actions', '<a href="{{ url(\'delivery/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
               <i class="fa fa-fw fa-eye text-primary"></i> </a>
               <a href="{{ url(\'delivery/\' . $id . \'/newprint_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                               <i class="fa fa-fw fa-print text-primary "></i>  </a>
        <a href="{{ url(\'delivery/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.print\') }}">
               <i class="fa fa-fw fa-edit text-primary "></i>  </a>')
        ->rawColumns(['actions','expired'])->make();
    }





          public function newprintQuot($saleorder)
          {

            $delorder = $this->deliveryOrderRepository->find($saleorder);



                  $saleorder = $this->salesOrderRepository->find($delorder->salejob_id);

        $this->generateParams();


        $sales_team = $this->salesTeamRepository->find($saleorder->sales_team_id);
        $team_leader = $this->userRepository->all()->where('id',$sales_team->team_leader)->pluck('full_name','id')->toArray();
        $sales_team_members = $sales_team->members->pluck('full_name','id')->toArray();
        $main_staff = $team_leader+$sales_team_members;


                      $filename = 'DeliveryOrder-' . $saleorder->sale_number;
              $pdf = App::make('dompdf.wrapper');


              //$pdf->setPaper('a4','landscape');
              //return view('quotation_template.sale_short', compact('title', 'saleorder','main_staff'));

                $pdf->loadView('quotation_template.delivery_short', compact('title', 'delorder', 'saleorder','main_staff'));



              return $pdf->download($filename . '.pdf');
          }


    public function printQuot($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $filename = 'SalesOrder-' . $saleorder->sale_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4','landscape');
        $pdf->loadView('saleorder_template.'.Settings::get('saleorder_template'), compact('saleorder'));
        return $pdf->download($filename . '.pdf');
    }

    public function ajaxCreatePdf($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $filename = 'SalesOrder-' . $saleorder->sale_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4','landscape');
        $pdf->loadView('saleorder_template.'.Settings::get('saleorder_template'), compact('saleorder'));
        $pdf->save('./pdf/' . $filename . '.pdf');
        $pdf->stream();
        echo url("pdf/" . $filename . ".pdf");

    }



    private function generateParams()
    {

        $sales_tax = Settings::get('sales_tax');


        view()->share('sales_tax', isset($sales_tax) ? floatval($sales_tax) : 1);
    }

    private function emailRecipients($customer_id){
        $email_recipients = $this->userRepository->getParentCustomers()->where('id',$customer_id)->pluck('full_name','id');
        view()->share('email_recipients', $email_recipients);
    }
}
