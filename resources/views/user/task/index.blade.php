@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    <div class="row analytics">
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="panel">
                <div class="panel-heading bg-white ">
                    <h4 class="m-0">{{ trans('task.not_started') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text_light font_16">{{ trans('task.total_tasks') }}</div>
                            <div class="pull-left">
                                {{ $notStartedTasks.'/'.$totalTasks }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasks?round(($notStartedTasks/$totalTasks)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$totalTasks?($notStartedTasks/$totalTasks)*100:0}}%" aria-valuenow="{{$totalTasks?($notStartedTasks/$totalTasks)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 m-t-20">
                            <div class="text_light font_16">{{ trans('task.assigned_to_me') }}</div>
                            <div class="pull-left">
                                {{ $notStartedTasksToMe.'/'.$totalTasksToMe }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasksToMe?round(($notStartedTasksToMe/$totalTasksToMe)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$totalTasksToMe?($notStartedTasksToMe/$totalTasksToMe)*100:0}}%" aria-valuenow="{{$totalTasksToMe?($notStartedTasksToMe/$totalTasksToMe)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="panel">
                <div class="panel-heading bg-white ">
                    <h4 class="m-0">{{ trans('task.in_progress') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text_light font_16">{{ trans('task.total_tasks') }}</div>
                            <div class="pull-left">
                                {{ $inProgressTasks.'/'.$totalTasks }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasks?round(($inProgressTasks/$totalTasks)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{$totalTasks?($inProgressTasks/$totalTasks)*100:0}}%" aria-valuenow="{{$totalTasks?($inProgressTasks/$totalTasks)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 m-t-20">
                            <div class="text_light font_16">{{ trans('task.assigned_to_me') }}</div>
                            <div class="pull-left">
                                {{ $inProgressTasksToMe.'/'.$totalTasksToMe }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasksToMe?round(($inProgressTasksToMe/$totalTasksToMe)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{$totalTasksToMe?($inProgressTasksToMe/$totalTasksToMe)*100:0}}%" aria-valuenow="{{$totalTasksToMe?($inProgressTasksToMe/$totalTasksToMe)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="panel">
                <div class="panel-heading bg-white ">
                    <h4 class="m-0">{{ trans('task.pending') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text_light font_16">{{ trans('task.total_tasks') }}</div>
                            <div class="pull-left">
                                {{ $pendingTasks.'/'.$totalTasks }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasks?round(($pendingTasks/$totalTasks)*100, 2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$totalTasks?($pendingTasks/$totalTasks)*100:0}}%" aria-valuenow="{{$totalTasks?($pendingTasks/$totalTasks)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 m-t-20">
                            <div class="text_light font_16">{{ trans('task.assigned_to_me') }}</div>
                            <div class="pull-left">
                                {{ $pendingTasksToMe.'/'.$totalTasksToMe }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasksToMe?round(($pendingTasksToMe/$totalTasksToMe)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$totalTasksToMe?($pendingTasksToMe/$totalTasksToMe)*100:0}}%" aria-valuenow="{{$totalTasksToMe?($pendingTasksToMe/$totalTasksToMe)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="panel">
                <div class="panel-heading bg-white ">
                    <h4 class="m-0">{{ trans('task.completed') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text_light font_16">{{ trans('task.total_tasks') }}</div>
                            <div class="pull-left">
                                {{ $completedTasks.'/'.$totalTasks }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasks?round(($completedTasks/$totalTasks)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$totalTasks?($completedTasks/$totalTasks)*100:0}}%" aria-valuenow="{{$totalTasks?($completedTasks/$totalTasks)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 m-t-20">
                            <div class="text_light font_16">{{ trans('task.assigned_to_me') }}</div>
                            <div class="pull-left">
                                {{ $completedTasksToMe.'/'.$totalTasksToMe }}
                            </div>
                            <div class="pull-right">
                                {{ $totalTasksToMe?round(($completedTasksToMe/$totalTasksToMe)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="progress m-0">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$totalTasksToMe?($completedTasksToMe/$totalTasksToMe)*100:0}}%" aria-valuenow="{{$totalTasksToMe?($completedTasksToMe/$totalTasksToMe)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header clearfix">
        <div class="pull-right">
            <a href="{{ url($type.'/kanban') }}" class="btn btn-primary m-b-10">
                {{ trans('task.tasks_kanban') }}
            </a>
            <a href="{{ url($type.'/create') }}" class="btn btn-primary m-b-10">
                <i class="fa fa-plus-circle"></i> {{ trans('task.new') }}
            </a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="material-icons">groups</i>{{ $title }}
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
                                            <input type="checkbox" class="icheckblue" data-column="1" id="column1"> {{ trans('task.assigned_to') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column2" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="2" id="column2"> {{ trans('task.subject') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column3" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="3" id="column3"> {{ trans('task.start_date') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column4" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="4" id="column4"> {{ trans('task.due_date') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column5" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="5" id="column5"> {{ trans('task.priority') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label for="column6" class="toggle-vis">
                                            <input type="checkbox" class="icheckblue" data-column="6" id="column6"> {{ trans('task.status') }}
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
                        <th>{{ trans('task.assigned_to') }}</th>
                        <th>{{ trans('task.subject') }}</th>
                        <th>{{ trans('task.start_date') }}</th>
                        <th>{{ trans('task.due_date') }}</th>
                        <th>{{ trans('task.priority') }}</th>
                        <th>{{ trans('task.status') }}</th>
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
    {{--    <script src="{{ asset('js/todolist.js') }}"></script>--}}
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
                        {"data":"assigned_to"},
                        {"data":"subject"},
                        {"data":"start_date"},
                        {"data":"due_date"},
                        {"data":"priority"},
                        {"data":"status"},
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
                    ],
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
    <script>
        $(document).ready(function () {
            $("#user_id").select2({
                theme: "bootstrap",
                placeholder: "{{trans('task.user')}}"
            });

            var dateFormat = '{{ config('settings.date_format') }}';
            flatpickr("#task_deadline", {
                minDate: '{{  now() }}',
                dateFormat: dateFormat,
            });
        });
        $('.icheckgreen').iCheck({
            checkboxClass: 'icheckbox_minimal-green',
            radioClass: 'iradio_minimal-green'
        });
    </script>
@stop