<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Common;
use App\Http\Controllers\UserController;
use App\Http\Requests\QuotationRequest;
use App\Mail\SendQuotation;
use App\Repositories\CompanyRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\LeadRepository;
use App\Repositories\EmailRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\QuotationTemplateRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class QuotationController extends UserController
{
    /**
     * @var QuotationRepository
     */
    private $quotationRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    private $leadRepository;
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

    private $customerRepository;

    private $salesOrderRepository;

    private $invoiceRepository;

    private $emailRepository;

    /**
     * QuotationController constructor.
     * @param QuotationRepository $quotationRepository
     * @param UserRepository $userRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param ProductRepository $productRepository
     * @param CompanyRepository $companyRepository
     * @param QuotationTemplateRepository $quotationTemplateRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(QuotationRepository $quotationRepository,
                                UserRepository $userRepository,
                                SalesTeamRepository $salesTeamRepository,
                                ProductRepository $productRepository,
                                CompanyRepository $companyRepository,
                                QuotationTemplateRepository $quotationTemplateRepository,
                                OptionRepository $optionRepository,
                                CustomerRepository $customerRepository,
                                SalesOrderRepository $salesOrderRepository,
                                InvoiceRepository $invoiceRepository,
                                LeadRepository $leadRepository,
                                EmailRepository $emailRepository
)
    {
        parent::__construct();

        $this->middleware('authorized:quotations.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:quotations.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:quotations.delete', ['only' => ['delete']]);

        $this->quotationRepository = $quotationRepository;
        $this->userRepository = $userRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->productRepository = $productRepository;
        $this->companyRepository = $companyRepository;
        $this->quotationTemplateRepository = $quotationTemplateRepository;
        $this->leadRepository = $leadRepository;
        $this->optionRepository = $optionRepository;
        $this->customerRepository = $customerRepository;
        $this->salesOrderRepository = $salesOrderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->emailRepository = $emailRepository;

        view()->share('type', 'quotation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('quotation.quotations');
        return view('user.quotation.index', compact('title'));
    }




    	public function createcustomer( QuotationRequest $request ) {
    		if(str_contains(url()->previous(),'create')) {
    			return redirect()->route('customer.create')
    			->with('editid', 0)
    			->with('editaction','no')
    			->with('nextaction','quotation')
          ->with('idone',$request->idone)
          ->with('idtwo',$request->idtwo)
          ->with('companyid',$request->idone);
    		} elseif(str_contains(url()->previous(),'edit')) {
    			$getid = explode("/",url()->previous());
    			return redirect()->route('customer.create')
    			->with('editid',  $getid[count($getid)-2])
    			->with('editaction','yes')
          ->with('idone',$request->idone)
          ->with('idtwo',$request->idtwo)
          ->with('companyid',$request->idone)
    			->with('nextaction','quotation');
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
    			->with('nextaction','quotation');
    		} elseif(str_contains(url()->previous(),'edit')) {
    			$getid = explode("/",url()->previous());
    			return redirect()->route('company.create')
    			->with('editid',  $getid[count($getid)-2])
    			->with('editaction','yes')
    			->with('idone',0)
    			->with('idtwo',0)
    			->with('nextaction','quotation');
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
        $title = trans('quotation.create');
        if(!empty(request()->session()->get('companyid'))) {
    			view()->share('ofcompanyid', request()->session()->get('companyid') );
    		}
    		if(!empty(request()->session()->get('customerid'))) {
    			view()->share('ofcustomerid', request()->session()->get('customerid') );
    		}
        //echo request()->session()->get('leadid');
        if(!empty(request()->session()->get('leadid'))) {
          $leadid = request()->session()->get('leadid');
          $lead = $this->leadRepository->find($leadid);
          $title = $title.' ('.trans('quotation.convertlead').')';
          //echo "herer";
          //var_dump($lead);
        } else {
            $lead = "";
        }
        $Qnum = '';
        $f = isset($this->userRepository->getUser()->first_name)?substr($this->userRepository->getUser()->first_name,0,1):'';
        $l = isset($this->userRepository->getUser()->last_name)?substr($this->userRepository->getUser()->last_name,0,1):'';;
        $Qnum = 'FMS-'.$f.$l;

        //echo $Qnum;
        $Qnum = $Qnum.'-'.date('d-m-y');
        $quotation = $this->quotationRepository->getAll()->withDeleteList()->get()->count();
        if($quotation == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->quotationRepository->getAll()->withDeleteList()->get()->last()->id;
        }
        $start_number = Settings::get('quotation_start_number') ;
        $start_number = (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);
        $t ='';
        for($i=0;$i<(4-strlen($start_number));$i++) {
          $t = $t.'0';
        }
        $quotation_no = $Qnum .'-'. $t .$start_number;
        view()->share('quotation_num', $quotation_no);

        //exit();
        $this->generateParams();
        view()->share('lead', $lead);
        return view('user.quotation.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuotationRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
      $Qnum = '';
      $f = isset($this->userRepository->getUser()->first_name)?substr($this->userRepository->getUser()->first_name,0,1):'';
      $l = isset($this->userRepository->getUser()->last_name)?substr($this->userRepository->getUser()->last_name,0,1):'';;
      $Qnum = 'FMS-'.$f.$l;

      //echo $Qnum;
      $Qnum = $Qnum.'-'.date('d-m-y');

        if(empty($request->qtemplate_id)){
            $request->merge(['qtemplate_id'=>0]);
        }
        $quotation = $this->quotationRepository->getAll()->withDeleteList()->get()->count();
        if($quotation == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->quotationRepository->getAll()->withDeleteList()->get()->last()->id;
        }
        $start_number = Settings::get('quotation_start_number') ;
        $start_number = (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);
        $t ='';
        for($i=0;$i<(4-strlen($start_number));$i++) {
          $t = $t.'0';
        }
        $quotation_no = $Qnum .'-'. $t .$start_number;
           /// Settings::get('quotation_prefix')
        //$quotation_no = $Qnum .'-'. (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);
        $request->merge(['quotations_number'=> $quotation_no,'is_delete_list'=>0,'is_converted_list'=>0,'is_quotation_invoice_list'=>0]);
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
//var_dump($request);
//exit();

        $this->quotationRepository->createQuotation($request->except('quotation_num','convertleadid'));
        if($request->convertleadid > 0) {
          $lead = $this->leadRepository->find($request->convertleadid);
          $lead->update(['is_converted' => '1']);
        }
        //exit();
        if ($request->status == trans('quotation.draft_quotation')){
            return redirect("quotation/draft_quotations");
        }else{
            return redirect("quotation");
        }
    }

    public function edit($quotation)
    {
      view()->share('nextaction','');
      if(!empty(request()->session()->get('companyid'))) {
        view()->share('ofcompanyid', request()->session()->get('companyid') );
      }
      if(!empty(request()->session()->get('customerid'))) {
        view()->share('ofcustomerid', request()->session()->get('customerid') );
      }
      view()->share('lead','');
        $quotation = $this->quotationRepository->find($quotation);
        $title = trans('quotation.edit');

        $this->generateParams();
        $this->emailRecipients($quotation->customer_id);

        $sales_team = $this->salesTeamRepository->find($quotation->sales_team_id);
        $team_leader = $this->userRepository->all()->where('id',$sales_team->team_leader)->pluck('full_name','id')->toArray();
        $sales_team_members = $sales_team->members->pluck('full_name','id')->toArray();
        $main_staff = $team_leader+$sales_team_members;

        return view('user.quotation.edit', compact('title', 'quotation','main_staff'));
    }

    public function update(QuotationRequest $request, $quotation)
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
        $quotation_id = $quotation;
        $this->quotationRepository->updateQuotation($request->all(),$quotation_id);

        if ($request->status == trans('quotation.draft_quotation')){
            return redirect("quotation/draft_quotations");
        }else{
            return redirect("quotation");
        }
    }

    public function show($quotation)
    {
        $quotation = $this->quotationRepository->find($quotation);
        $title = trans('quotation.show');
        $action = 'show';
        $this->generateParams();
        $this->emailRecipients($quotation->customer_id);
        return view('user.quotation.show', compact('title', 'quotation','action'));
    }

    public function delete($quotation)
    {
        $quotation = $this->quotationRepository->find($quotation);
        $title = trans('quotation.delete');
        $this->generateParams();
        return view('user.quotation.delete', compact('title', 'quotation'));
    }

    public function destroy($quotation)
    {
        $quotation = $this->quotationRepository->find($quotation);
        //$quotation->update(['is_delete_list' => 1]);
        $quotation->delete();
        return redirect('quotation');
    }

    /**
     * @return mixed
     */
    public function data(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $quotations = $this->quotationRepository->getAll()
            ->where([
                ['status','!=','Draft Quotation']
            ])
            ->with('user', 'customer')
            ->get()
            ->map(function ($quotation) use ($dateFormat){
                return [
                    'id' => $quotation->id,
                    'quotations_number' => $quotation->quotations_number,
                    'customer' => isset($quotation->customer) ? $quotation->customer->user->full_name : '',
                    'final_price' => $this->userRepository->appcurrencyformat($quotation->final_price),
                    'date' => date($dateFormat, strtotime($quotation->date)),
                    'exp_date' => date($dateFormat, strtotime($quotation->exp_date)),
                    'payment_term' => $quotation->payment_term,
                    'status' => $quotation->status,
                    'quote_type' => $quotation->quote_type,
                    'qplatform' => $quotation->qplatform,
                    'is_converted_list' => $quotation->is_converted_list,
                    'sales_team_id' => $quotation->salesTeam->salesteam ?? '',
                    'main_staff' => $quotation->salesPerson->full_name ?? '',
                ];
            });

        return $datatables->collection($quotations)
            ->addColumn(
                'expired',
                '@if(strtotime(date("m/d/Y"))>strtotime("+".$payment_term." ",strtotime($exp_date)))
                                        <i class="fa fa-bell-slash text-danger" title="{{trans(\'quotation.quotation_expired\')}}"></i>
                                     @else
                                      <i class="fa fa-bell text-warning" title="{{trans(\'quotation.quotation_will_expire\')}}"></i>
                                     @endif'
            )
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'quotations.write\']) || Sentinel::inRole(\'admin\'))

                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'quotations.read\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'quotation/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    <!--- <a href="{{ url(\'quotation/\' . $id . \'/print_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a> --->
                                      <a href="{{ url(\'quotation/\' . $id . \'/newprint_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                                   <i class="fa fa-fw fa-print text-primary "></i>  </a>
                                    @endif

                                     @if(Sentinel::getUser()->hasAccess([\'quotations.delete\']) || Sentinel::inRole(\'admin\'))
                                   <a href="{{ url(\'quotation/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                            @if($is_converted_list <> 1)
                                            <a href="{{ url(\'quotation/\' . $id . \'/confirm_sales_order\' ) }}" title="{{ trans(\'table.convertso\') }}">
			                                             <i class="fa fa-fw fa-hdd-o text-danger"></i> </a>
                                                   @endif
                                   @endif')
            ->rawColumns(['actions','expired'])->make();
    }

    public function draftIndex(){
        $title=trans('quotation.draft_quotations');
        return view('user.quotation.draft_quotations', compact('title'));
    }
    public function draftQuotations(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $quotations = $this->quotationRepository->getAll()
            ->where('status',trans('quotation.draft_quotation'))
            ->with('user', 'customer')
            ->get()
            ->map(function ($quotation) use ($dateFormat){
                return [
                    'id' => $quotation->id,
                    'quotations_number' => $quotation->quotations_number,
                    'customer' => isset($quotation->customer) ? $quotation->customer->user->full_name : '',
                    'final_price' => $this->userRepository->appcurrencyformat($quotation->final_price),
                    'date' => date($dateFormat, strtotime($quotation->date)),
                    'exp_date' => date($dateFormat, strtotime($quotation->exp_date)),
                    'payment_term' => $quotation->payment_term,
                    'status' => $quotation->status,
                    'quote_type' => $quotation->quote_type,
                    'qplatform' => $quotation->qplatform,
                    'sales_team_id' => $quotation->salesTeam->salesteam ?? '',
                    'main_staff' => $quotation->salesPerson->full_name ?? '',
                ];
            });

        return $datatables->collection($quotations)
            ->addColumn(
                'expired',
                '@if(strtotime(date("m/d/Y"))>strtotime("+".$payment_term." ",strtotime($exp_date)))
                                        <i class="fa fa-bell-slash text-danger" title="{{trans(\'quotation.quotation_expired\')}}"></i>
                                     @else
                                      <i class="fa fa-bell text-warning" title="{{trans(\'quotation.quotation_will_expire\')}}"></i>
                                     @endif'
            )
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'quotations.write\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'quotation/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}" >
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     @endif

                                     @if(Sentinel::getUser()->hasAccess([\'quotations.read\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'quotation/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    <!--- <a href="{{ url(\'quotation/\' . $id . \'/print_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a>  --->
                                    <a href="{{ url(\'quotation/\' . $id . \'/newprint_quot\' ) }}" title="{{ trans(\'table.print\') }}">
                                            <i class="fa fa-fw fa-print text-primary "></i>  </a>
                                    @endif
                                     @if(Sentinel::getUser()->hasAccess([\'quotations.delete\']) || Sentinel::inRole(\'admin\'))
                                   <a href="{{ url(\'quotation/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                   @endif')
            ->rawColumns(['actions','expired'])->make();
    }

    function confirmSalesOrder($quotation)
    {
        $user = $this->userRepository->getUser();
        $quotation = $this->quotationRepository->find($quotation);
        $salesOrder = $this->salesOrderRepository->getAll()->withDeleteList()->get()->count();
        if($salesOrder == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->salesOrderRepository->getAll()->withDeleteList()->get()->last()->id;
        }
        $start_number = Settings::get('sales_start_number');
        $sale_no = Settings::get('sales_prefix') . (is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);
        // put expirydate logic here
        $dt = date_create(date('F d,Y'));
        $nextdt = date_format(date_add($dt,date_interval_create_from_date_string($quotation->exp_days.' days')),'F d,Y');


        $saleorder = $this->salesOrderRepository->create([
            'sale_number' => $sale_no,
            'customer_id' => $quotation->customer_id,
            'company_id' => $quotation->company_id,
            'discount_is_fixed' => $quotation->discount_is_fixed,
            'date' => date('F d,Y'),
            'exp_date' => $nextdt,
            'exp_days' => $quotation->exp_days,
            'qtemplate_id' => $quotation->qtemplate_id,
            'payment_term' => isset($quotation->payment_term)?$quotation->payment_term:0,
            "sales_person_id" => $quotation->sales_person_id,
            'is_service' => $quotation->is_service,
            "sales_team_id" => $quotation->sales_team_id,
            "terms_and_conditions" => $quotation->terms_and_conditions,
            "total" => $quotation->total,
            "tax_amount" => $quotation->tax_amount,
            "grand_total" => $quotation->grand_total,
            "discount" => is_null($quotation->discount)?0:$quotation->discount,
            "final_price" => $quotation->final_price,
            'status' => 'Draft sales order',
            'user_id' => $user->id,
            'quotation_id' => $quotation->id
        ]);

        $list =[];
        if (!empty($quotation->quotationProducts->count() > 0)) {
            foreach ($quotation->quotationProducts as $key=>$item) {
                $temp['quantity']=$item->pivot->quantity;
                $temp['price']=$item->pivot->price;
                $list[$item->pivot->product_id]=$temp;
            }
        }
        $saleorder->salesOrderProducts()->attach($list);

        $quotation->update(['is_converted_list' => 1]);

        return redirect('sales_order/draft_salesorders');
    }

    public function ajaxQtemplatesProducts($qtemplate)
    {
        $qtemplateProduct = $this->quotationTemplateRepository->find($qtemplate);
        $templateProduct = [];
        foreach ($qtemplateProduct->qTemplateProductsList as $product){
            $product->description = $product->products->description;
            $templateProduct[] = $product;
            //$details = $product->products();
        }
        return $templateProduct;
    }

    public function newprintQuot($quotation)
    {

  //$saleorder = $this->salesOrderRepository->find(2);

$quotation = $this->quotationRepository->find($quotation);
  $this->generateParams();
  //$this->emailRecipients($quotation->customer_id);

  $sales_team = $this->salesTeamRepository->find($quotation->sales_team_id);
  $team_leader = $this->userRepository->all()->where('id',$sales_team->team_leader)->pluck('full_name','id')->toArray();
  $sales_team_members = $sales_team->members->pluck('full_name','id')->toArray();
  $main_staff = $team_leader+$sales_team_members;


        $filename = 'Quotation-' . $quotation->quotations_number;
        $pdf = App::make('dompdf.wrapper');
        /* defaultMediaType: "screen" (available in config/dompdf.php)
        defaultPaperSize: "a4" (available in config/dompdf.php)
        defaultFont: "serif" (available in config/dompdf.php)
        dpi: 96 (available in config/dompdf.php)
        fontHeightRatio: 1.1 (available in config/dompdf.php)
        isPhpEnabled: false (available in config/dompdf.php)
        isRemoteEnabled: true (available in config/dompdf.php)
        isJavascriptEnabled: true (available in config/dompdf.php)
        isHtml5ParserEnabled: false (available in config/dompdf.php)
        isFontSubsettingEnabled: false (available in config/dompdf.php) */

        //$pdf->setPaper('a4','landscape');
        //return view('quotation_template.quotation_long', compact('title', 'quotation','main_staff'));
        if($quotation->is_service) {
          $pdf->loadView('quotation_template.quotation_long', compact('title', 'quotation','main_staff'));
        } else {
          $pdf->loadView('quotation_template.quotation_short', compact('title', 'quotation','main_staff'));
        }


        return $pdf->download($filename . '.pdf');
    }



    public function printQuot($quotation)
    {
        $quotation = $this->quotationRepository->find($quotation);
        $filename = 'Quotation-' . $quotation->quotations_number;
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4','landscape');
        //echo Settings::get('quotation_template');
        $pdf->loadView('quotation_template.'.Settings::get('quotation_template'), compact('quotation'));
        return $pdf->download($filename . '.pdf');
    }

    public function ajaxCreatePdf($quotation)
    {
        $quotation = $this->quotationRepository->find($quotation);
        $filename = 'Quotation-' .Str::slug($quotation->quotations_number);
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4','landscape');
        $pdf->loadView('quotation_template.'.Settings::get('quotation_template'), compact('quotation'));
        $pdf->save('./pdf/' . $filename . '.pdf');
        $pdf->stream();
        echo url("pdf/" . $filename . ".pdf");

    }

    public function sendQuotation(Request $request)
    {
        $email_subject = $request->email_subject;
        $to_customers = $this->customerRepository->all()->whereIn('user_id', $request->recipients);
        $email_body = $request->message_body;
        $message_body = Common::parse_template($email_body);
        $quotation_pdf = $request->quotation_pdf;

        $site_email = Settings::get('site_email');
        if (!empty($to_customers) && !filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
            foreach ($to_customers as $item) {
                 if (!filter_var($item->user->email, FILTER_VALIDATE_EMAIL) === false) {
                     Mail::to($item->user->email)->send(new SendQuotation([
                         'from' => $site_email,
                         'subject' => $email_subject,
                         'message_body' => $message_body,
                         'quotation_pdf' => $quotation_pdf
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
            echo '<div class="alert alert-success">' . trans('quotation.success') . '</div>';
        } else {
            echo '<div class="alert alert-danger">' . trans('invoice.error') . '</div>';
        }
    }

    public function makeInvoice($quotation)
    {
        $user = $this->userRepository->getUser();

        $quotation = $this->quotationRepository->find($quotation);
        if(!$quotation){
            abort(404);
        }
        $invoice = $this->invoiceRepository->getAll()->withDeleteList()->get()->count();
        if($invoice == 0){
            $total_fields = 0;
        }else{
            $total_fields = $this->invoiceRepository->getAll()->withDeleteList()->get()->last()->id;
        }

        $start_number = Settings::get('invoice_start_number');
        $invoice_number = Settings::get('invoice_prefix') . ( is_int($start_number)?$start_number:0 + (isset($total_fields) ? $total_fields : 0) + 1);

        $invoice = $this->invoiceRepository->create([
            'quotation_id' => $quotation->id,
            'customer_id' => $quotation->customer_id,
            'sales_person_id' => $quotation->sales_person_id,
            'sales_team_id' => $quotation->sales_team_id,
            'invoice_number' => $invoice_number,
            'invoice_date' => date(config('settings.date_format')),
            'due_date' => $quotation->expire_date,
            'payment_term' => isset($quotation->payment_term)?$quotation->payment_term:0,
            'status' => 'Open Invoice',
            'total' => $quotation->total,
            'tax_amount' => $quotation->tax_amount,
            'grand_total' => $quotation->grand_total,
            'unpaid_amount' => $quotation->final_price,
            'discount' => $quotation->discount,
            'final_price' => $quotation->final_price,
            'user_id' => $user->id
        ]);
        $list =[];
        if (!empty($quotation->quotationProducts->count() > 0)) {
            foreach ($quotation->quotationProducts as $key=>$item) {
                $temp['quantity']=$item->pivot->quantity;
                $temp['price']=$item->pivot->price;
                $list[$item->pivot->product_id]=$temp;
            }
        }
        $invoice->invoiceProducts()->attach($list);

        $quotation->update(['is_quotation_invoice_list' => 1]);
        return redirect('invoice');
    }

    private function generateParams()
    {
        $products = $this->productRepository->orderBy("id", "desc")->all();


        $_qplatform = $this->optionRepository->getAll()
            ->where('category', 'function_type')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('quotation.seltitle'), '');


        $_quote_type = $this->optionRepository->getAll()
            ->where('category', 'quote_type')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('quotation.seltitle'), '');

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
                ->orderBy("id", "asc")
                ->pluck('salesteam', 'id')
                ->prepend(trans('quotation.sales_team_id'), '');

                $customers = $this->customerRepository->getCustomerContact(0)
                                                        ->pluck('name', 'id')
                                                        ->prepend(trans('dashboard.select_customer'), '');


        $companies_mail = $this->userRepository->getAll()->get()->filter(function ($user) {
            return $user->inRole('customer');
        })->pluck('full_name', 'id');

        $statuses = $this->optionRepository->getAll()
            ->where('category', 'quotation_status')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('quotation.status'), '');

        $sales_tax = Settings::get('sales_tax');

        view()->share('_qplatform',$_qplatform);
        view()->share('_quote_type',$_quote_type);
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

    public function ajaxSalesTeamList( Request $request){
        $agent_name = $this->customerRepository->all()->where('user_id',$request->id)->pluck('sales_team_id','user_id');
        $agent_name = $agent_name[$request->id];
        $sales_team = $this->salesTeamRepository->all()->pluck('salesteam','id')->prepend(trans('quotation.sales_team_id'), '');
        return ['agent_name'=>$agent_name,'sales_team' => $sales_team];
    }
    private function emailRecipients($customer_id){
        $email_recipients = $this->userRepository->getParentCustomers()->where('id',$customer_id)->pluck('full_name','id');
        view()->share('email_recipients', $email_recipients);
    }
}
