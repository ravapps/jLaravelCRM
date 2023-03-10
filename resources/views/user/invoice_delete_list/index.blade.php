@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="details">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="material-icons">event_seat</i>
                            {{ $title }}
                        </h4>
                        <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removepanel clickable"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="column_dropdown pull-right m-b-15">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            {{ trans('table.column_visibility') }} <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column0" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="0" id="column0" checked> {{ trans('table.id') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column1" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('invoice.invoice_number') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column2" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('invoice.agent_name') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column3" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('quotation.sales_team_id') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column4" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="4" id="column4"> {{ trans('salesteam.main_staff') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column5" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="5" id="column5"> {{ trans('invoice.invoice_date') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column6" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="6" id="column6"> {{ trans('invoice.due_date') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column7" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="7" id="column7"> {{ trans('invoice.total') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column8" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="8" id="column8"> {{ trans('invoice.unpaid_amount') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column9" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="9" id="column9"> {{ trans('invoice.payment_term') }}
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <label for="column10" class="toggle-vis">
                                                        <input type="checkbox" class="icheckblue" data-column="10" id="column10"> {{ trans('invoice.status') }}
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ trans('table.id') }}</th>
                                    <th>{{ trans('invoice.invoice_number') }}</th>
                                    <th>{{ trans('invoice.agent_name') }}</th>
                                    <th>{{ trans('quotation.sales_team_id') }}</th>
                                    <th>{{ trans('salesteam.main_staff') }}</th>
                                    <th>{{ trans('invoice.invoice_date') }}</th>
                                    <th>{{ trans('invoice.due_date') }}</th>
                                    <th>{{ trans('invoice.total') }}</th>
                                    <th>{{ trans('invoice.unpaid_amount') }}</th>
                                    <th>{{ trans('invoice.payment_term') }}</th>
                                    <th>{{ trans('invoice.status') }}</th>
                                    <th class="noExport">{{ trans('invoice.expired') }}</th>
                                    <th class="noExport">{{ trans('table.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @if(isset($type))
        <script type="text/javascript">
            var oTable;
            $(document).ready(function () {
                oTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "columns":[
                        {"data":"id"},
                        {"data":"invoice_number"},
                        {"data":"customer"},
                        {"data":"sales_team_id"},
                        {"data":"main_staff"},
                        {"data":"invoice_date"},
                        {"data":"due_date"},
                        {"data":"final_price"},
                        {"data":"unpaid_amount"},
                        {"data":"payment_term"},
                        {"data":"status"},
                        {"data":"expired"},
                        {"data":"actions"},
                    ],
                    "ajax": "{{ url($type) }}" + ((typeof $('#data').attr('data-id') != "undefined") ? "/" + $('#id').val() + "/" + $('#data').attr('data-id') : "/data"),
                    dom: 'Bfrtip',
                    pageLength: 15,
                    stateSave: true,
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ],
                    lengthMenu: [[10,25,50,100, -1],[10,25,50,100, "All"]],
                    buttons: [
                        {
                            extend: 'pageLength'
                        },
                        {
                            extend: 'collection',
                            text: 'Export',
                            buttons: [
                                {
                                    extend: 'copy',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                },
                                {
                                    extend: 'csv',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                },
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                },
                                {
                                    extend: 'print',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }
                            ]
                        }
                    ]
                });
                oTable.columns().every(function(id) {
                    if(oTable.column( id ).visible() === true){
                        $(".column_dropdown .checkbox").find("input[data-column='"+id+"']").prop('checked',false);
                    }else{
                        $(".column_dropdown .checkbox").find("input[data-column='"+id+"']").prop('checked',true);
                    }
                });

                $('body').on('ifChanged','.checkbox', function(e) {
                    e.preventDefault();
                    // Get the column API object
                    var column = oTable.column($(this).find('input').attr('data-column'));
                    // Toggle the visibility
                    column.visible(!column.visible());
                });
                $(".icheckblue").iCheck({
                    checkboxClass: 'icheckbox_minimal-blue'
                });
            });
        </script>
    @endif
@stop