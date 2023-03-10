<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Repositories\CompanyRepository;
use App\Repositories\OpportunityRepository;
use App\Repositories\QuotationRepository;
use App\Repositories\UserRepository;
use Yajra\Datatables\Datatables;

class OpportunityConvertedListController extends UserController
{
    private $userRepository;

    private $opportunityRepository;

    private $companyRepository;

    private $quotationRepository;

    public function __construct(
        UserRepository $userRepository,
        OpportunityRepository $opportunityRepository,
        CompanyRepository $companyRepository,
        QuotationRepository $quotationRepository
    )
    {
        parent::__construct();
        $this->opportunityRepository = $opportunityRepository;
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->quotationRepository = $quotationRepository;


        view()->share('type', 'opportunity_converted_list');
    }

    public function index()
    {

        $title = trans('opportunity.converted_list');
        return view('user.opportunity.converted_list',compact('title'));
    }


    public function data(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $convertedList = $this->opportunityRepository->getAll()->onlyConvertedLists()->get()
            ->map(function ($convertedList) use ($dateFormat){
                return [
                    'id' => $convertedList->id,
                    'opportunity' => $convertedList->opportunity,
                    'company' => $convertedList->companies->name ? $convertedList->companies->name: null,
                    'next_action' => date($dateFormat,strtotime($convertedList->next_action)),
                    'expected_closing' => date($dateFormat,strtotime($convertedList->expected_closing)),
                    'stages' => $convertedList->stages,
                    'expected_revenue' => $convertedList->expected_revenue,
                    'probability' => $convertedList->probability,
                    'sales_team_id' => $convertedList->salesTeam->salesteam,
                    'salesteam' => $convertedList->salesTeam->salesteam ? $convertedList->salesTeam->salesteam : null,
                    'agent_name' => $convertedList->customer->full_name??'',
                ];
            });

        return $datatables->collection($convertedList)
            ->addColumn('actions', '
                                    <a href="{{ url(\'convertedlist_view/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>')
            ->rawColumns(['actions'])->make();
    }
    public function quatationList($id)
    {
        $quotation_id = $this->quotationRepository->getAll()->where('opportunity_id', $id)->get()->first();
        if(isset($quotation_id)){
            return redirect('quotation/' . $quotation_id->id . '/show');
        }else{
            flash(trans('opportunity.converted_salesorder'))->error();
            return redirect('opportunity_converted_list');
        }
    }

}
