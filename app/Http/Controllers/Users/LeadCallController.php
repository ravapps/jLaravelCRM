<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Http\Requests\CallRequest;
use App\Repositories\CallRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\LeadRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class LeadCallController extends UserController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CallRepository
     */
    private $callRepository;

    private $leadRepository;

    /**
     * LeadCallController constructor.
     * @param CompanyRepository $companyRepository
     * @param UserRepository $userRepository
     * @param CallRepository $callRepository
     */
    public function __construct(CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                CallRepository $callRepository,
                                LeadRepository $leadRepository
    )
    {
        parent::__construct();

        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->callRepository = $callRepository;
        $this->leadRepository = $leadRepository;

        view()->share('type', 'leadcall');
    }

    public function index($lead)
    {
        $lead = $this->leadRepository->find($lead);
        $title = trans('call.lead_calls');
        return view('user.leadcall.index', compact('title', 'lead'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lead)
    {
        $lead = $this->leadRepository->find($lead);
        $title = trans('call.lead_new');

        $this->generateParams();

        return view('user.leadcall.create', compact('title', 'lead'));
    }

    public function store($lead, CallRequest $request)
    {
        $lead = $this->leadRepository->find($lead);
        $user_id = $this->userRepository->getUser()->id;
        $lead->calls()->create($request->all(), ['user_id' => $user_id]);

        return redirect("leadcall/" . $lead->id);
    }

    public function edit($lead, $call)
    {
        $call = $this->callRepository->find($call);
        $lead = $this->leadRepository->find($lead);
        $title = trans('call.lead_edit');

        $this->generateParams();

        return view('user.leadcall.create', compact('title', 'call', 'lead'));
    }

    public function update(CallRequest $request, $lead, $call)
    {
        $call = $this->callRepository->find($call);
        $lead = $this->leadRepository->find($lead);
        $call->update($request->all());

        return redirect("leadcall/" . $lead->id);
    }


    public function delete($lead, $call)
    {
        $call = $this->callRepository->find($call);
        $lead = $this->leadRepository->find($lead);
        $title = trans('call.lead_delete');
        return view('user.leadcall.delete', compact('title', 'call', 'lead'));
    }


    public function destroy($lead, $call)
    {
        $call = $this->callRepository->find($call);
        $lead = $this->leadRepository->find($lead);
        $call->delete();
        return redirect('leadcall/' . $lead->id);
    }

    public function data($lead,Datatables $datatables)
    {
        $lead = $this->leadRepository->find($lead);
        $calls = $lead->calls()
            ->with('responsible', 'company')
            ->get()
            ->map(function ($call) use ($lead) {
                return [
                    'id' => $call->id,
                    'date' => $call->date,
                    'call_summary' => $call->call_summary,
                    'lead' => $lead->id,
                    'responsible' => isset($call->customer->user) ? $call->customer->user->full_name : '',
                ];
            });

        return $datatables->collection($calls)
            ->addColumn('actions', '@if(Sentinel::getUser()->hasAccess([\'logged_calls.write\']) || Sentinel::inRole(\'admin\'))
<a href="{{ url(\'call/\'  . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                            @endif
                                            @if(Sentinel::getUser()->hasAccess([\'logged_calls.delete\']) || Sentinel::inRole(\'admin\'))
                                     <a href="{{ url(\'call/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>@endif')
            ->removeColumn('id')
            ->removeColumn('lead')
            ->rawColumns(['actions'])
            ->make();
    }

    private function generateParams()
    {
        $companies = $this->companyRepository->getAll()->orderBy("name", "asc")
	            ->pluck('name', 'id')
	            ->prepend(trans('dashboard.select_company'), '');

        $staffs = $this->userRepository->getStaff()
	            ->pluck('full_name', 'id')
	            ->prepend(trans('dashboard.select_team'), '');

        view()->share('staffs', $staffs);
        view()->share('companies', $companies);
    }

}
