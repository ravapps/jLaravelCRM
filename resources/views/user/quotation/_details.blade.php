<div class="panel panel-primary">
    <div class="panel-body">
        <div id="sendby_ajax" class="center-edit"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('customer', trans('quotation.agent_name'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ is_null($quotation->customer)?"":$quotation->customer->user->full_name }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('sales_team_id', trans('quotation.sales_team_id'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ is_null($quotation->salesTeam)?"":$quotation->salesTeam->salesteam }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('sales_person_id', trans('salesteam.main_staff'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ is_null($quotation->salesPerson)?"":$quotation->salesPerson->full_name }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('quotation.date')}}</label>
                    <div class="controls">
                        {{ $quotation->start_date }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('quotation.exp_date')}}</label>
                    <div class="controls">
                        {{ $quotation->expire_date }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('payment_term', trans('quotation.payment_term'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $quotation->payment_term }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('invoice_number', trans('quotation.status'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $quotation->status }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">{{trans('quotation.products')}}</label>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="detailes-tr">
                        <th>{{trans('quotation.product')}}</th>
                        <th>{{trans('quotation.description')}}</th>
                        <th>{{trans('quotation.quantity')}}</th>
                        <th>{{trans('quotation.unit_price')}}</th>
                        <th>{{trans('quotation.subtotal')}}</th>
                    </tr>
                    </thead>
                    <tbody id="InputsWrapper">
                    @if(isset($quotation)&& $quotation->quotationProducts->count()>0)
                        @foreach($quotation->quotationProducts as $index => $variants)
                            <tr class="remove_tr">
                                <td>
                                    {{$variants->product_name}}
                                </td>
                                <td>
                                    {{$variants->description}}
                                </td>
                                <td>
                                    {{$variants->pivot->quantity}}
                                </td>
                                <td>
                                    @money($variants->pivot->price)
                                </td>
                                <td>
                                    @money($variants->pivot->quantity*$variants->pivot->price)
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('total', trans('quotation.total'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        @money($quotation->total)
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('total', trans('quotation.tax_amount'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        @money($quotation->tax_amount)
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('total', trans('quotation.grand_total'), ['class' => 'control-label']) !!}
                    <div class="controls">
                          @money($quotation->grand_total)
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('total', trans('quotation.discount').' (%)', ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $quotation->discount}}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="form-group">
                    {!! Form::label('total', trans('quotation.final_price'), ['class' => 'control-label']) !!}
                    <div class="controls">
                          @money($quotation->final_price)
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('quotation_duration', trans('qtemplate.terms_and_conditions'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $quotation->terms_and_conditions }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url()->previous() }}" class="btn btn-warning"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                @else
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{trans('table.delete')}}
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-warning"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                @endif
            </div>
        </div>
    </div>
</div>
