<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\UserController;
use App\Repositories\SalesOrderRepository;
use Yajra\Datatables\Datatables;

class SalesorderDeleteListController extends UserController
{

    private $salesOrderRepository;

    public function __construct(
        SalesOrderRepository $salesOrderRepository
    )
    {
        parent::__construct();
        $this->salesOrderRepository = $salesOrderRepository;


        view()->share('type', 'salesorder_delete_list');
    }
    public function index()
    {
        $title = trans('sales_order.delete_list');
        return view('user.salesorder_delete_list.index',compact('title'));
    }

    public function show($saleorder)
    {
        $saleorder = $this->salesOrderRepository->getAll()->onlyDeleteLists()->find($saleorder);
        $title = trans('sales_order.show_delete_list');
        $action = 'show';
        return view('user.salesorder_delete_list.show', compact('title', 'saleorder','action'));
    }

    public function delete($saleorder){
        $saleorder = $this->salesOrderRepository->getAll()->onlyDeleteLists()->find($saleorder);
        $title = trans('sales_order.restore_delete_list');
        $action = 'delete';
        return view('user.salesorder_delete_list.restore', compact('title', 'saleorder','action'));
    }

    public function restoreSalesorder($saleorder)
    {
        $saleorder = $this->salesOrderRepository->getAll()->onlyDeleteLists()->find($saleorder);
        $saleorder->update(['is_delete_list'=>0]);
        return redirect('sales_order');
    }

    public function data(Datatables $datatables)
    {
        $dateFormat = config('settings.date_format');
        $salesOrderDeleteList = $this->salesOrderRepository->getAll()->onlyDeleteLists()->get()
            ->map(function ($salesOrderDeleteList) use ($dateFormat){
                return [
                    'id' => $salesOrderDeleteList->id,
                    'sale_number' => $salesOrderDeleteList->sale_number,
                    'date' => $salesOrderDeleteList->date,
                    'exp_date' => date($dateFormat, strtotime($salesOrderDeleteList->exp_date)),
                    'payment_term' => $salesOrderDeleteList->payment_term,
                    'customer' => isset($salesOrderDeleteList->customer) ?$salesOrderDeleteList->customer->full_name : '',
                    'person' => isset($salesOrderDeleteList->user) ?$salesOrderDeleteList->user->full_name : '',
                    'final_price' => $salesOrderDeleteList->final_price,
                    'status' => $salesOrderDeleteList->status,
                    'sales_team_id' => $salesOrderDeleteList->salesTeam->salesteam ?? '',
                    'main_staff' => $salesOrderDeleteList->salesPerson->full_name ?? '',
                ];
            });

        return $datatables->collection($salesOrderDeleteList)

            ->addColumn('actions', '
                                    <a href="{{ url(\'salesorder_delete_list/\' . $id . \'/show\' ) }}" title="{{ trans(\'table.details\') }}" >
                                            <i class="fa fa-fw fa-eye text-primary"></i> </a>
                                    @if(Sentinel::getUser()->hasAccess([\'sales_orders.write\']) || Sentinel::inRole(\'admin\'))
                                    <a href="{{ url(\'salesorder_delete_list/\' . $id . \'/restore\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-undo text-success"></i> </a>
                                       @endif')
            ->rawColumns(['actions'])->make();
    }
}
