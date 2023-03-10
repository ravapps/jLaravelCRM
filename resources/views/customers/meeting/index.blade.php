@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <div class="pull-right">
            @if($user_data->hasAccess(['meetings.read']) || $user_data->inRole('admin') || $user_data->inRole('customer'))
                <a href="{{ url($type.'/calendar')  }}" class="btn btn-success">
                    <i class="fa fa-calendar"></i> {{ trans('opportunity.calendar') }}</a>
            @endif
            @if($user_data->hasAccess(['meetings.write']) || $user_data->inRole('admin'))
                <a href="{{ url($type.'/create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('meeting.meeting_create') }}</a>
            @endif
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">radio</i>
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
                                            <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('meeting.meeting_subject') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column2" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('meeting.starting_date') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column3" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('meeting.ending_date') }}
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
                                            <input type="checkbox" class="icheckblue" data-column="5" id="column5"> {{ trans('meeting.location') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column6" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="6" id="column6"> {{ trans('meeting.privacy') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column7" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="7" id="column7"> {{ trans('meeting.show_time_as') }}
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
                        <th>{{ trans('meeting.meeting_subject') }}</th>
                        <th>{{ trans('meeting.starting_date') }}</th>
                        <th>{{ trans('meeting.ending_date') }}</th>
                        <th>{{ trans('salesteam.main_staff') }}</th>
                        <th>{{ trans('meeting.location') }}</th>
                        <th>{{ trans('meeting.privacy') }}</th>
                        <th>{{ trans('meeting.show_time_as') }}</th>
                        <th class="noExport">{{ trans('table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

{{-- Scripts --}}
@section('scripts')
    @if(isset($type))
        <script type="text/javascript">
            var oTable;
            $(document).ready(function () {
                oTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    columns:[
                        {"data":"id"},
                        {"data":"meeting_subject"},
                        {"data":"starting_date"},
                        {"data":"ending_date"},
                        {"data":"responsible"},
                        {"data":"location"},
                        {"data":"privacy"},
                        {"data":"show_time_as"},
                        {"data":"actions"}
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
                        },
                        {
                            "targets": [ 5 ],
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