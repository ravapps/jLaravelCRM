<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($category))
            {!! Form::model($category, ['url' => $type . '/' . $category->id, 'method' => 'put', 'files'=> true, 'id'=>'category']) !!}
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'category']) !!}
        @endif
        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans('category.name'), ['class' => 'control-label required']) !!}
            <div class="controls">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
                <a href="{{ route($type.'.index') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
            </div>
        </div>
        <!-- ./ form actions -->

        {!! Form::close() !!}
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function(){
            $("#category").bootstrapValidator({
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'The Category name field is required'
                            },
                            stringLength: {
                                min: 3,
                                message: 'The Category name must be minimum 3 characters.'
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endsection
