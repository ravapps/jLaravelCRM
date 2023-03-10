<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Common;
use App\Http\Controllers\UserController;
use App\Http\Requests\SaleorderRequest;
use App\Mail\SendQuotation;
use App\Repositories\CompanyRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\EmailRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
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

class SalesorderController extends UserController
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
        $this->productRepository = $productRepository;
        $this->companyRepository = $companyRepository;
        $this->quotationTemplateRepository = $quotationTemplateRepository;
        $this->optionRepository = $optionRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->customerRepository = $customerRepository;
        $this->emailRepository = $emailRepository;

        view()->share('type', 'sales_order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('sales_order.sales_orders');
        return view('user.sales_order.index', compact('title'));
    }

    public function convert( $saleorder ) {
  		return redirect()->route('delivery.create')->with('saleid', $saleorder);
  	}

    public function createcustomer( SaleorderRequest $request ) {
      if(str_contains(url()->previous(),'create')) {
        return redirect()->route('customer.create')
        ->with('editid', 0)
        ->with('editaction','no')
        ->with('idone',$request->idone)
        ->with('idtwo',$request->idtwo)
        ->with('nextaction','sales_order')
        ->with('companyid',$request->idone);
      } elseif(str_contains(url()->previous(),'edit')) {
        $getid = explode("/",url()->previous());
        return redirect()->route('customer.create')
        ->with('editid',  $getid[count($getid)-2])
        ->with('editaction','yes')
        ->with('idone',$request->idone)
        ->with('idtwo',$request->idtwo)
        ->with('nextaction','sales_order')
        ->with('companyid',$request->idone);
      } else {
        return redirect(url()->previous());
      }
    }


    public function createcompany(  ) {
      if(str_contains(url()->previous(),'create')) {
        return redirect()->route('company.create')
        ->with('editid', 0)
        ->with('editaction','no')
        ->with('idone',0)
        ->with('idtwo',0)
        ->with('nextaction','sales_order');
      } elseif(str_contains(url()->previous(),'edit')) {
        $getid = explode("/",url()->previous());
        return redirect()->route('company.create')
        ->with('editid',  $getid[count($getid)-2])
        ->with('editaction','yes')
        ->with('idone',0)
        ->with('idtwo',0)
        ->with('nextaction','sales_order');
      } else {
        return redirect(url()->previous());
      }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('sales_order.create');
        if(!empty(request()->session()->get('companyid'))) {
    			view()->share('ofcompanyid', request()->session()->get('companyid') );
    		}
    		if(!empty(request()->session()->get('customerid'))) {
    			view()->share('ofcustomerid', request()->session()->get('customerid') );
    		}
        $this->generateParams();

        return view('user.sales_order.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleorderRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleorderRequest $request)
    {
        if(empty($request->qtemplate_id)){
            $request->merge(['qtemplate_id'=>0]);
        }
        $saleorder = $this->salesOrderRepository->getAll()->withDeleteList()->get()->count();
        if($saleorder == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->salesOrderRepository->getAll()->withDeleteList()->get()->last()->id;
        }
        $start_number = Settings::get('sales_start_number');
        $saleorder_no = Settings::get('sales_prefix') . (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);

        $request->merge(['sale_number'=> $saleorder_no,'is_delete_list'=>0,'is_invoice_list'=>0]);
        $request->merge(['sales_person_id'=> $this->userRepository->getUser()->id]);
        $request->merge(['sales_team_id'=> $this->userRepository->getUser()->id]);
        $dt = date_create($request->date);
        $nextdt = date_add($dt,date_interval_create_from_date_string($request->exp_days.' days'));
        $request->merge(['exp_date'=> date_format($nextdt,'F d,Y')]);
        if(empty($request->discount_is_fixed)){
          $request->merge(['discount_is_fixed'=> '0']);
        } else {
            $request->merge(['discount_is_fixed'=> '1']);
        }

        $this->salesOrderRepository->createSalesOrder($request->all());

        if ($request->status == trans('sales_order.draft_salesorder')){
            return redirect("sales_order/draft_salesorders");
        }else{
            return redirect("sales_order");
        }
    }

    public function edit($saleorder)
    {
      view()->share('nextaction','');
      if(!empty(request()->session()->get('companyid'))) {
        view()->share('ofcompanyid', request()->session()->get('companyid') );
      }
      if(!empty(request()->session()->get('customerid'))) {
        view()->share('ofcustomerid', request()->session()->get('customerid') );
      }
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $title = trans('sales_order.edit');

        $this->generateParams();
        $this->emailRecipients($saleorder->customer_id);
        $sales_team = $this->salesTeamRepository->find($saleorder->sales_team_id);
        $team_leader = $this->userRepository->all()->where('id',$sales_team->team_leader)->pluck('full_name','id')->toArray();
        $sales_team_members = $sales_team->members->pluck('full_name','id')->toArray();
        $main_staff = $team_leader+$sales_team_members;
        return view('user.sales_order.edit', compact('title', 'saleorder','main_staff'));
    }

    public function update(SaleorderRequest $request, $saleorder)
    {
        if(empty($request->qtemplate_id)){
            $request->merge(['qtemplate_id'=>0]);
        }
        $request->merge(['sales_person_id'=> $this->userRepository->getUser()->id]);
        $request->merge(['sales_team_id'=> $this->userRepository->getUser()->id]);
        $dt = date_create($request->date);
        $nextdt = date_add($dt,date_interval_create_from_date_string($request->exp_days.' days'));
        $request->merge(['exp_date'=> date_format($nextdt,'F d,Y')]);
        if(empty($request->discount_is_fixed)){
          $request->merge(['discount_is_fixed'=> '0']);
        } else {
            $request->merge(['discount_is_fixed'=> '1']);
        }
        $saleorder_id = $saleorder;
        $this->salesOrderRepository->updateSalesOrder($request->all(),$saleorder_id);

        if ($request->status == trans('sales_order.draft_salesorder')){
            return redirect("sales_order/draft_salesorders");
        }else{
            return redirect("sales_order");
        }
    }

    public function show($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $title = trans('sales_order.show');
        $this->generateParams();
        $this->emailRecipients($saleorder->customer_id);
        $action = 'show';
        return view('user.sales_order.show', compact('title', 'saleorder','action'));
    }

    public function delete($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $title = trans('sales_order.delete');
        $this->generateParams();
        return view('user.sales_order.delete', compact('title', 'saleorder'));
    }

    public function destroy($saleorder)
    {
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $saleorder->update(['is_delete_list' => 1]);
        return redirect('salesorder_delete_list');
    }

    public function data(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $sales_order = $this->salesOrderRepository->getAll()
            ->where('status',trans('sales_order.send_salesorder'))
            ->where('is_service',0)
            ->with('user', 'customer')
            ->get()
            ->map(function ($saleOrder) use ($dateFormat){
                return [
                    'id' => $saleOrder->id,
                    'sale_number' => $saleOrder->sale_number,
                    'customer' => isset($saleOrder->customer) ?$saleOrder->customer->full_name : '',
                    'final_price' => $saleOrder->final_price,
                    'date' => date($dateFormat, strtotime($saleOrder->date)),
                    'exp_date' => date($dateFormat, strtotime($saleOrder->exp_date)),
                    'payment_term' => $saleOrder->payment_term,
                    'status' => $saleOrder->status,
                    'is_ondelivery' => $saleOrder->is_ondelivery,
                    'sales_team_id' => $saleOrder->salesTeam->salesteam ?? '',
                    'main_staff' => $saleOrder->salesPerson->full_name ?? '',
                ];
            });
        return $datatables->collection($sales_order)
            ->addColumn(
                'expired',
                '@if(strtotime(date("m/d/Y"))>strtotime("+".$payment_term." ",strtotime($exp_date)))
                                        <i class="fa fa-bell-slash text-danger" title="{{trans(\'sales_order.salesorder_expired\')}}"></i>
                                     @else
                                      <i class="fa fa-bell text-warning" title="{{trans(\'sales_order.salesorder_will_expire\')}}"></i>
                                     @endif'
            )
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'sales_orders.write\']) || Sentinel::inRole(\'admin\') )

                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'sales_orders.read\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'sales_order/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                     <!--- <a href="{{ url(\'sales_order/\' . $id . \'/print_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a> --->
                                    <a href="{{ url(\'sales_order/\' . $id . \'/newprint_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a>
                                    @endif
                                     @if(Sentinel::getUser()->hasAccess([\'sales_orders.delete\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'sales_order/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                            @if($is_ondelivery  <> 1)
																						<a href="{{ url(\'sales_order/\' . $id . \'/convert\' ) }}" title="{{ trans(\'table.convertdo\') }}">
			                                             <i class="fa fa-fw fa-hdd-o text-danger"></i> </a>
																									 @endif
                                     @endif')
            ->rawColumns(['actions','expired'])->make();
    }

    public function draftIndex(){
        $title=trans('sales_order.draft_salesorder');
        return view('user.sales_order.draft_salesorders', compact('title'));
    }
    public function draftSalesOrders(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $sales_order = $this->salesOrderRepository->getAll()
            ->where('status',trans('sales_order.draft_salesorder'))
            ->where('is_service',0)
            ->with('user', 'customer')
            ->get()
            ->map(function ($saleOrder) use ($dateFormat){
                return [
                    'id' => $saleOrder->id,
                    'sale_number' => $saleOrder->sale_number,
                    'customer' => isset($saleOrder->customer) ?$saleOrder->customer->full_name : '',
                    'final_price' => $saleOrder->final_price,
                    'date' => date($dateFormat, strtotime($saleOrder->date)),
                    'exp_date' => date($dateFormat, strtotime($saleOrder->exp_date)),
                    'payment_term' => $saleOrder->payment_term,
                    'status' => $saleOrder->status,
                    'is_ondelivery' => $saleOrder->is_ondelivery,
                    'sales_team_id' => $saleOrder->salesTeam->salesteam ?? '',
                    'main_staff' => $saleOrder->salesPerson->full_name ?? '',
                ];
            });
        return $datatables->collection($sales_order)
            ->addColumn(
                'expired',
                '@if(strtotime(date("m/d/Y"))>strtotime("+".$payment_term." ",strtotime($exp_date)))
                                        <i class="fa fa-bell-slash text-danger" title="{{trans(\'sales_order.salesorder_expired\')}}"></i>
                                     @else
                                      <i class="fa fa-bell text-warning" title="{{trans(\'sales_order.salesorder_will_expire\')}}"></i>
                                     @endif'
            )
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'sales_orders.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'sales_order/\' . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning "></i>  </a>
                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'sales_orders.read\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'sales_order/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                     <a href="{{ url(\'sales_order/\' . $id . \'/newprint_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a>
                                    @endif
                                     @if(Sentinel::getUser()->hasAccess([\'sales_orders.delete\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'sales_order/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                            @if($is_ondelivery  <> 1)
                                            <a href="{{ url(\'sales_order/\' . $id . \'/convert\' ) }}" title="{{ trans(\'table.convertdo\') }}">
                                                   <i class="fa fa-fw fa-hdd-o text-danger"></i> </a>
                                                   @endif
                                     @endif')
            ->rawColumns(['actions','expired'])->make();
    }

    public function ajaxQtemplatesProducts($qtemplate)
    {
        $qtemplateProduct = $this->quotationTemplateRepository->find($qtemplate);
        $templateProduct = [];
        foreach ($qtemplateProduct->qTemplateProducts as $product){
            $templateProduct[] = $product;
        }
        return $templateProduct;
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

    public function newprintQuot($saleorder)
    {


$saleorder = $this->salesOrderRepository->find($saleorder);


  $this->generateParams();


  $sales_team = $this->salesTeamRepository->find($saleorder->sales_team_id);
  $team_leader = $this->userRepository->all()->where('id',$sales_team->team_leader)->pluck('full_name','id')->toArray();
  $sales_team_members = $sales_team->members->pluck('full_name','id')->toArray();
  $main_staff = $team_leader+$sales_team_members;


                $filename = 'SalesOrder-' . $saleorder->sale_number;
        $pdf = App::make('dompdf.wrapper');


        //$pdf->setPaper('a4','landscape');
        //return view('quotation_template.sale_short', compact('title', 'saleorder','main_staff'));

          $pdf->loadView('quotation_template.sale_short', compact('title', 'saleorder','main_staff'));



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

    public function sendSaleorder(Request $request)
    {
        $email_subject = $request->email_subject;
	    $to_customers = $this->customerRepository->all()->whereIn('user_id', $request->recipients);
        $email_body = $request->message_body;
        $message_body = Common::parse_template($email_body);
        $saleorder_pdf = $request->saleorder_pdf;
        $site_email = Settings::get('site_email');
        if (!empty($to_customers) && !filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
            foreach ($to_customers as $item) {
                if (!filter_var($item->user->email, FILTER_VALIDATE_EMAIL) === false) {
                    Mail::to($item->user->email)->send(new SendQuotation([
                        'from' => $site_email,
                        'subject' => $email_subject,
                        'message_body' => $message_body,
                        'quotation_pdf' => $saleorder_pdf
                    ]));
                }
                $this->emailRepository->create([
                    'assign_customer_id' => $item->id,
                    'from' => $this->userRepository->getUser()->id,
                    'to' => $item->user_id,
                    'subject' => $email_subject,
                    'message' => $message_body
                ]);
            }
            echo '<div class="alert alert-success">' . trans('sales_order.success') . '</div>';
        }
        else {
            echo '<div class="alert alert-danger">' . trans('invoice.error') . '</div>';
        }
    }

    public function makeInvoice($saleorder)
    {
        $user = $this->userRepository->getUser();
        $saleorder = $this->salesOrderRepository->find($saleorder);
        $invoice = $this->invoiceRepository->getAll()->withDeleteList()->get()->count();
        if($invoice == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->invoiceRepository->getAll()->withDeleteList()->get()->last()->id;
        }
        $start_number = Settings::get('invoice_start_number');
        $invoice_number = Settings::get('invoice_prefix') . (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);
        $saleorder->update(['is_invoice_list' => 1]);

        $invoice = $this->invoiceRepository->create([
            'order_id' => $saleorder->id,
            'customer_id' => $saleorder->customer_id,
            'sales_person_id' => $saleorder->sales_person_id,
            'sales_team_id' => $saleorder->sales_team_id,
            'invoice_number' => $invoice_number,
            'invoice_date' =>date(config('settings.date_format')),
            'due_date' => $saleorder->expire_date,
            'payment_term' => isset($saleorder->payment_term)?$saleorder->payment_term:0,
            'status' => 'Open Invoice',
            'total' => $saleorder->total,
            'tax_amount' => $saleorder->tax_amount,
            'grand_total' => $saleorder->grand_total,
            'unpaid_amount' => $saleorder->final_price,
            'discount' => $saleorder->discount,
            'final_price' => $saleorder->final_price,
            'user_id' => $user->id,
            'qtemplate_id' => $saleorder->qtemplate_id,
        ]);
        $list =[];
        if (!empty($saleorder->salesOrderProducts->count() > 0)) {
            foreach ($saleorder->salesOrderProducts as $key=>$item) {
                $temp['quantity']=$item->pivot->quantity;
                $temp['price']=$item->pivot->price;
                $list[$item->pivot->product_id]=$temp;
            }
        }
        $invoice->invoiceProducts()->attach($list);

        $saleorder->update(['is_invoice_list' => 1]);
        return redirect('invoice');
    }


    private function generateParams()
    {
        $products = $this->productRepository->orderBy("id", "desc")->all();
        $pay_terms = $this->optionRepository->getAll()
            ->where('category', 'pay_terms')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('quotation.seltitle'), '');


        $qtemplates = $this->quotationTemplateRepository->getAll()
	            ->pluck('quotation_template', 'id')
	            ->prepend(trans('dashboard.select_template'), '');

        $companies = $this->companyRepository->getAll()->orderBy("name", "asc")
	            ->pluck('name', 'id')
	            ->prepend(trans('dashboard.select_company'), '');

        $staffs = $this->userRepository->getStaff()
	            ->pluck('full_name', 'id')
	            ->prepend(trans('dashboard.select_staff'), '');

        $salesteams = $this->salesTeamRepository->getAll()
	            ->pluck('salesteam', 'id')
	            ->prepend(trans('dashboard.select_sales_team'), '');

              $customers = $this->customerRepository->getCustomerContact(0)
                                                      ->pluck('name', 'id')
                                                      ->prepend(trans('dashboard.select_customer'), '');

        $companies_mail = $this->userRepository->getAll()->get()->filter(function ($user) {
            return $user->inRole('customer');
        })->pluck('full_name', 'id');

        $statuses = $this->optionRepository->getAll()
            ->where('category', 'sales_order_status')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('quotation.status'), '');
        $sales_tax = Settings::get('sales_tax');

        view()->share('pay_terms', $pay_terms);
        view()->share('statuses', $statuses);
        view()->share('products', $products);
        view()->share('qtemplates', $qtemplates);
        view()->share('companies', $companies);
        view()->share('staffs', $staffs);
        view()->share('salesteams', $salesteams);
        view()->share('customers', $customers);
        view()->share('companies_mail', $companies_mail);
        view()->share('sales_tax', isset($sales_tax) ? floatval($sales_tax) : 1);
    }

    private function emailRecipients($customer_id){
        $email_recipients = $this->userRepository->getParentCustomers()->where('id',$customer_id)->pluck('full_name','id');
        view()->share('email_recipients', $email_recipients);
    }
}
