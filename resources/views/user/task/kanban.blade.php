@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dragula/dragula.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
    <style>
        .show_task_modal{
            cursor: pointer;
        }
    </style>
@stop

{{-- Content --}}
@section('content')
    @include('flash::message')
    <div class="page-header clearfix">
        <div class="pull-right">
            <a href="{{ url($type) }}" class="btn btn-warning m-b-10"><i
                        class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
            <a href="#" class="btn btn-primary m-b-10" data-toggle="modal" data-target="#create_task">
                <i class="fa fa-plus-circle"></i> {{ trans('task.new') }}
            </a>
        </div>
    </div>
    <div id="sendby_ajax" style="text-align:center;">
    </div>
    <div class="kanban_section horizontal_scroll mb-2">
        <div class="kanban_wrapper">
            <div class="kanban_card">
                <div class="panel m-r-10">
                    <div class="panel-heading bg-warning text-white">
                        <h4>{{ trans('task.not_started') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="dragula_tasks list_of_items vertical_scroll max_height_600">
                            <div>
                                <input type="hidden" value="Not Started" class="task_status">
                            </div>
                            @if(isset($tasks))
                                @foreach($tasks as $task)
                                    @if($task->status==='Not Started')
                                        <div class="alert alert-warning" role="alert">
                                            <input type="hidden" value="{{$task->id}}" class="task_id">
                                            <div>
                                                <span class="text-primary font_18 show_task_modal" data-toggle="modal" data-target="#show_task" title="{{ trans('task.task_info') }}">#{{ $task->id }}</span>
                                            </div>
                                            <div>
                                                {{ $task->subject }}
                                            </div>
                                            <div>
                                                <strong>{{ trans('task.assigned_to') }} :</strong>
                                                {{ $task->taskAssignedTo?$task->taskAssignedTo->full_name:'' }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="kanban_card">
                <div class="panel m-r-10">
                    <div class="panel-heading bg-primary text-white">
                        <h4>{{ trans('task.in_progress') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="dragula_tasks list_of_items vertical_scroll max_height_600">
                            <input type="hidden" value="In Progress" class="task_status">
                            @if(isset($tasks))
                                @foreach($tasks as $task)
                                    @if($task->status==='In Progress')
                                        <div class="alert alert-info" role="alert">
                                            <input type="hidden" value="{{$task->id}}" class="task_id">
                                            <div>
                                                <span class="text-primary font_18 show_task_modal" data-toggle="modal" data-target="#show_task" title="{{ trans('task.task_info') }}">#{{ $task->id }}</span>
                                            </div>
                                            <div>
                                                {{ $task->subject }}
                                            </div>
                                            <div>
                                                <strong>{{ trans('task.assigned_to') }} :</strong>
                                                {{ $task->taskAssignedTo?$task->taskAssignedTo->full_name:'' }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="kanban_card">
                <div class="panel m-r-10">
                    <div class="panel-heading bg-danger text-white">
                        <h4>{{ trans('task.pending') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="dragula_tasks list_of_items vertical_scroll max_height_600">
                            <input type="hidden" value="Pending" class="task_status">
                            @if(isset($tasks))
                                @foreach($tasks as $task)
                                    @if($task->status==='Pending')
                                        <div class="alert alert-danger" role="alert">
                                            <input type="hidden" value="{{$task->id}}" class="task_id">
                                            <div>
                                                <span class="text-primary font_18 show_task_modal" data-toggle="modal" data-target="#show_task" title="{{ trans('task.task_info') }}">#{{ $task->id }}</span>
                                            </div>
                                            <div>
                                                {{ $task->subject }}
                                            </div>
                                            <div>
                                                <strong>{{ trans('task.assigned_to') }} :</strong>
                                                {{ $task->taskAssignedTo?$task->taskAssignedTo->full_name:'' }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="kanban_card">
                <div class="panel">
                    <div class="panel-heading bg-success text-white">
                        <h4>{{ trans('task.completed') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="dragula_tasks list_of_items vertical_scroll max_height_600">
                            <input type="hidden" value="Completed" class="task_status">
                            @if(isset($tasks))
                                @foreach($tasks as $task)
                                    @if($task->status==='Completed')
                                        <div class="alert alert-success" role="alert">
                                            <input type="hidden" value="{{$task->id}}" class="task_id">
                                            <div>
                                                <span class="text-primary font_18 show_task_modal" data-toggle="modal" data-target="#show_task" title="{{ trans('task.task_info') }}">#{{ $task->id }}</span>
                                            </div>
                                            <div>
                                                {{ $task->subject }}
                                            </div>
                                            <div>
                                                <strong>{{ trans('task.assigned_to') }} :</strong>
                                                {{ $task->taskAssignedTo?$task->taskAssignedTo->full_name:'' }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--create task--}}
    <div class="modal fade" id="create_task" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['url' => $type.'/kanban/create', 'method' => 'post', 'id'=>'create_task_form','files'=> true]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="exampleModalLabel">{{ trans('task.new') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group required {{ $errors->has('assigned_to') ? 'has-error' : '' }}">
                        {!! Form::label('assigned_to', trans('task.assigned_to'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('assigned_to', $assignedTo, null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('assigned_to', ':message') }}</span>
                        </div>
                    </div>
                    <div class="form-group required {{ $errors->has('subject') ? 'has-error' : '' }}">
                        {!! Form::label('subject', trans('task.subject'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('subject', null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('subject', ':message') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                {!! Form::label('start_date', trans('task.start_date'), ['class' => 'control-label required']) !!}
                                <div class="controls">
                                    {!! Form::text('start_date', null, ['class' => 'form-control']) !!}
                                    <span class="help-block">{{ $errors->first('start_date', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('due_date') ? 'has-error' : '' }}">
                                {!! Form::label('due_date', trans('task.due_date'), ['class' => 'control-label required']) !!}
                                <div class="controls">
                                    {!! Form::text('due_date', null, ['class' => 'form-control']) !!}
                                    <span class="help-block">{{ $errors->first('due_date', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('status') ? 'has-error' : '' }}">
                                {!! Form::label('status', trans('task.status'), ['class' => 'control-label required']) !!}
                                <div class="controls">
                                    {!! Form::select('status', $status, null, ['class' => 'form-control']) !!}
                                    <span class="help-block">{{ $errors->first('status', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('priority') ? 'has-error' : '' }}">
                                {!! Form::label('priority', trans('task.priority'), ['class' => 'control-label required']) !!}
                                <div class="controls">
                                    {!! Form::select('priority', $priority, null, ['class' => 'form-control']) !!}
                                    <span class="help-block">{{ $errors->first('priority', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', trans('task.description'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('table.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('todo.save') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--show task modal--}}
    <div class="modal fade" id="show_task" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="exampleModalLabel">{{ trans('task.task_info') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.assigned_to') }}
                        </div>
                        <div class="col-6 col-sm-8" id="assigned_to"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.assigned_by') }}
                        </div>
                        <div class="col-6 col-sm-8" id="assigned_by"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.subject') }}
                        </div>
                        <div class="col-6 col-sm-8" id="subject"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.start_date') }}
                        </div>
                        <div class="col-6 col-sm-8" id="start_date"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.due_date') }}
                        </div>
                        <div class="col-6 col-sm-8" id="due_date"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.status') }}
                        </div>
                        <div class="col-6 col-sm-8" id="status"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.priority') }}
                        </div>
                        <div class="col-6 col-sm-8" id="priority"></div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-6 col-sm-4">
                            {{ trans('task.description') }}
                        </div>
                        <div class="col-6 col-sm-8" id="description"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('table.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script src="{{ asset('js/dragula/dragula.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            //   kanban
            var $scrumBoard = $('.kanban_section');
            var childWidth = $scrumBoard.find('.kanban_card').width();
            var childsCount = $scrumBoard.find('.kanban_card').length;

            $scrumBoard.width(childWidth * childsCount);
            $(".kanban_wrapper").width(childWidth * childsCount);

            var drake = dragula($('.dragula_tasks').toArray());
            var containers = drake.containers,
                length = containers.length;

            for (var i = 0; i < length; i++) {
                $(containers[i]).addClass('dragula dragula-vertical');
            }
            drake.on('drop', function(el, target, source, sibling) {
                var sourceTaskStatus = $(source).find(".task_status").val();
                var tagetTaskStatus = $(target).find(".task_status").val();
                var taskId = $(el).find(".task_id").val();
                if(sourceTaskStatus!==tagetTaskStatus){
                    $.ajax({
                        type:'GET',
                        data: { _token: $('meta[name="_token"]').attr('content'),'status': tagetTaskStatus },
                        url:'{{ url('task/kanban') }}'+'/'+taskId+'/update',
                        success:function(msg) {
                            $("#sendby_ajax").html(msg);
                            setTimeout(function(){
                                $("#sendby_ajax").hide();
                            },5000);
                            location.reload();
                        }
                    });
                }
            });

//            show task
            $(".show_task_modal").on("click",function(){
                var id = $(this).closest(".alert").find(".task_id").val();
                $.ajax({
                    type:'GET',
                    data: { _token: $('meta[name="_token"]').attr('content'),'id': id },
                    url:'{{ url('task') }}'+'/'+id+'/kanban_show_task',
                    success:function(data) {
                        var $showTask = $("#show_task");
                        $showTask.find("#assigned_to").text(': '+data.assigned_to);
                        $showTask.find("#assigned_by").text(': '+data.assigned_by);
                        $showTask.find("#subject").text(': '+data.subject);
                        $showTask.find("#start_date").text(': '+data.start_date);
                        $showTask.find("#due_date").text(': '+data.due_date);
                        $showTask.find("#status").text(': '+data.status);
                        $showTask.find("#priority").text(': '+data.priority);
                        $showTask.find("#description").text(': '+data.description);
                    }
                });
            });

            $("#assigned_to").select2({
                theme: "bootstrap",
                placeholder: "{{trans('task.assigned_to')}}"
            });
            $("#priority").select2({
                theme: "bootstrap",
                placeholder: "{{trans('task.priority')}}"
            });
            $("#status").select2({
                theme: "bootstrap",
                placeholder: "{{trans('task.status')}}"
            });
            var dateTimeFormat = '{{ config('settings.date_format').' H:i' }}';
            flatpickr('#start_date',{
                minDate: '{{ now() }}',
                dateFormat: dateTimeFormat,
                enableTime: true,
                disableMobile: "true",
                "plugins": [new rangePlugin({ input: "#due_date"})],
                onChange:function(){
                    $('#create_task_form').bootstrapValidator('revalidateField', 'due_date');
                }
            });

            $("#create_task_form").bootstrapValidator({
                fields: {
                    assigned_to: {
                        validators: {
                            notEmpty: {
                                message: 'The assigned to field is required.'
                            }
                        }
                    },
                    subject: {
                        validators: {
                            notEmpty: {
                                message: 'The subject field is required.'
                            }
                        }
                    },
                    start_date: {
                        validators: {
                            notEmpty: {
                                message: 'The start date field is required.'
                            }
                        }
                    },
                    due_date: {
                        validators: {
                            notEmpty: {
                                message: 'The due date field is required.'
                            }
                        }
                    },
                    status: {
                        validators: {
                            notEmpty: {
                                message: 'The status field is required.'
                            }
                        }
                    },
                    priority: {
                        validators: {
                            notEmpty: {
                                message: 'The priority field is required.'
                            }
                        }
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'The description field is required.'
                            }
                        }
                    },
                }
            });
        });
    </script>
@stop
