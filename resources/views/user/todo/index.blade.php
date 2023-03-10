@extends('layouts.user')
@section('title')
    {{trans('dashboard.dashboard')}}
@stop
@section('styles')

@stop
@section('content')
    <div id="sendby_ajax" style="text-align:center;">
    </div>
    <div class="page-header clearfix">
        <div class="pull-right">
            <button class="btn btn-primary m-b-10" data-toggle="modal" data-target="#create_todo">
                <i class="fa fa-plus-circle"></i> {{ trans('todo.create') }}
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading bg-white">
                    <h4>{{ trans('todo.uncompleted_items') }}</h4>
                </div>
                <div class="panel-body todo_items_sortable_left">
                    <div class="tasks_list list_of_items vertical_scroll max_height_350 height_350">
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
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading bg-white">
                    <h4>{{ trans('todo.completed_items') }}</h4>
                </div>
                <div class="panel-body todo_items_sortable_right">
                    <div class="tasks_list list_of_items vertical_scroll max_height_350 height_350">
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

    {{--Create todo modal--}}
    <div class="modal fade" id="create_todo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true]) !!}
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
                {!! Form::open(['url' => $type.'/update', 'method' => 'put', 'files'=> true, 'id'=>'update_form']) !!}
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
    <script src="{{ asset('js/jquery-ui/jquery-ui.js') }}"></script>
    <script>
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
