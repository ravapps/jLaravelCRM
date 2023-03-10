<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Thumbnail;
use App\Helpers\ExcelfileValidator;
use App\Http\Controllers\UserController;
use App\Http\Requests\CustomerRequest;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyBranchRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\OptionRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use DB;
use Efriandika\LaravelSettings\Facades\Settings;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;



class CustomerController extends UserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    private $companyBranchRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var ExcelRepository
     */
    private $excelRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    private $customerRepository;

    private $opportunityRepository;

    private $quotationRepository;

    private $salesOrderRepository;

    private $invoiceRepository;

    /**
     * CustomerController constructor.
     *
     * @param UserRepository $userRepository
     * @param CompanyRepository $companyRepository
     * @param SalesTeamRepository $salesTeamRepository
     * @param ExcelRepository $excelRepository
     * @param OptionRepository $optionRepository
     */
    public function __construct(
        UserRepository $userRepository,
        CompanyRepository $companyRepository,
        CompanyBranchRepository $companyBranchRepository,
        SalesTeamRepository $salesTeamRepository,
        ExcelRepository $excelRepository,
        OptionRepository $optionRepository,
        CustomerRepository $customerRepository,
        OpportunityRepository $opportunityRepository,
        QuotationRepository $quotationRepository,
        SalesOrderRepository $salesOrderRepository,
        InvoiceRepository $invoiceRepository
    )
    {
        parent::__construct();

        $this->middleware('authorized:contacts.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:contacts.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:contacts.delete', ['only' => ['delete']]);

        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->companyBranchRepository = $companyBranchRepository;
        $this->salesTeamRepository = $salesTeamRepository;
        $this->excelRepository = $excelRepository;
        $this->optionRepository = $optionRepository;
        $this->customerRepository = $customerRepository;
        $this->opportunityRepository = $opportunityRepository;
        $this->quotationRepository = $quotationRepository;
        $this->salesOrderRepository = $salesOrderRepository;
        $this->invoiceRepository = $invoiceRepository;

        view()->share('type', 'customer');
    }


    public function createcompany( CustomerRequest $request ) {
      if(str_contains(url()->previous(),'create')) {
        return redirect()->route('company.create')
        ->with('editid', 0)
        ->with('editaction','no')
        ->with('idone',$request->idone)
        ->with('idtwo',$request->idtwo)
        ->with('nextaction','customer');
      } elseif(str_contains(url()->previous(),'edit')) {
        $getid = explode("/",url()->previous());
        return redirect()->route('company.create')
        ->with('editid',  $getid[count($getid)-2])
        ->with('editaction','yes')
        ->with('idone',$request->idone)
        ->with('idtwo',$request->idtwo)
        ->with('nextaction','customer');
      } else {
        return redirect(url()->previous());
      }
    }



    public function createsite( $company ) {
      if(str_contains(url()->previous(),'create')) {
        return redirect()->route('company.edit', ['company'=>$company])
        ->with('editid', 0)
        ->with('editaction','no')
        ->with('idone',$company)
        ->with('idtwo',0)
        ->with('nextaction','customer');
      } elseif(str_contains(url()->previous(),'edit')) {
        $getid = explode("/",url()->previous());
        return redirect()->route('company.edit', ['company'=>$company])
        ->with('editid',  $getid[count($getid)-2])
        ->with('editaction','yes')
        ->with('idone',$company)
        ->with('idtwo',0)
        ->with('nextaction','customer');
      } else {
        return redirect(url()->previous());
      }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('customer.agent');

        return view('user.customer.index', compact('title', 'companies', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('customer.new');
        if(!empty(request()->session()->get('nextaction'))) {

         //$title = $title.' ('.trans('quotation.convertlead').')';
         view()->share('nextaction', request()->session()->get('nextaction'));
         view()->share('editid', request()->session()->get('editid'));
         view()->share('editaction', request()->session()->get('editaction'));
         view()->share('idone', request()->session()->get('idone'));
         view()->share('idtwo', request()->session()->get('idtwo'));

       } else {
           $nextaction = "";
           view()->share('nextaction', $nextaction);
       }

       if(!empty(request()->session()->get('companyid'))) {
         view()->share('ofcompanyid', request()->session()->get('companyid') );
       }

        $this->generateParams();

        return view('user.customer.create', compact('title'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        $request->merge(['password'=>str_random(8)]);
        $user = Sentinel::registerAndActivate($request->only('first_name', 'last_name', 'email', 'password','user_avatar'));
        $role = Sentinel::findRoleBySlug('customer');
        $role->users()->attach($user);

        $user = $this->userRepository->find($user->id);

        if ($request->hasFile('user_avatar_file')) {
            $file = $request->file('user_avatar_file');
            $file = $this->userRepository->uploadAvatar($file);
            $request->merge([
                'user_avatar' => $file->getFileInfo()->getFilename(),
            ]);
            $user->user_avatar = basename($file);
            $this->userRepository->generateThumbnail($file);
        }
        $user->phone_number = $request->phone_number; //already saving with registerAndActivate?,check above
        $user->password = bcrypt($request->password);
        $user->user_id = $this->user->id;
        $user->save();
        $request->merge(['user_id'=>$user->id]);
        $request->merge(['address'=>$request->branch_id]);

          if($request->ismain == "ismain") {
            $request->merge(['is_main_contact'=>'1']);
          } else {
            $request->merge(['is_main_contact'=>'0']);
          }
//var_dump($request);
        $customer = $this->customerRepository->create($request->except('first_name', 'last_name', 'phone_number', 'email', 'password',
            'password_confirmation', 'user_avatar_file','user_avatar','ismain','editid','editaction','idone','idtwo','nextaction'));
        $customer->user_id = $user->id;
        $customer->belong_user_id = Sentinel::getUser()->id;
        $customer->save();

        try {
          $subject = 'Customer login details';
          if(str_contains(url('/'),'localhost') == false) {
           if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
              Mail::send('emails.new_customer', array('email' => $request->email,
                  'password' => $request->password
              ), function ($m) use ($request, $subject) {
                  $m->from(Settings::get('site_email'), Settings::get('site_name'));
                  $m->to($request->email, $request->first_name . $request->last_name);
                  $m->subject($subject);
              });
           }
          }
        } catch(Exception $e) {
        }

        //exit();
        if($request->nextaction <> "") {
            if($request->editaction == "yes")
            return redirect($request->nextaction."/".$request->editid."/edit")
            ->with('customerid',  $customer->id)
            ->with('companyid',  $customer->company_id);
            else
            return redirect($request->nextaction."/create")
            ->with('customerid',  $customer->id)
            ->with('companyid',  $customer->company_id);
        } else {
            return redirect("customer");
        }
    }

    public function edit($customer ) {
      view()->share('nextaction','');
      if(!empty(request()->session()->get('companyid'))) {
        view()->share('ofcompanyid', request()->session()->get('companyid') );
      }
        $customer = $this->customerRepository->find($customer);
        $title = trans( 'customer.edit' );
        $this->generateParams();

        return view( 'user.customer.edit', compact( 'customer', 'title' ) );
    }

    public function ajaxBranchHavemain( CustomerRequest $request){
      $main_contact = $this->customerRepository->all()->where('address',$request->id)->where('is_main_contact',1);
      $details_contact = $this->companyBranchRepository->all()->where('id',$request->id)->first();
      if(count($main_contact))
        return ['have_main'=>'yes','mobile' => $details_contact->mobile,'cname' => $details_contact->contact, 'addressid' => $details_contact->id];
      else
        return ['have_main'=>'no','mobile' => $details_contact->mobile,'cname' => $details_contact->contact, 'addressid' => $details_contact->id];
    }


    public function update(CustomerRequest $request, $customer)
    {
        $customer = $this->customerRepository->find($customer);
        if ($request->hasFile('user_avatar_file')) {
            $file = $request->file('user_avatar_file');
            $file = $this->userRepository->uploadAvatar($file);

            $request->merge([
                'user_avatar' => $file->getFileInfo()->getFilename(),
            ]);

            $this->userRepository->generateThumbnail($file);
        }
        $request->merge(['address'=>$request->branch_id]);
        if($request->ismain == "ismain") {
          $request->merge(['is_main_contact'=>1]);
        } else {
          $request->merge(['is_main_contact'=>0]);
        }
        //var_dump($request);
        //exit();
        $customer->update($request->except( 'password','email',
            'password_confirmation', 'user_avatar_file','first_name','last_name','phone_number','user_avatar'));

        $user =collect($request->only('first_name','last_name','email','phone_number','user_avatar'));

        if ($request->password != null) {
            $user = $user->merge(['password' => bcrypt($request->password)]);
        }

        if (isset($customer->company_avatar) && $customer->company_avatar!="") {
            $user = $user->merge(['user_avatar' => $customer->company_avatar]);
        }

        $user = $user->toArray();
        $this->userRepository->find($customer->user_id)->update($user);
        return redirect("customer");
    }

    public function ajaxCustomersDetails( CustomerRequest $request)
    {
      $customers = $this->customerRepository->getCustomerDetails($request->id)->first();
    	return ['mobile'=>$customers->mobile,'phone'=>$customers->phone,'email'=>$customers->email];
    }

    public function ajaxCustomersList( CustomerRequest $request)
    {
    	$customers = $this->customerRepository->getCustomerContact($request->id)
    																					->pluck('name', 'id');
    	return ['customer_name'=>$customers];
    }

    public function show($customer) {
        $customer = $this->customerRepository->find($customer);
        $title  = trans( 'customer.details' );
        $this->generateParams();

        $action = "show";
        $customer->load('salesTeam');


        return view( 'user.customer.show', compact( 'title', 'customer', 'action' ) );
    }

    public function delete($customer)
    {

        $customer = $this->customerRepository->find($customer);

      $branchdetails = $this->companyBranchRepository->all()
      ->where('id',$customer->address);

        $title = trans('customer.delete');
        $this->generateParams();
        return view('user.customer.delete', compact('title', 'customer','branchdetails'));
    }

    public function destroy($customer)
    {
        $customer = $this->customerRepository->find($customer);
        //$customer->user()->delete();
        $customer->delete();
        return redirect('customer');
    }

    public function data(Datatables $datatables)
    {
        $customers = $this->customerRepository->all()->map(function($user){
            $customerOpportunity = $this->opportunityRepository->all()->where('customer_id',$user->user_id)->count();
            $deletedOpportunity = $this->opportunityRepository->getAll()->onlyDeleteLists()->where('customer_id',$user->user_id)->get()->count();
            $customerQuotation = $this->quotationRepository->all()->where('customer_id',$user->user_id)->count();
            $deletedQuotation = $this->quotationRepository->getAll()->onlyDeleteLists()->where('customer_id',$user->user_id)->get()->count();
            $customerSaleorder = $this->salesOrderRepository->all()->where('customer_id',$user->user_id)->count();
            $deletedSaleorder = $this->salesOrderRepository->getAll()->onlyDeleteLists()->where('customer_id',$user->user_id)->get()->count();
            $customerInvoice = $this->invoiceRepository->all()->where('customer_id',$user->user_id)->count();
            $deletedInvoice = $this->invoiceRepository->getAll()->onlyDeleteLists()->where('customer_id',$user->user_id)->get()->count();
            //var_dump($user);
            return [
                'full_name' => isset($user->user->full_name)?$user->user->full_name:null,
                'company_id' => isset($user->company->name)?$user->company->name:null,
                'email' => isset($user->user->email)?$user->user->email:null,
                'phone_number' => isset($user->user->phone_number)?$user->user->phone_number:null,
                'sitelocation' => isset($user->contactSitelocation)?$user->contactSitelocation->sitelocation.' '.$user->contactSitelocation->street.' '.$user->contactSitelocation->building.' '.$user->contactSitelocation->untinofrom.' '.$user->contactSitelocation->untinoto.' '.$user->contactSitelocation->postalcode:null,
                'id' => $user->id,
                'title' => $user->title,
                'job_position' => $user->job_position,
                'mobile' => $user->mobile,
                'count_uses' => $customerOpportunity + $deletedOpportunity + $customerQuotation + $deletedQuotation
                    + $customerSaleorder + $deletedSaleorder + $customerInvoice + $deletedInvoice,
            ];
        })->values();
        return $datatables->collection($customers)
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'contacts.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'customer/\' . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                            @endif
                                     <a href="{{ url(\'customer/\' . $id . \'/show\' ) }}"  title="{{ trans(\'table.show\') }}">
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                            @if(Sentinel::getUser()->hasAccess([\'contacts.delete\']) && $count_uses==0 || Sentinel::inRole(\'admin\') && $count_uses==0)
                                            <a href="{{ url(\'customer/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>@endif')
            ->removeColumn('count_uses')
            ->rawColumns(['actions'])->make();
    }

    public function importExcelData(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv|max:5000',
        ]);

        $reader = $this->excelRepository->load($request->file('file'));

        $users = $reader->all()->map(function ($row) {
            return [
                'email' => $row->email,
                'password' => $row->password,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'mobile' => $row->mobile,
                'fax' => $row->fax,
                'website' => $row->website,
            ];
        });

        foreach ($users as $userData) {
            if (!$customer = \App\Models\User::whereEmail($userData['email'])->first()) {
                $customer = $this->userRepository->create($userData);

                $customer->customer()->create($userData);
                $this->userRepository->assignRole($customer, 'customer');
            }
        }

        return response()->json([], 200);
    }

    public function downloadExcelTemplate()
    {
        if (ob_get_length()) ob_end_clean();
        return response()->download(base_path('resources/excel-templates/contacts.xlsx'));
    }

    private function generateParams()
    {

      //  $salesteams = $this->salesTeamRepository->getAll()->orderBy("id", "asc")
      //      ->pluck('salesteam', 'id')
      //      ->prepend(trans('dashboard.select_sales_team'), '');

        $branches = $this->companyBranchRepository->all()
            ->where('id',0)
            ->pluck('branch_select', 'id')
            ->prepend(trans('Select....'), '');

        $companies = $this->companyRepository->getAll()->orderBy("name", "asc")
            ->pluck('name', 'id')
            ->prepend(trans('dashboard.select_company'), '');
        $titles = $this->optionRepository->getAll()
            ->where('category', 'titles')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('customer.title'), '');
      //  view()->share('salesteams', $salesteams);
        view()->share('companies', $companies);
        view()->share('branches', $branches);
        view()->share('titles', $titles);
    }


    public function getImport()
    {
        $title = trans('customer.customers');

        return view('user.customer.import', compact('title'));
    }

    public function postImport(Request $request)
    {

        //~ $this->validate($request, [
        //~ 'file' => 'required|mimes:xlsx,xls,csv|max:5000',
        //~ ]);
        if (!ExcelfileValidator::validate($request)) {
            return response('invalid File or File format', 500);
        }


        $reader = $this->excelRepository->load($request->file('file'));


        $titles = $this->optionRepository->getAll()
            ->where('category', 'titles')
            ->get()
            ->map(function ($title) {
                return $title->title;
            })->values()
            ->toArray();


        $customers = $reader->all()->map(function ($row) use ($titles) {
            return [
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                'phone_number' => $row->phone,
                'title' => in_array($row->title, $titles) ? $row->title : null,
                'password' => $row->password,
                'password_confirmation' => $row->password,
                'mobile' => $row->mobile,
                'website' => $row->website,
                'fax' => $row->fax,
            ];
        });

        $companies = $this->companyRepository->getAll()->get()->map(function ($company) {
            return [
                'text' => $company->name,
                'id' => $company->id,
            ];
        })->values();

        $titles = $this->optionRepository->getAll()
            ->where('category', 'titles')
            ->get()
            ->map(function ($title) {
                return [
                    'text' => $title->title,
                    'id' => $title->value,
                ];
            })->values();

        return response()->json(compact('customers', 'companies', 'titles'), 200);
    }

    public function postAjaxStore(CustomerRequest $request)
    {
        //add user
        $userNew = $this->userRepository->create($request->only('email', 'password', 'first_name', 'last_name', 'phone_number'));

        //assign customer role to new user
        $this->userRepository->assignRole($userNew, 'customer');

        //add user to customers table
        $customer = new Customer($request->except( 'password',
            'password_confirmation', 'user_avatar_file'));
        $customer->user_id = $userNew->id;
        $customer->belong_user_id = Sentinel::getUser()->id;
        $customer->save();

        return response()->json([], 200);
    }

}
