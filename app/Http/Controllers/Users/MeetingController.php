<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Http\Requests\MeetingRequest;
use App\Repositories\CompanyRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\MeetingRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SalesTeamRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class MeetingController extends UserController
{
    /**
     * @var MeetingRepository
     */
    private $meetingRepository;
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    private $opportunityRepository;

    private $customerRepository;

    private $salesTeamRepository;

    public function __construct(MeetingRepository $meetingRepository,
                                CompanyRepository $companyRepository,
                                UserRepository $userRepository,
                                OptionRepository $optionRepository,
                                OpportunityRepository $opportunityRepository,
                                CustomerRepository $customerRepository,
                                SalesTeamRepository $salesTeamRepository)
    {
        $this->middleware('authorized:meetings.read', ['only' => ['index', 'data']]);
        $this->middleware('authorized:meetings.write', ['only' => ['create', 'store', 'update', 'edit']]);
        $this->middleware('authorized:meetings.delete', ['only' => ['delete']]);

        parent::__construct();

        $this->meetingRepository = $meetingRepository;
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
        $this->optionRepository = $optionRepository;
        $this->opportunityRepository = $opportunityRepository;
        $this->customerRepository = $customerRepository;
        $this->salesTeamRepository = $salesTeamRepository;

        view()->share('type', 'meeting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('meeting.meetings');

        return view('user.meeting.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('meeting.new');

        $this->generateParams();

        return view('user.meeting.create', compact('title','company_attendees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MeetingRequest $request
     * @return \Illuminate\Http\Response
     * @internal param $
     */
    public function store(MeetingRequest $request)
    {
        $company_attendees = implode(',',$request->company_attendees);
        if(isset($request->staff_attendees)){
            $staff_attendees = implode(',',$request->staff_attendees);
            $request->merge(['staff_attendees'=>$staff_attendees]);
        }
        $request->merge(['company_attendees'=>$company_attendees]);
        $this->meetingRepository->create($request->all(), ['user_id' => $this->user->id]);

        return redirect("meeting");
    }

    public function edit($meeting)
    {
        $meeting = $this->meetingRepository->find($meeting);
        $meetables = DB::table('meetables')->where('meeting_id',$meeting->id)->get();
        $meetables = $meetables->first();
        if (isset($meetables)){
            $sales_team_id = $this->opportunityRepository->find($meetables->meetable_id)->sales_team_id;

            $sales_team = $this->salesTeamRepository->find($sales_team_id);
            $team_leader = $this->userRepository->all()->where('id',$sales_team->team_leader)->pluck('full_name','id')->toArray();
            $sales_team_members = $sales_team->members->pluck('full_name','id')->toArray();
            $mainStaff = $team_leader+$sales_team_members;
        }else{
            $mainStaff = $this->userRepository->getStaff()
                ->pluck('full_name', 'id')->prepend(trans('salesteam.main_staff'),'');
        }
        $title = trans('meeting.edit');
        $this->generateParams();
        $customers=explode(',',$meeting->company_attendees);
        $company_attendee = $this->userRepository->all()->whereIn('id',$customers)->pluck('id','id')->all();
        $staff_attendees = explode(',', $meeting->staff_attendees);
        $staff_attendees = $this->userRepository->all()->whereIn('id', $staff_attendees)->pluck('id', 'id')->all();
        return view('user.meeting.create', compact('title', 'meeting', 'opportunity','staff_attendees','company_attendee','mainStaff'));
    }

    public function update(MeetingRequest $request, $meeting)
    {
        $meeting = $this->meetingRepository->find($meeting);
        $company_attendees = implode(',',$request->company_attendees);
        if(isset($request->staff_attendees)){
            $staff_attendees = implode(',',$request->staff_attendees);
            $request->merge(['staff_attendees'=>$staff_attendees]);
        }
        $request->merge(['company_attendees'=>$company_attendees,'staff_attendees'=>$request->staff_attendees]);
        $meeting->all_day = ($request->all_day) ? $request->all_day : 0;
        $meeting->update($request->all());
        return redirect("meeting");
    }


    public function delete($meeting)
    {
        $meeting = $this->meetingRepository->find($meeting);
        $title = trans('meeting.delete');
        $user = $this->userRepository->all();
        return view('user.meeting.delete', compact('title', 'meeting','user'));
    }

    public function destroy($meeting)
    {
        $meeting = $this->meetingRepository->find($meeting);
        $meeting->delete();
        return redirect('meeting');
    }

    public function data(Datatables $datatables)
    {
        $dateTimeFormat = config('settings.date_time_format');
        $user = $this->userRepository->getUser();
        $meetings = $this->meetingRepository->getAll()
            ->with('responsible')
            ->get()
            ->filter(function ($meeting) use ($user){
                return ($meeting->privacy=='Everyone' ||
                        ($meeting->privacy=='Main Staff' && $meeting->responsible_id==$user->id)
                        || $meeting->user_id == $user->id);
            })
            ->map(function ($meeting) use ($dateTimeFormat){
                return [
                    'id' => $meeting->id,
                    'meeting_subject' => $meeting->meeting_subject,
                    'starting_date' => date($dateTimeFormat,strtotime($meeting->starting_date)),
                    'ending_date' => date($dateTimeFormat,strtotime($meeting->ending_date)),
                    'responsible' => isset($meeting->responsible) ? $meeting->responsible->full_name : '',
                    'location' => $meeting->location,
                    'privacy' => $meeting->privacy,
                    'show_time_as' => $meeting->show_time_as
                ];
            });
        return $datatables->collection($meetings)
            ->addColumn('actions', ' @if(Sentinel::getUser()->hasAccess([\'meetings.write\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'meeting/\' . $id . \'/edit\' ) }}" title="{{ trans(\'table.edit\') }}" >
                                            <i class="fa fa-fw fa-pencil text-warning"></i>  </a>
                                     @endif
                                     @if(Sentinel::getUser()->hasAccess([\'meetings.delete\']) || Sentinel::inRole(\'admin\'))
                                        <a href="{{ url(\'meeting/\' . $id . \'/delete\' ) }}" title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a>
                                     @endif')
            ->rawColumns(['actions'])->make();
    }

    private function generateParams()
    {
        $companies = $this->companyRepository->getAll()->orderBy("name", "asc")->pluck('name', 'id');

        $staffs = $this->userRepository->getParentStaff()
	            ->pluck('full_name', 'id')->prepend(trans('salesteam.main_staff'),'');

        $privacy = $this->optionRepository->getAll()
            ->where('category', 'privacy')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title', 'value');

        $show_times = $this->optionRepository->getAll()
            ->where('category', 'show_times')
            ->get()
            ->map(function ($title) {
                return [
                    'title' => $title->title,
                    'value'   => $title->value,
                ];
            })->pluck('title', 'value');

        $customers = $this->customerRepository->all()->pluck('user_id','id');
        $company_customer = [];
        foreach ($customers as $customer){
            $company_customer[]=$customer;
        }
        $company_attendees = $this->userRepository->all()->whereIn('id',$company_customer)->pluck('full_name','id');

        view()->share('privacy', $privacy);
        view()->share('show_times', $show_times);
        view()->share('staffs', $staffs);
        view()->share('companies', $companies);
        view()->share('company_attendees',$company_attendees);
    }

    public function calendar()
    {
        $title = trans('meeting.meetings');
        return view('user.meeting.calendar', compact('title', 'opportunity'));
    }

    public function calendar_data()
    {
        $dateTimeFormat = config('settings.date_format').' H:i';
        $user = $this->userRepository->getUser();
        $events = array();
        $meetings = $this->meetingRepository->getAll()
            ->with('responsible')
            ->latest()->get()
            ->filter(function ($meeting) use ($user){
                return ($meeting->privacy=='Everyone' ||
                        ($meeting->privacy=='Main Staff' && $meeting->responsible_id==$user->id)
                        || $meeting->user_id == $user->id);
            })
            ->map(function ($meeting) use ($dateTimeFormat){
                return [
                    'id' => $meeting->id,
                    'title' => $meeting->meeting_subject,
                    'start_date' => date($dateTimeFormat,strtotime($meeting->starting_date)),
                    'end_date' => date($dateTimeFormat,strtotime($meeting->ending_date)),
                    'type' => 'meeting'
                ];
            });
        foreach ($meetings as $d) {
            $event = [];
            $dateFormat = config('settings.date_format');
            $timeFormat = Settings::get('time_format');
            $start_date = Carbon::createFromFormat($dateFormat.' H:i',$d['start_date'])->format('M d Y');
            $end_date = Carbon::createFromFormat($dateFormat.' H:i',$d['end_date'])->addDay()->format('M d Y');
            $event['title'] = $d['title'];
            $event['id'] = $d['id'];
            $event['start'] = $start_date;
            $event['end'] = $end_date;
            $event['allDay'] = true;
            $event['description'] = $d['title'] . '&nbsp;<a href="' . url($d['type'] . '/' . $d['id'] . '/edit') . '" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o">&nbsp;</i></a>';
            array_push($events, $event);
        }
        return json_encode($events);
    }
}
