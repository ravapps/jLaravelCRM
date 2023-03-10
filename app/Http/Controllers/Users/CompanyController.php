<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Thumbnail;
use App\Http\Controllers\UserController;
use App\Http\Requests\CompanyRequest;
use App\Repositories\CallRepository;
use App\Repositories\CityRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyBranchRepository;



use App\Repositories\CountryRepository;
use App\Repositories\EmailRepository;
use App\Repositories\InvoicePaymentRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Yajra\Datatables\Datatables;
use App\Repositories\OptionRepository;
class CompanyController extends UserController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    private $companyBranchRepository;
    private $optionRepository;
    /**
     * @var SalesTeamRepository
     */
    private $salesTeamRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;
    /**
     * @var QuotationRepository
     */
    private $quotationRepository;
    /**
     * @var SalesOrderRepository
     */
    private $salesOrderRepository;

    private $countryRepository;

    private $stateRepository;

    private $cityRepository;

    private $invoicePaymentRepository;

    private $callRepository;

    private $meetingRepository;

    private $emailRepository;

    public function __construct(CompanyRepository $companyRepository,
                                CompanyBranchRepository $companyBranchRepository,
                                SalesTeamRepository $salesTeamRepository,
                                UserRepository $userRepository,
                                InvoiceRepository $invoiceRepository,
                                QuotationRepository $quotationRepository,
                                SalesOrderRepository $salesOrderRepository,
                                CountryRepository $countryRepository,
                                OptionRepository $optionRepository,
                                StateRepository $stateRepository,
                                CityRepository $cityRepository,
                                InvoicePaymentRepository $invoicePaymentRepository,
                                CallRepository $callRepository,
                                MeetingRepository $meetingRepository,
                                EmailRepository $emailRepository
    )
    {
        parent::__construct();

        $this->middleware('authorized:contacts.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:contacts.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:contacts.delete', ['only' => ['delete']]);

        $this->companyRepository = $companyRepository;
        $this->companyBranchRepository = $companyBranchRepository;
        $this->optionRepository = $optionRepository;

        $this->salesTeamRepository = $salesTeamRepository;
        $this->userRepository = $userRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->quotationRepository = $quotationRepository;
        $this->salesOrderRepository = $salesOrderRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
        $this->invoicePaymentRepository = $invoicePaymentRepository;
        $this->callRepository = $callRepository;
        $this->meetingRepository = $meetingRepository;
        $this->emailRepository = $emailRepository;

        view()->share('type', 'company');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('company.companies');
        return view('user.company.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CompanyRequest $request)
    {
        $title = trans('company.new');

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

        $this->generateParams();


        return view('user.company.create', compact('title','request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {

        if ($request->hasFile('company_avatar_file')) {
            $file = $request->file('company_avatar_file');
            $file = $this->companyRepository->uploadAvatar($file);

            $request->merge([
                'company_avatar' => $file->getFileInfo()->getFilename(),
            ]);
            $this->generateThumbnail($file);
        }

        $company = $this->companyRepository->create($request->except('company_avatar_file','groupbranch','editid','editaction','idone','idtwo','nextaction'));
        $dataSet = [];
        if(!empty($request->groupbranch)) {
          foreach($request->groupbranch as $key => $ite) {
            $dataSet = $ite;
            $dataSet['company_id'] = $company->id;
            $referce = $this->companyBranchRepository->create($dataSet);
            unset($referce);
          }
        }

        // have to add user here for the company after clarification on email
        if($request->nextaction <> "") {
            if($request->editaction == "yes")
            return redirect($request->nextaction."/".$request->editid."/edit")
            ->with('companyid', $company->id);
            else
            return redirect($request->nextaction."/create")
            ->with('companyid', $company->id);
        } else {
            return redirect("company");
        }

    }

    public function edit($company)
    {


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

        $company = $this->companyRepository->find($company);
        $title = trans('company.edit');
        $states = $this->stateRepository->orderBy('name', 'asc')->findByField('country_id', $company->country_id)->pluck('name', 'id');
        $cities = $this->cityRepository->orderBy('name', 'asc')->findByField('state_id', $company->state_id)->pluck('name', 'id');

        $this->generateParams();

        return view('user.company.edit', compact('title', 'company','cities','states'));
    }

    public function update(CompanyRequest $request, $company)
    {
        $company = $this->companyRepository->find($company);
        if ($request->hasFile('company_avatar_file')) {
            $file = $request->file('company_avatar_file');
            $file = $this->companyRepository->uploadAvatar($file);

            $request->merge([
                'company_avatar' => $file->getFileInfo()->getFilename(),
            ]);
            $this->generateThumbnail($file);
        }

        $company->update($request->except('company_avatar_file','groupbranch','editid','editaction','idone','idtwo','nextaction'));
        $dataSet = [];

        $idsnottodel = '0';
        if(!empty($request->groupbranch)) {
          foreach($request->groupbranch as $key => $ite) {
            $dataSet = $ite;
            $dataSet['company_id'] = $company->id;

            if( $ite['siteid'] <> '') {
                $dataSet['id'] = $ite['siteid'];
                unset($dataSet['siteid']);
                $idsnottodel = $idsnottodel.",".$ite['siteid'];
                $referce = $this->companyBranchRepository->find($ite['siteid']);
                $referce->update($dataSet);
            } else {

              unset($dataSet['siteid']);
              $newid = $this->companyBranchRepository->create($dataSet);
              $idsnottodel = $idsnottodel.",".$newid->id;

            }

            unset($dataSet);
          }
        }

        if($idsnottodel != '0') {
          $cbtodel = $this->companyBranchRepository->getAllForCompany($company->id)->whereNotIn('id',explode(",",$idsnottodel));
          $cbtodel->delete();
          unset($cbtodel);
        }


        if($request->nextaction <> "") {
            if($request->editaction == "yes")
            return redirect($request->nextaction."/".$request->editid."/edit")
            ->with('companyid', $company->id);
            else
            return redirect($request->nextaction."/create")
            ->with('companyid',  $company->id);
        } else {
            return redirect("company");
        }

    }

    public function show($company)
    {
        $company = $this->companyRepository->find($company);
        $title = trans('company.details');
        $action = 'show';

        $agent_id = $company->customerCompany->pluck('user_id','user_id');
        $open_invoices = round($this->invoiceRepository->all()->where('status',trans('invoice.open_invoice'))->whereIn('customer_id',$agent_id)->sum('final_price'), 3);
        $overdue_invoices = round($this->invoiceRepository->all()->where('status',trans('invoice.overdue_invoice'))->whereIn('customer_id',$agent_id)->sum('unpaid_amount'), 3);
        $paid_invoices = round($this->invoiceRepository->getAll()->onlyPaidLists()->get()->whereIn('customer_id',$agent_id)->sum('final_price'),3);
        $total_invoices = round($this->invoiceRepository->all()->where('is_delete_list',0)->where('status',trans('invoice.open_invoice'))->whereIn('customer_id',$agent_id)->sum('final_price'),3);

        $quotations_total = round($this->quotationRepository->all()->whereIn('customer_id',$agent_id)->sum('final_price'), 3);;
        $salesorder_total = round($this->salesOrderRepository->all()->whereIn('customer_id',$agent_id)->sum('final_price'), 3);;

        $salesorder =  $this->salesOrderRepository->all()->whereIn('customer_id',$agent_id)->count();

        $invoices =  $this->invoiceRepository->getAll()->where([
            ['status','!=',trans('invoice.paid_invoice')]
        ])->whereIn('customer_id',$agent_id)->count();


        $quotations =  $this->quotationRepository->all()->whereIn('customer_id',$agent_id)->count();

        $calls = $this->callRepository->all()->where('company_id',$company->id)->count();

        $meeting = $this->meetingRepository->all()->where('company_name',$company->id)->count();

        $emails = $this->emailRepository->all()->whereIn('to',$agent_id)->count();

        return view('user.company.delete', compact('title', 'company','action','total_invoices','open_invoices','paid_invoices',
            'quotations_total','salesorder','quotations','invoices','calls','meeting','emails','overdue_invoices',
            'salesorder_total'));
    }

    public function delete($company)
    {
        $company = $this->companyRepository->find($company);
        $title = trans('company.delete');

        $agent_id = $company->customerCompany->pluck('user_id','user_id');
        $open_invoices = round($this->invoiceRepository->all()->where('status',trans('invoice.open_invoice'))->whereIn('customer_id',$agent_id)->sum('final_price'), 3);
        $overdue_invoices = round($this->invoiceRepository->all()->where('status',trans('invoice.overdue_invoice'))->whereIn('customer_id',$agent_id)->sum('unpaid_amount'), 3);
        $paid_invoices = round($this->invoiceRepository->getAll()->onlyPaidLists()->get()->whereIn('customer_id',$agent_id)->sum('final_price'),3);
        $total_invoices = round($this->invoiceRepository->all()->where('is_delete_list',0)->where('status',trans('invoice.open_invoice'))->whereIn('customer_id',$agent_id)->sum('final_price'),3);

        $quotations_total = round($this->quotationRepository->all()->whereIn('customer_id',$agent_id)->sum('final_price'), 3);;
        $salesorder_total = round($this->salesOrderRepository->all()->whereIn('customer_id',$agent_id)->sum('final_price'), 3);;

        $salesorder =  $this->salesOrderRepository->all()->whereIn('customer_id',$agent_id)->count();

        $invoices =  $this->invoiceRepository->getAll()->where([
            ['status','!=',trans('invoice.paid_invoice')]
        ])->whereIn('customer_id',$agent_id)->count();


        $quotations =  $this->quotationRepository->all()->whereIn('customer_id',$agent_id)->count();

        $calls = $this->callRepository->all()->where('company_id',$company->id)->count();

        $meeting = $this->meetingRepository->all()->where('company_name',$company->id)->count();

        $emails = $this->emailRepository->all()->whereIn('to',$agent_id)->count();

        return view('user.company.delete', compact('title', 'company','action','total_invoices','open_invoices','paid_invoices',
            'quotations_total','salesorder','quotations','invoices','calls','meeting','emails','overdue_invoices',
            'salesorder_total'));
    }

    public function destroy($company)
    {
//var_dump($company);
//exit();
        $company = $this->companyRepository->find($company);
        $company->delete();

        $cbtodel = $this->companyBranchRepository->getAllForCompany($company->id);
        $cbtodel->delete();


        return redirect('company');
    }

    public function data(Datatables $datatables)
    {
        $company = $this->companyRepository->getAll()
            ->with('contactPerson','opportunityCompany','country','state','city')
            ->get()
            ->map(function ($comp) {
              $strSt = '';
              foreach($comp->companybranches as $key => $st) {
                $strSt =   $strSt.($key+1).'. '.$st->sitelocation.' '.$st->street.' '.$st->unitnofrom.' '.$st->unitnoto.' '.$st->building.' '.$st->postalcode.' ('.$st->branchcategory.') '.$st->contact.' '.$st->mobile.'<br>';
              }
            return [
                'id' => $comp->id,
                'name' => $comp->name,
                'website' => $comp->website,
//                'customer' => isset($comp->contactPerson) ?$comp->contactPerson->full_name : '--',
                'phone' => $comp->phone,
                'mobile' => $comp->mobile,
                'officeaddress' => $comp->mstreet.' '.$comp->munitnofrom.' '.$comp->munitnoto.' '.$comp->mbuilding.' '.$comp->mpostalcode,
                'sitelocations' => $strSt,
                'country_id' => $comp->country->name ?? null,
                'state_id' => $comp->state->name ?? null,
                'city_id' => $comp->city->name ?? null,
                'count_uses' => $comp->customerCompany->count()+
                    $comp->opportunityCompany->count()
            ];
        });

        return $datatables->collection($company)

            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'contacts.write\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'company/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning "></i> </a>
                                    @endif
                                    <a href="{{ url(\'company/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    @if(Sentinel::getUser()->hasAccess([\'contacts.delete\']) && $count_uses==0 || Sentinel::inRole(\'admin\') && $count_uses==0)
                                    <a href="{{ url(\'company/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                       @endif')

            ->removeColumn('count_uses')
            ->rawColumns(['actions','sitelocations'])->make();

    }

    private function generateParams()
    {
        $countries = $this->countryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend(trans('company.select_country'), '');


        $categories = $this->optionRepository->getAll()
            ->where('category', 'branchcategory')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            })->pluck('title', 'value')->prepend(trans('quotation.seltitle'), '');


        view()->share('countries', $countries);
        view()->share('categories', $categories);
    }


    public function ajaxBranchList( CompanyRequest $request){
        $branch_name = $this->companyBranchRepository->all()->where('company_id',$request->id)->pluck('branch_select','id');
        return ['branch_name'=>$branch_name];
    }



    /**
     * @param $file
     */
    private function generateThumbnail($file)
    {
        Thumbnail::generate_image_thumbnail(public_path() . '/uploads/company/' . $file->getFileInfo()->getFilename(),
            public_path() . '/uploads/company/' . 'thumb_' . $file->getFileInfo()->getFilename());
    }


}
