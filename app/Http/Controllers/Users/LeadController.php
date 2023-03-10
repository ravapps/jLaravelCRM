<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ExcelfileValidator;
use App\Http\Controllers\UserController;
use App\Http\Requests\LeadImportRequest;
use App\Http\Requests\LeadRequest;
use App\Repositories\CityRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\CountryRepository;
use App\Repositories\LeadRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use App\Repositories\ExcelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;


class LeadController extends UserController {
	/**
	 * @var CompanyRepository
	 */
	private $companyRepository;
	private $CustomerRepository;
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var LeadRepository
	 */
	private $leadRepository;
	/**
	 * @var SalesTeamRepository
	 */
	private $salesTeamRepository;
	/**
	 * @var OptionRepository
	 */
	private $optionRepository;

	/**
	 * @var ExcelRepository
	 */
	private $excelRepository;

    private $countryRepository;

    private $stateRepository;

    private $cityRepository;

	/**
	 * SalesTeamController constructor.
	 *
	 * @param CompanyRepository $companyRepository
	 * @param UserRepository $userRepository
	 * @param LeadRepository $leadRepository
	 * @param SalesTeamRepository $salesTeamRepository
	 * @param OptionRepository $optionRepository
	 */
	public function __construct(
		CompanyRepository $companyRepository,
		CustomerRepository $customerRepository,
		UserRepository $userRepository,
		LeadRepository $leadRepository,
		SalesTeamRepository $salesTeamRepository,
		OptionRepository $optionRepository,
		ExcelRepository $excelRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        CityRepository $cityRepository
	) {
		$this->middleware( 'authorized:leads.read', [ 'only' => [ 'index', 'data' ] ] );
		$this->middleware( 'authorized:leads.write', [ 'only' => [ 'create', 'store', 'update', 'edit' ] ] );
		$this->middleware( 'authorized:leads.delete', [ 'only' => [ 'delete' ] ] );

		parent::__construct();

		$this->companyRepository   = $companyRepository;
		$this->userRepository      = $userRepository;
		$this->customerRepository   = $customerRepository;
		$this->companyRepository   = $companyRepository;
		$this->leadRepository      = $leadRepository;
		$this->salesTeamRepository = $salesTeamRepository;
		$this->optionRepository    = $optionRepository;
		$this->excelRepository     = $excelRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;

		view()->share( 'type', 'lead' );
	}

	public function index() {
		$title = trans( 'lead.leads' );

		return view( 'user.lead.index', compact( 'title' ) );
	}


	public function ajaxLeadsList( LeadRequest $request)
	{
		$leads = $this->leadRepository->getAll()
		->where('company_id',$request->id)
		->where('customer_id',$request->cuid)
		->pluck('id', 'id');
		//var_dump($leads);
		return ['lead_name'=>$leads];
	}


	public function create() {
		$title = trans( 'lead.new' );
		$calls = 0;
		if(!empty(request()->session()->get('companyid'))) {
			view()->share('ofcompanyid', request()->session()->get('companyid') );
		}
		if(!empty(request()->session()->get('customerid'))) {
			view()->share('ofcustomerid', request()->session()->get('customerid') );
		}
		$this->generateParams();

		return view( 'user.lead.create', compact( 'title', 'calls' ) );
	}

	public function store( LeadRequest $request ) {
		$request->merge(['sales_person_id'=>$this->userRepository->getUser()->id]);
		$request->merge(['sales_team_id'=>$this->userRepository->getUser()->id]);

							$Allfiles = '';
							if($request->hasFile('document_upload'))
		          {
		              $file = $request->file('document_upload');
		              foreach($file as $key => $document1)
		                  {
		                      $filenameWithExt = $request->file('document_upload')[$key]->getClientOriginalName();
		                      $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
		                      $extension       = $request->file('document_upload')[$key]->getClientOriginalExtension();
		                      $fileNameToStore11 = $filename . '_' . time() . '.' . $extension;
		                      $dir             = storage_path('uploads/document/');
		                      $image_path      = $dir . $filenameWithExt;
		                      $document1->move(public_path().'/uploads/document/', $fileNameToStore11);
													$Allfiles = $Allfiles.$fileNameToStore11.',';
		                  }
		          }
		$request->merge(['documents'=>$Allfiles]);

		$this->leadRepository->store( $request->except('document_upload') );

		return redirect( "lead" );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($lead ) {
		view()->share('nextaction','');
		if(!empty(request()->session()->get('companyid'))) {
			view()->share('ofcompanyid', request()->session()->get('companyid') );
		}
		if(!empty(request()->session()->get('customerid'))) {
			view()->share('ofcustomerid', request()->session()->get('customerid') );
		}
	    $lead = $this->leadRepository->find($lead);
	    $title = trans( 'lead.edit' );
        $this->generateParams();
		$calls  = $lead->calls()->count();
        $states = $this->stateRepository->orderBy('name', 'asc')->findByField('country_id', $lead->country_id)->pluck('name', 'id');
        $cities = $this->cityRepository->orderBy('name', 'asc')->findByField('state_id', $lead->state_id)->pluck('name', 'id');
        $lead->load('country');
		$lead->load('state');
        $lead->load('city');

		return view( 'user.lead.edit', compact( 'lead', 'title', 'calls', 'states', 'cities' ) );
	}

	public function update( $lead, LeadRequest $request ) {
	    $lead = $this->leadRepository->find($lead);
			$request->merge(['sales_person_id'=>$this->userRepository->getUser()->id]);
			$request->merge(['sales_team_id'=>$this->userRepository->getUser()->id]);

			$Allfiles = '';
			if($request->hasFile('document_upload'))
			{
					$file = $request->file('document_upload');
					foreach($file as $key => $document1)
							{
									$filenameWithExt = $request->file('document_upload')[$key]->getClientOriginalName();
									$filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
									$extension       = $request->file('document_upload')[$key]->getClientOriginalExtension();
									$fileNameToStore11 = $filename . '_' . time() . '.' . $extension;
									$dir             = storage_path('uploads/document/');
									$image_path      = $dir . $filenameWithExt;
									$document1->move(public_path().'/uploads/document/', $fileNameToStore11);
									$Allfiles = $Allfiles.$fileNameToStore11.',';
							}
			}
$request->merge(['documents'=>$lead->documents.$Allfiles]);


		$lead->update( $request->except('document_upload') );
		return redirect( "lead" );
	}

	public function show( $lead ) {
        $lead = $this->leadRepository->find($lead);
		$title  = trans( 'lead.show' );
		$action = "show";
		$this->generateParams();

		return view( 'user.lead.show', compact( 'title', 'lead', 'action' ) );
	}


	public function createcustomer( LeadRequest $request ) {
		//exit();
		if(str_contains(url()->previous(),'create')) {
			return redirect()->route('customer.create')
			->with('editid', 0)
			->with('editaction','no')
			->with('idone',$request->idone)
			->with('idtwo',$request->idtwo)
			->with('nextaction','lead')
			->with('companyid',$request->idone);
		} elseif(str_contains(url()->previous(),'edit')) {
			$getid = explode("/",url()->previous());
			return redirect()->route('customer.create')
			->with('editid',  $getid[count($getid)-2])
			->with('editaction','yes')
			->with('idone',$request->idone)
			->with('idtwo',$request->idtwo)
			->with('nextaction','lead')
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
			->with('nextaction','lead');
		} elseif(str_contains(url()->previous(),'edit')) {
			$getid = explode("/",url()->previous());
			return redirect()->route('company.create')
			->with('editid',  $getid[count($getid)-2])
			->with('editaction','yes')
			->with('idone',0)
			->with('idtwo',0)
			->with('nextaction','lead');
		} else {
			return redirect(url()->previous());
		}
	}

	public function convert( $lead ) {
      /*  $lead = $this->leadRepository->find($lead);
		$title  = trans( 'lead.show' );
		$action = "show";
		$this->generateParams();

		return view( 'user.lead.show', compact( 'title', 'lead', 'action' ) ); */
		return redirect()->route('quotation.create')->with('leadid', $lead);
	}

	public function delete( $lead ) {
        $lead = $this->leadRepository->find($lead);
		$title = trans( 'lead.delete' );
		$this->generateParams();
        $action = "delete";
		return view( 'user.lead.delete', compact( 'title', 'lead','action' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $lead ) {
        $lead = $this->leadRepository->find($lead);
		$lead->calls()->delete();
		$lead->delete();

		return redirect( 'lead' );
	}

	public function data( Datatables $datatables ) {
	    $dateFormat = config('settings.date_format');
		$leads = $this->leadRepository->getAll()
            ->with( 'country', 'salesTeam' )
            ->get()
            ->map( function ( $lead ) use ($dateFormat){
                return [
                    'id'           => $lead->id,
                    'created_at' => date($dateFormat,strtotime($lead->created_at)),
                    'company_id' => $lead->leadCompany->name ?? null,
                    'contact_name' => isset($lead->customer->user->full_name)?$lead->customer->user->full_name:null,
                    'product_name' => $lead->product_name,
                    'email'        => $lead->email,
                    'phone'        => $lead->phone,
                    'calls'        => $lead->calls->count(),
                    'priority'     => $lead->priority,
                    'mobile' => $lead->mobile,
										'function' => $lead->function,
										'is_converted' => $lead->is_converted,
                ];
            });

		return $datatables->collection( $leads )
            ->addColumn( 'actions', '@if(Sentinel::getUser()->hasAccess([\'leads.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'lead/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i> </a>
                                        <a href="{{ url(\'leadcall/\'. $id .\'/\' ) }}" title="{{ trans(\'table.calls\') }}">
                                            <i class="fa fa-fw fa-phone text-primary"></i> <sup>{{ $calls }}</sup></a>
                                    @endif
                                     @if(Sentinel::getUser()->hasAccess([\'leads.read\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'lead/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    @endif
                                    @if(Sentinel::getUser()->hasAccess([\'leads.delete\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'lead/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
																						@if($is_converted <> 1)
																						<a href="{{ url(\'lead/\' . $id . \'/convert\' ) }}" title="{{ trans(\'table.convert\') }}">
			                                             <i class="fa fa-fw fa-hdd-o text-danger"></i> </a>
																									 @endif
                                    @endif' )
            ->removeColumn( 'calls' )
            ->rawColumns(['actions'])->make();
	}

	public function ajaxStateList( Request $request ) {
        return $this->stateRepository->orderBy('name','asc')->findByField('country_id',$request->id)->pluck('name', 'id')->prepend(trans('lead.select_state'),'');
	}



	public function ajaxCityList( Request $request ) {
        return $this->cityRepository->orderBy('name','asc')->findByField('state_id',$request->id)->pluck('name', 'id')->prepend(trans('lead.select_city'),'');
	}

	private function generateParams() {
		$priority = $this->optionRepository->getAll()->where( 'category', 'priority' )->get()
		                                   ->map( function ( $title ) {
			                                   return [
				                                   'title' => $title->title,
				                                   'value' => $title->value,
			                                   ];
		                                   } )->pluck( 'title', 'value' );
		$customers = $this->customerRepository->getCustomerContact(0)
												       	            ->pluck('name', 'id')
												       	            ->prepend(trans('dashboard.select_customer'), '');

		$titles = $this->optionRepository->getAll()->where( 'category', 'titles' )->get()
		                                 ->map( function ( $title ) {
			                                 return [
				                                 'title' => $title->title,
				                                 'value' => $title->value,
			                                 ];
		                                 } )->pluck( 'title', 'value' )
                                            ->prepend(trans('lead.select_title'), '');

		$companies = $this->companyRepository->getAll()->orderBy( "name", "asc" )->pluck( 'name', 'id' )
		                                     ->prepend( trans( 'dashboard.select_company' ), '' );

        $countries = $this->countryRepository->orderBy('name', 'asc')->pluck('name', 'id')->prepend(trans('lead.select_country'),'');
		$staffs = $this->userRepository->getStaff()->pluck( 'full_name', 'id' )
											->prepend( trans( 'dashboard.select_staff' ), '' );

		$salesteams = $this->salesTeamRepository->getAll()->orderBy( "id", "asc" )
		                                        ->pluck( 'salesteam', 'id' )
												->prepend( trans( 'dashboard.select_sales_team' ), '');

        $functions = $this->optionRepository->getAll()->where( 'category', 'function_type' )->get()
            ->map( function ( $title ) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            } )->pluck( 'title', 'value' )
            ->prepend(trans('lead.select_function'), '');

		view()->share( 'priority', $priority );
		view()->share( 'titles', $titles );
		view()->share( 'companies', $companies );
		view()->share( 'customers', $customers );
		view()->share( 'countries', $countries );
		view()->share( 'staffs', $staffs );
		view()->share( 'salesteams', $salesteams );
        view()->share( 'functions', $functions );
	}

	public function downloadExcelTemplate() {
        if (ob_get_length()) ob_end_clean();
        $path = base_path('resources/excel-templates/leads.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        return 'File not found!';
	}

	public function getImport() {
		$title = trans( 'lead.newupload' );

		//  return 'jimmy';
		return view( 'user.lead.import', compact( 'title' ) );
	}

	public function postImport( Request $request ) {

		if(! ExcelfileValidator::validate( $request ))
		{
			return response('invalid File or File format', 500);
		}

		$reader = $this->excelRepository->load( $request->file( 'file' ));
        $customers = $reader->all()->map( function ( $row ) {
			return [
				'company_name'   => $row->company,
                'company_site'   => $row->company_site,
 				'address'        => $row->address,
                'product_name'   => $row->product_name,
				'contact_name'   => $row->names,
				'email'          => $row->email,
				'function'       => $row->function,
				'phone'          => $row->phone,
				'mobile'         => $row->mobile,
                'client_name'    => $row->client_name,
				'country_id'     => 101,
                'priority'       => $row->priority,
			];
		} );

		$companies = $this->companyRepository->getAll()->get()->map( function ( $company ) {
			return [
				'text' => $company->name,
				'id'   => $company->id,
			];
		} );

		$countries = $this->countryRepository->getAll()->orderBy( "name", "asc" )
		                    ->select( 'id', DB::raw( 'name as text' ) )
							->get()->map( function ( $country ) {
								return [
									'text' => $country->text,
									'id'   => $country->id,
								];
							} );

		$salesteams = $this->salesTeamRepository->getAllLeads()->orderBy( "id", "asc" )
		                                        ->select( 'id', DB::raw( 'salesteam as text' ) )
												->get()->map( function ( $salesteam ) {
													return [
														'text' => $salesteam->text,
														'id'   => $salesteam->id,
													];
												} );
        $functions = $this->optionRepository->getAll()->where( 'category', 'function_type' )->get()
            ->map( function ( $title ) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            } )->pluck( 'title', 'value' );
        $priorities = $this->optionRepository->getAll()->where( 'category', 'priority' )->get()
            ->map( function ( $title ) {
                return [
                    'title' => $title->title,
                    'value' => $title->value,
                ];
            } )->pluck( 'title', 'value' );

		return response()->json( compact( 'customers', 'companies', 'countries', 'salesteams','functions','priorities' ), 200 );
	}

	public function postAjaxStore( LeadImportRequest $request ) {
		$this->leadRepository->store( $request->except( 'created', 'errors', 'selected' ) );

		return response()->json( [], 200 );
	}

	public function importExcelData( Request $request ) {
		$this->validate( $request, [
			'file' => 'required|mimes:xlsx,xls,csv|max:5000',
		] );

		$reader = $this->excelRepository->load( $request->file( 'file' ) );
	}


}
