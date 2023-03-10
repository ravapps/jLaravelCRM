<div class="panel panel-primary">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.assigned_to')}}</label>
                    <div class="controls">
                        {{ $task->taskAssignedTo?$task->taskAssignedTo->full_name:'' }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.subject')}}</label>
                    <div class="controls">
                        {{ $task->subject }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.start_date')}}</label>
                    <div class="controls">
                        {{ $task->task_start_date }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.due_date')}}</label>
                    <div class="controls">
                        {{ $task->task_due_date }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.status')}}</label>
                    <div class="controls">
                        {{ $task->status }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.priority')}}</label>
                    <div class="controls">
                        {{ $task->priority }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('task.description')}}</label>
                    <div class="controls">
                        {{ $task->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == trans('action.show'))
                    <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                @else
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{trans('table.delete')}}</button>
                    <a href="{{ URL::previous()}}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            $("#status").select2({
                theme: "bootstrap",
                placeholder: "{{trans('task.status')}}"
            });
        });
    </script>
@stop