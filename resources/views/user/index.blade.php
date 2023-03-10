@extends('layouts.user')
@section('title')
    {{trans('dashboard.dashboard')}}
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
@stop
@section('content')
    <div class="row mar-20">
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="box-dash">
                <div class="cnts ">
                    <div class="row">

                        <div class="col-md-6">
                            <i class="material-icons md-36 mar-top text-left  text-warning">layers</i>
                        </div>
                        <div class="col-md-6">

                            <div class="pull-right">
                                <div id="countno2"></div>
                                <p class=" nopadmar">{{trans('left_menu.products')}}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="cnts">
                <div class="row">

                    <div class="col-md-6">
                        <i class="material-icons md-36 mar-top text-left text-danger">chrome_reader_mode</i>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <div id="countno3"></div>
                            <p class="nopadmar">{{trans('left_menu.opportunities')}}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-6">
            <div class="cnts">
                <div class="row">

                    <div class="col-md-6">
                        <i class="material-icons md-36 mar-top text-left text-info">flag</i>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <div id="countno4"></div>
                            <p class=" nopadmar">{{trans('left_menu.companies')}}</p>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="row mar-20">
        <div class="col-lg-8">
            <div class="box1 opp-led">
                <h4>{{trans('dashboard.opportunities_leads')}}</h4>
                <div id='chart_opp_lead'></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box1 opport">
                <h4>{{trans('dashboard.opportunities')}}</h4>
                <div id="sales"></div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mar-20">
            <div class="box1 map">
                <h4>{{trans('dashboard.companies_map')}}</h4>
                <div class="world"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-7 mar-20">
            <meta name="_token" content="{{ csrf_token() }}">
            <div class="panel">
                <div class="panel-heading bg-white">
                    <h4 class="float-left">
                        <i class="livicon" data-name="inbox" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        {{ trans('task.task_list') }}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="tasks_list list_of_items vertical_scroll max_height_350 height_350">
                        @foreach($tasks as $task)
                            <div class="row">
                                <div class="col-xs-12 m-b-15">
                                    <a href="{{ url('task/'.$task->id.'/show') }}">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="text-capitalize font_18 pull-left">
                                                    {{ $task->subject }}
                                                </div>
                                                <div class="float-right">
                                                    <i class="fa fa-fw fa-eye text-primary" title="{{ trans('table.show') }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div>
                                        <span class="text_light">
                                            {{ trans('task.status') }}:
                                        </span>
                                        <span @if($task->status=='Not Started') class="text-warning"
                                              @elseif($task->status=='In Progress') class="text-primary"
                                              @elseif($task->status=='Pending') class="text-danger"
                                              @else class="text-success" @endif >
                                            {{ $task->status }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text_light">
                                            {{ trans('task.due_date') }}:
                                            <small>
                                                {{ date(config('settings.date_time_format'),strtotime($task->due_date)) }}
                                            </small>
                                            ; {{ trans('task.assigned_to') }}:
                                        </span>
                                        {{ $task->taskAssignedTo?$task->taskAssignedTo->full_name:'' }}
                                    </div>
                                    <div class="progress m-b-0 m-t-5">
                                        @if($task->status=='Not Started')
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                        @elseif($task->status=='In Progress')
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        @elseif($task->status=='Pending')
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        @else
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-5 mar-20">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="panel-title pull-left">
                                {{ trans('todo.my_todo_items') }}
                            </h4>
                            <div class="pull-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#create_todo">
                                    <i class="fa fa-plus-circle"></i> New
                                </button>
                                <a href="{{ url('todo') }}" class="btn btn-warning">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="vertical_scroll max_height_350 height_350 list_of_items">
                        <h6 class="text-warning m-b-10"> <i class="fa fa-warning"></i> {{ trans('todo.uncompleted_items') }}</h6>
                        <div class="todo_items_sortable_left">
                            @foreach($todoNew as $newtodo)
                                <div class="todo_lists">
                                    <input type="hidden" name="id" value="{{ $newtodo->id }}" id="todo_id">
                                    <input type="hidden" name="description" value="{{ $newtodo->description }}" id="todo_description">
                                    <div class="pull-left font_18 m-r-10 draggable_handle">
                                        <i class="fa fa-arrows"></i>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2 todo_checkbox pull-left">
                                        <input type="checkbox" name="completed" class="custom-control-input" id="is_completed{{$newtodo->id}}">
                                        <label class="custom-control-label" for="is_completed{{$newtodo->id}}"></label>
                                    </div>
                                    <div class="todo_description">
                                        {{ $newtodo->description }}
                                        <a href="{{ url('todo/'.$newtodo->id.'/delete') }}" class="pull-right m-l-10">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                        <a href="#" class="pull-right m-l-10 update_todo_list" data-toggle="modal" data-target="#update_todo">
                                            <i class="fa fa-edit text-warning"></i>
                                        </a>
                                        <div>
                                            <small class="text_light">
                                                {{ date(config('settings.date_time_format'),strtotime($newtodo->created_at)) }}
                                            </small>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                        <h6 class="text-success m-b-10 m-t-20"> <i class="fa fa-check"></i> {{ trans('todo.completed_items') }}</h6>
                        <div class="todo_items_sortable_right">
                            @foreach($todoCompleted as $completedtodo)
                                <div class="todo_lists">
                                    <input type="hidden" name="id" value="{{ $completedtodo->id }}" id="todo_id">
                                    <input type="hidden" name="description" value="{{ $completedtodo->description }}" id="todo_description">
                                    <div class="pull-left font_18 m-r-10 draggable_handle">
                                        <i class="fa fa-arrows"></i>
                                    </div>
                                    <div class="custom-control custom-checkbox mr-sm-2 todo_checkbox pull-left">
                                        <input type="checkbox" name="completed" class="custom-control-input" id="is_completed{{$completedtodo->id}}" {{$completedtodo->completed?'checked':''}}>
                                        <label class="custom-control-label" for="is_completed{{$completedtodo->id}}"></label>
                                    </div>
                                    <div class="todo_description">
                                <span class="stricked">
                                    {{ $completedtodo->description }}
                                    <a href="{{ url('todo/'.$completedtodo->id.'/delete') }}" class="pull-right m-l-10">
                                        <i class="fa fa-trash text-danger"></i>
                                    </a>
                                    <a href="#" class="pull-right m-l-10 update_todo_list" data-toggle="modal" data-target="#update_todo">
                                        <i class="fa fa-edit text-warning"></i>
                                    </a>
                                </span>
                                        <div>
                                            <small class="text_light">
                                                {{ date(config('settings.date_time_format'),strtotime($completedtodo->completed_at)) }}
                                            </small>
                                        </div>

                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Create todo modal--}}
    <div class="modal fade" id="create_todo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'todo', 'method' => 'post', 'files'=> true]) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('todo.create') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::textarea('description', null, ['class' => 'form-control description','id'=>'description','rows'=>3,'required']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('table.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('todo.save') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{--update todo modal--}}
    <div class="modal fade" id="update_todo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'todo/update', 'method' => 'put', 'files'=> true, 'id'=>'update_form']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('todo.update') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::textarea('description', null, ['class' => 'form-control description','id'=>'description','rows'=>3,'required']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('table.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('todo.save') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/countUp.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script>

        /*c3 line chart*/
        $(function () {

            var data_opp_lead = [
                ['Opportunity', 'Leads'],
                    @foreach($opportunity_leads as $item)
                [{{$item['opportunity']}}, {{$item['leads']}}],
                @endforeach
            ];

//c3 customisation
            var chart_opp_lead = c3.generate({
                bindto: '#chart_opp_lead',
                data: {
                    rows: data_opp_lead,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#FD9883', '#4FC1E9']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($opportunity_leads as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                chart_opp_lead.resize();
            }, 2000);

            setTimeout(function () {
                chart_opp_lead.resize();
            }, 4000);

            setTimeout(function () {
                chart_opp_lead.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                chart_opp_lead.resize();
            });
            /*c3 line chart end*/

            /*c3 pie chart*/
            var chart = c3.generate({
                bindto: '#sales',
                data: {
                    columns: [
                        ['New', {{$opportunity_new}}],
                        ['Qualification', {{$opportunity_qualification}}],
                        ['Proposition', {{$opportunity_proposition}}],
                        ['Negotiation', {{$opportunity_negotiation}}],
                        ['Won', {{$opportunity_won}}],
                        ['Loss', {{$opportunity_loss}}]
                    ],
                    type: 'pie',
                    colors: {
                        'New': '#4fc1e9',
                        'Qualification': '#a0d468',
                        'Proposition': '#37bc9b',
                        'Negotiation': '#ffcc66',
                        'Won': '#fd9883',
                        'Loss': '#c2185b'
                    },
                    labels: true
                }
            });
            $(".sidebar-toggle").on("click",function () {
                setTimeout(function () {
                    chart.resize();
                },200)
            });
            /*c3 pie chart end*/
            // c3 chart end


            /*dashboard countup*/
            var useOnComplete = false,
                useEasing = false,
                useGrouping = false,
                options = {
                    useEasing: useEasing, // toggle easing
                    useGrouping: useGrouping, // 1,000,000 vs 1000000
                    separator: ',', // character to use as a separator
                    decimal: '.' // character to use as a decimal
                };

                    {{--var demo = new CountUp("countno1", 0, "{{$contracts}}", 0, 3, options);--}}
                    {{--demo.start();--}}
            var demo = new CountUp("countno2", 0, "{{$products}}", 0, 3, options);
            demo.start();
            var demo = new CountUp("countno3", 0, "{{$opportunities}}", 0, 3, options);
            demo.start();
            var demo = new CountUp("countno4", 0, "{{$customers}}", 0, 3, options);
            demo.start();

            /*countup end*/

            var world= $('.world').vectorMap(
                {
                    map: 'world_mill_en',
                    markers: [
                            @foreach($customers_world as $item)
                        {
                            latLng: [{{$item['latitude']}}, {{$item['longitude']}}], name: '{{$item['city']}}'
                        },
                        @endforeach
                    ],
                    normalizeFunction: 'polynomial',
                    backgroundColor: 'transparent',
                    regionsSelectable: true,
                    markersSelectable: true,
                    regionStyle: {
                        initial: {
                            fill: 'rgba(120,130,140,0.2)'
                        },
                        hover: {
                            fill: '#2283Bf',
                            stroke: '#fff'
                        }
                    },
                    markerStyle: {
                        initial: {
                            fill: '#A0D468',
                            stroke: '#fff',
                            r: 10
                        },
                        hover: {
                            fill: '#0cc2aa',
                            stroke: '#fff',
                            r: 15
                        }
                    }
                }
            );
            $(".sidebar-toggle").on("click",function () {
                setTimeout(function () {
                    world.resize();
                },200)
            });
            $('.task-body1').slimscroll({
                height: '363px',
                size: '5px',
                opacity: 0.2
            });


        });

        $(document).ready(function(){
            $('.todo_lists [type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

//            Mark as complete or not
            $('.todo_lists [type="checkbox"]').on("ifChanged",function(){
                var isCompleted;
                if ($(this).prop("checked")) {
                    isCompleted = 1;
                } else {
                    isCompleted = 0;
                }
                var id = $(this).closest(".todo_lists").find("#todo_id").val();
                $.ajax({
                    type:'GET',
                    data: { _token: $('meta[name="_token"]').attr('content'),'completed': isCompleted },
                    url:'{{ url('todo/is_completed') }}'+'/'+id,
                    success:function(msg) {
                        $("#sendby_ajax").html(msg+'.');
                        setTimeout(function(){
                            $("#sendby_ajax").hide();
                        },5000);
                        location.reload();
                    }
                });
            });

//            Update todo list
            $(".update_todo_list").on("click",function(){
                var description = $(this).closest(".todo_lists").find("#todo_description").val();
                var id = $(this).closest(".todo_lists").find("#todo_id").val();
                $("#update_todo").on('show.bs.modal', function () {
                    $(".description").val(description);
                    $("#update_form").on("submit",function(e){
                        e.preventDefault();
                        var updateUrl = '{{ url('todo') }}'+'/'+id;
                        $(this).attr('action',updateUrl);
                        $.ajax({
                            type:'put',
                            data: $(this).serialize(),
                            url:'{{ url('todo') }}'+'/'+id,
                            success:function(msg) {
                                $("#sendby_ajax").html(msg+'.');
                                setTimeout(function(){
                                    $("#sendby_ajax").hide();
                                },5000);
                                location.reload();
                            }
                        });
                    });
                });
            });

            //            sortable todo
            $( ".todo_items_sortable_left" ).sortable({
                handle: ".draggable_handle"
            });
            $( ".todo_items_sortable_right" ).sortable({
                handle: ".draggable_handle"
            });
        })
    </script>

@stop