<div class="panel panel-primary">
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-5 col-md-4 col-lg-3" style="display:none;">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail form_Blade" data-trigger="fileinput">
                        @if(isset($customer->user->user_avatar) && $customer->user->user_avatar!="")
                            <img src="{{ url('uploads/avatar/thumb_'.$customer->user->user_avatar) }}"
                                 alt="Image" class="ima-responsive" width="300">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-md-8 col-lg-9">
                <div class="form-group">
                    {!! Form::label('last_name', trans('customer.full_name'), ['class' => 'control-label']) !!}
                    @if(isset($customer->user))
                    : {{ $customer->title.' '.$customer->user->full_name }}
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('customer.email'), ['class' => 'control-label']) !!}
                    @if(isset($customer->user))
                    : {{ $customer->user->email }}
                    @endif
                </div>
                <div class="form-group">
                    {!! Form::label('phone', trans('customer.phone'), ['class' => 'control-label']) !!}
                    @if(isset($customer->user))
                    : {{ $customer->user->phone_number }}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-lg-3">
                <div class="form-group">
                    {!! Form::label('job_position', trans('customer.job_position'), ['class' => 'control-label']) !!}
                    <div>
                        {{ $customer->job_position }}
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3">
                <div class="form-group">
                    {!! Form::label('company_id', trans('customer.company'), ['class' => 'control-label']) !!}
                    <div>
                        {{ (isset($customer))?$customer->company->name:null }}
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-lg-3">
                <div class="form-group">
                    {!! Form::label('mobile', trans('customer.mobile'), ['class' => 'control-label']) !!}
                    <div>
                        {{ $customer->mobile }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('additional_info', trans('customer.address'), ['class' => 'control-label']) !!}


                    <div>
{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->sitelocation }}
{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->postalcode }}
{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->street }}

{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->building }}

{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->untinofrom }}

{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->unitnoto }}

{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->branchcategory }}

{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->contact }}

{{ is_null($customer->contactSitelocation)?"":$customer->contactSitelocation->mobile }}





                    </div>

                </div>
            </div>

            <div class="col-md-12">

                <div class="form-group">
                    <div class="controls">
                        @if (@$action == 'show')
                            <a href="{{ url($type) }}" class="btn btn-warning"><i
                                        class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                        @elseif (@$action == 'lost' || @$action == 'won')
                            <a href="{{ url($type) }}" class="btn btn-warning"><i
                                        class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                            <button type="submit" class="btn btn-success"><i
                                        class="fa fa-check-square-o"></i> {{trans('table.ok')}}
                            </button>
                            {!! Form::close() !!}
                        @else
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{trans('table.delete')}}
                            </button>
                            <a href="{{ url($type) }}" class="btn btn-warning"><i
                                        class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
