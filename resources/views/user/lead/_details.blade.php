<div class="panel panel-primary">
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                @if($user_data->hasAccess(['logged_calls.read']) || $user_data->inRole('admin'))
                    <a href="{{ url('leadcall/' . $lead->id ) }}" class="btn btn-primary call-summary">
                        <i class="fa fa-phone"></i> <b>{{$lead->calls()->count()}}</b> {{ trans("table.calls") }}
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 m-t-20">
                {!! Form::label('company_name', trans('lead.company_name'), ['class' => 'control-label']) !!}
                <div>{{ $lead->company->name }}</div>
            </div>
            <div class="col-sm-4 m-t-20">
                {!! Form::label('function', trans('lead.function'), ['class' => 'control-label' ]) !!}
                <div>{{ $lead->function }}</div>
            </div>
            <div class="col-sm-4 m-t-20">
                {!! Form::label('product_name', trans('lead.product_name'), ['class' => 'control-label' ]) !!}
                <div>{{ $lead->product_name }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-t-20">
                {!! Form::label('additionl_info', trans('lead.additionl_info'), ['class' => 'control-label']) !!}
                <div>{{ $lead->additionl_info }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-3 m-t-20">
                {!! Form::label('client_name', trans('lead.agent_name'), ['class' => 'control-label']) !!}
                <div>{{ is_null($lead->customer->user)?'':$lead->customer->user->full_name }}</div>
            </div>

            <div class="col-sm-6 col-lg-3 m-t-20">
                {!! Form::label('phone', trans('lead.phone'), ['class' => 'control-label']) !!}
                <div>{{ $lead->phone }}</div>
            </div>
            <div class="col-sm-6 col-lg-3 m-t-20">
                {!! Form::label('mobile', trans('lead.mobile'), ['class' => 'control-label']) !!}
                <div>{{ $lead->mobile }}</div>
            </div>
            <div class="col-sm-6 col-lg-3 m-t-20">
                {!! Form::label('email', trans('lead.email'), ['class' => 'control-label']) !!}
                <div>{{ $lead->email }}</div>
            </div>
            <div class="col-sm-6 col-lg-3 m-t-20">
                {!! Form::label('priority', trans('lead.priority'), ['class' => 'control-label']) !!}
                <div>{{ $lead->priority }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-t-20">
                {!! Form::label('address', trans('lead.sitelocation'), ['class' => 'control-label']) !!}
                <div>
                  @if(!is_null($lead->customer))
                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->sitelocation }}
                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->postalcode }}
                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->street }}

                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->building }}

                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->untinofrom }}

                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->unitnoto }}

                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->branchcategory }}

                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->contact }}

                  {{ is_null($lead->customer->contactSitelocation)?"":$lead->customer->contactSitelocation->mobile }}
                  @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 margin-top">
                <div class="form-group">
                    <div class="controls">
                        @if ($action == 'show')
                            <a href="{{ url($type) }}" class="btn btn-warning"><i
                                        class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                        @else
                            <button type="submit" class="btn btn-danger"><i
                                        class="fa fa-trash"></i> {{trans('table.delete')}}</button>
                            <a href="{{ url($type) }}" class="btn btn-warning"><i
                                        class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
