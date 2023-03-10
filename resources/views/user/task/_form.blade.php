<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($task))
            {!! Form::model($task, ['url' => $type . '/' . $task->id, 'method' => 'put', 'files'=> true]) !!}
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true]) !!}
        @endif
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
                            {!! Form::text('start_date', isset($task) ? $task->task_start_date : null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('start_date', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('due_date') ? 'has-error' : '' }}">
                        {!! Form::label('due_date', trans('task.due_date'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('due_date', isset($task) ? $task->task_due_date : null, ['class' => 'form-control']) !!}
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

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}
                </button>
                <a href="{{ route($type.'.index') }}" class="btn btn-warning"><i
                            class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
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
                minDate: '{{ isset($task) ? $task->created_at : now() }}',
                dateFormat: dateTimeFormat,
                enableTime: true,
                disableMobile: "true",
                "plugins": [new rangePlugin({ input: "#due_date"})]
            });
        });
    </script>
@stop
