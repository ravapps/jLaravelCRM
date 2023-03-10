


<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($quotation))
            {!! Form::model($quotation, ['url' => $type . '/' . $quotation->id, 'id' => 'quotation', 'method' => 'put', 'files'=> true, 'onsubmit'=>'return lastfrmcheck();']) !!}
            <div id="sendby_ajax" class="center-edit"></div>
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'quotation','onsubmit'=>'return lastfrmcheck();']) !!}
        @endif
            <div class="row">
              <div class="col-xs-12 col-sm-2">
                  <div class="form-group {{ $errors->has('grand_total') ? 'has-error' : '' }}">
                      {!! Form::label('quotation_no', trans('quotation.quotation_no'), ['class' => 'control-label']) !!}
                      <div class="controls">
                          {!! Form::text('quotation_num', isset($quotation_num)?$quotation_num:$quotation->quotations_number, ['class' => 'form-control','readonly']) !!}
                          <span class="help-block">{{ $errors->first('grand_total', ':message') }}</span>
                      </div>
                  </div>
              </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                        {!! Form::label('company_id', trans('company.company_name'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('company_id', $companies, (isset($quotation->company_id)?$quotation->company_id:null), ['id'=>'company_id','class' => 'form-control']) !!}  <a href="{{url('quotation/createcompany')}}">{{ trans('company.create_company') }}</a>
                            <span class="help-block">{{ $errors->first('customer_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                        {!! Form::label('customer_id', trans('quotation.agent_name'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('customer_id', $customers, (isset($quotation->customer_id)?$quotation->customer_id:null), ['id'=>'customer_id','class' => 'form-control']) !!}  <a href="#"  onclick="if(document.getElementById('company_id').value != '') { document.location.href='{{url('quotation/')}}/'+document.getElementById('company_id').value+'/createcustomer';} else { alert('Please select customer.'); return false; }">{{ trans('customer.create_agent') }}</a>
                            <span class="help-block">{{ $errors->first('customer_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6"  style="display:none;">
                    <div class="form-group {{ $errors->has('sales_team_id') ? 'has-error' : '' }}">
                        {!! Form::label('sales_team_id', trans('quotation.sales_team_id'), ['class' => 'control-label  required']) !!}
                        <div class="controls">
                            {!! Form::select('sales_team_id', $salesteams, (isset($quotation)?$quotation->sales_team_id:null), ['id'=>'sales_team_id','class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('sales_team_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6" style="display:none;">
                    <div class="form-group {{ $errors->has('sales_person_id') ? 'has-error' : '' }}">
                        {!! Form::label('sales_person_id', trans('salesteam.main_staff'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('sales_person_id', (isset($main_staff)?$main_staff:$staffs), (isset($quotation)?$quotation->sales_person_id:null), ['id'=>'sales_person_id','class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('sales_person_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group {{ $errors->has('qtemplate_id') ? 'has-error' : '' }}">
                        {!! Form::label('qtemplate_id', trans('quotation.quotation_template'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::select('qtemplate_id', $qtemplates, (isset($quotation)?$quotation->qtemplate_id:null), ['id'=>'qtemplate_id','class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('qtemplate_id', ':message') }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-6">
                    <div class="form-group {{ $errors->has('qsubject') ? 'has-error' : '' }}">
                        {!! Form::label('qsubject', trans('quotation.qsubject'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('qsubject', isset($qsubject) ? $quotation->qsubject : null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('qsubject', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                        {!! Form::label('date', trans('quotation.fdate'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('date', isset($quotation) ? $quotation->start_date : null, ['class' => 'form-control date']) !!}
                            <span class="help-block">{{ $errors->first('date', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('exp_date') ? 'has-error' : '' }}">
                        {!! Form::label('exp_date', trans('quotation.exp_days'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            <select name="exp_days" id="exp_days" class="form-control">
                              <option value="15">15 Days</option>
                              <option value="30">30 Days</option>
                              <option value="45">45 Days</option>
                              <option value="60">60 Days</option>
                            </select>
                            <span class="help-block">{{ $errors->first('exp_date', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('qtemplate_id') ? 'has-error' : '' }}">
                        {!! Form::label('quote_type', trans('quotation.quote_type'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('quote_type', $_quote_type, (isset($quotation)?$quotation->quote_type:null), ['id'=>'quote_type','class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('quote_type', ':message') }}</span>
                        </div>
                    </div>
                </div>




                <div class="col-xs-12 col-sm-4" style="display:none;">
                    <div class="form-group {{ $errors->has('exp_date') ? 'has-error' : '' }}">
                        {!! Form::label('exp_date', trans('quotation.exp_date'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('exp_date', isset($quotation) ? $quotation->expire_date : null, ['class' => 'form-control date exp_date']) !!}
                            <span class="help-block">{{ $errors->first('exp_date', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('payment_term') ? 'has-error' : '' }}">
                        {!! Form::label('payment_term', trans('quotation.payment_term'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('payment_term', $pay_terms, (isset($quotation)?$quotation->payment_term:null), ['id'=>'payment_term','class' => 'form-control']) !!}
                            <!-- <select name="payment_term" id="payment_term" class="form-control">
                                <option value=""></option>
                                @if(Settings::get('payment_term1')!='0')
                                    <option value="{{ Settings::get('payment_term1') }} {{trans('quotation.days')}}"
                                            @if(isset($quotation) &&  Settings::get('payment_term1') ." Days" == $quotation->payment_term) selected @endif>{{ Settings::get('payment_term1') }} {{trans('quotation.days')}}</option>
                                @endif
                                @if( Settings::get('payment_term2') !='0')
                                    <option value="{{ Settings::get('payment_term2') }} {{trans('quotation.days')}}"
                                            @if(isset($quotation) &&  Settings::get('payment_term2') ." Days" == $quotation->payment_term) selected @endif>{{ Settings::get('payment_term2') }} {{trans('quotation.days')}}</option>
                                @endif
                                @if( Settings::get('payment_term3') !='0')
                                    <option value="{{ Settings::get('payment_term3') }} {{trans('quotation.days')}}"
                                            @if(isset($quotation) &&  Settings::get('payment_term3') ." Days" == $quotation->payment_term) selected @endif>{{ Settings::get('payment_term3') }} {{trans('quotation.days')}}</option>
                                @endif
                                <option value="0 {{trans('quotation.days')}}"
                                        @if(isset($quotation) && $quotation->payment_term==0) selected @endif>{{trans('quotation.immediate_payment')}}</option>
                            </select>   --->

                            <span class="help-block">{{ $errors->first('payment_term', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', trans('quotation.status'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            <div class="input-group">
                                <label>
                                    <input type="radio" name="status" value="{{trans('quotation.draft_quotation')}}"
                                           class='icheckblue'
                                           @if(isset($quotation) && $quotation->status == trans('quotation.draft_quotation')) checked @endif>
                                    {{trans('quotation.draft_quotation')}}
                                </label>
                                <label>
                                    <input type="radio" name="status" value="{{trans('quotation.send_quotation')}}"
                                           class='icheckblue'
                                           @if(isset($quotation) && $quotation->status == trans('quotation.send_quotation')) checked @endif>
                                    {{trans('quotation.send_quotation')}}
                                </label>
                            </div>

                            <span class="help-block">{{ $errors->first('status', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('qplatform') ? 'has-error' : '' }}">
                        {!! Form::label('qplatform', trans('quotation.qplatform'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('qplatform', $_qplatform, (isset($quotation)?$quotation->qplatform:null), ['id'=>'qplatform','class' => 'form-control','required' => 'required']) !!}
                            <span class="help-block">{{ $errors->first('qplatform', ':message') }}</span>
                        </div>
                    </div>
                </div>


            </div>

            @php
              $servicecount = 0;
              $productcount = 0;
            @endphp

            @if(isset($quotation)&& $quotation->quotationProductsList->count()>0)
              @foreach($quotation->quotationProductsList as $ite)
                @if($ite->dayperiod > 0)
                  @php $servicecount = $servicecount + 1; @endphp
                @else
                  @php $productcount = $productcount + 1; @endphp
                @endif
              @endforeach
            @endif


            <div class="row">
                @if($productcount > 0)<div class="col-md-12" id="tblproducts">@else<div class="col-md-12 hide" id="tblproducts">@endif
                    <label class="control-label required">{{trans('quotation.productsa')}}
                        <span>{!! $errors->first('products') !!}</span></label>
                    <small class="has-error @if(isset($quotation)) hide @endif" id="errPrd" style="color:red;">Please add/select an item.</small>
                    <div class="table-responsive">
                        <table class="table products_table table-bordered">
                            <thead>
                            <tr class="detailes-tr">
                                <th>{{trans('quotation.product')}}</th>
                                <th>{{trans('quotation.description')}}</th>
                                <th>{{trans('quotation.quantity')}}</th>
                                <th>{{trans('quotation.unit_price')}}</th>
                                <th>{{trans('quotation.subtotal')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="InputsWrapper">

                            @if(isset($quotation)&& $quotation->quotationProducts->count()>0)
                                @foreach($quotation->quotationProductsList as $index => $variants)
                                    @if($variants->dayperiod == 0)
                                    <tr class="remove_tr">
                                        <td>
                                            <input type="hidden" name="product_id[]" id="product_id{{$index}}"
                                                   value="{{$variants->product_id}}"
                                                   readOnly>
                                            <select name="product_list" id="product_list{{$index}}" class="form-control product_list"
                                                    data-search="true" onchange="product_value({{$index}});">
                                                <option value=""></option>
                                                @foreach( $products as $product)
                                                    @if($product->is_service == 0)
                                                    <option value="{{ $product->id . '_' . $product->description. '_' . $product->quantity_on_hand.'_'.$product->sale_price}}"
                                                            @if($product->id == $variants->product_id) selected="selected" @endif>
                                                        {{ $product->product_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        <td><textarea name=description[]" id="description{{$index}}" rows="2"
                                                      class="form-control resize_vertical" readOnly>{{$variants->QuoteProductsDetails->description}}</textarea>
                                        </td>
                                        <td><input type="number" name="quantity[]" id="quantity{{$index}}" min="1"
                                                   value="{{$variants->quantity}}"
                                                   class="form-control number"
                                                   onkeyup="product_price_changes('quantity{{$index}}','price{{$index}}','sub_total{{$index}}');">
                                        </td>
                                        <td><input type="text" name="price[]" id="price{{$index}}"
                                                   value="{{$variants->QuoteProductsDetails->sale_price}}"
                                                   class="form-control" readonly></td>
                                        <input type="hidden" name="taxes[]" id="taxes{{$index}}"
                                               value="{{ floatval($sales_tax) }}" class="form-control"></td>
                                        <td><input type="text" name="sub_total[]" id="sub_total{{$index}}"
                                                   value="{{$variants->quantity*$variants->QuoteProductsDetails->sale_price}}"
                                                   class="form-control" readOnly></td>
                                        <td><a href="javascript:void(0)" class="delete removeclass"><i
                                                        class="fa fa-fw fa-trash fa-lg text-danger"></i></a></td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="button" id="AddMoreFile"
                                class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> {{trans('quotation.add_product')}}
                        </button>
                    </div>
                </div>
            </div>


            <!----- Services Part here ---->
            <div class="row">
                @if($servicecount > 0)<div class="col-md-12" id="tblservices">@else <div class="col-md-12 hide" id="tblservices"> @endif
                    <label class="control-label required">{{trans('quotation.productsb')}}
                        </label>




                        <small class="has-error  @if(isset($quotation)) hide @endif" id="errSrv" style="color:red;">Please add/select an item.</small>

                    <div class="table-responsive">
                        <table class="table products_table table-bordered">
                            <thead>
                            <tr class="detailes-tr">
                                <th>{{trans('quotation.product')}}</th>
                                <th>{{trans('quotation.description')}}</th>
                                <th>{{trans('quotation.unit_charge')}}</th>
                                <th>{{trans('quotation.frequency')}}</th>
                                <th>{{trans('quotation.unit_price')}}</th>
                                <th>{{trans('quotation.subtotal')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="ServiceInputsWrapper">

                              @if(isset($quotation)&& $quotation->quotationProducts->count()>0)
                                  @foreach($quotation->quotationProductsList as $index => $variants)
                                      @if($variants->dayperiod > 0)

                                    <tr class="remove_tr">
                                        <td>
                                            <input type="hidden" name="sproduct_id[]" id="sproduct_id{{$index}}"
                                                   value="{{$variants->product_id}}"
                                                   readOnly>
                                            <select name="sproduct_list" id="sproduct_list{{$index}}" class="form-control product_list"
                                                    data-search="true" onchange="serviceproduct_value({{$index}});">
                                                <option value=""></option>
                                                @foreach( $products as $product)
                                                  @if($product->is_service == 1)
                                                    <option value="{{ $product->id . '_' . $product->description. '_' . $product->quantity_on_hand.'_'.$product->sale_price}}"
                                                            @if($product->id == $variants->product_id) selected="selected" @endif>
                                                        {{ $product->product_name}}</option>
                                                  @endif
                                                @endforeach
                                            </select>
                                        <td><textarea name="sdescription[]" id="sdescription{{$index}}" rows="2"
                                                      class="form-control resize_vertical" readOnly>{{$variants->QuoteProductsDetails->description}}</textarea>
                                        </td>
                                        <td><select name="scharge[]" id="scharge{{$index}}" class="form-control scharge" data-search="true" onchange="serviceproduct_price_changes('scharge{{$index}}','squantity{{$index}}','sprice{{$index}}','ssub_total{{$index}}');">
                                        <option selected value="1" @if($variants->dayperiod == 1) selected @endif >Daily</option><option @if($variants->dayperiod == 7) selected @endif value="7">Weekly</option><option @if($variants->dayperiod == 30) selected @endif value="30">Monthly</option><option @if($variants->dayperiod == 90) selected @endif value="90">Quarterly</option><option @if($variants->dayperiod == 180) selected @endif value="180">Half Yearly</option><option @if($variants->dayperiod == 360) selected @endif value="360">Annually</option>
                                        </select></td>
                                        <td><input type="number" name="squantity[]" id="squantity{{$index}}" min="1"
                                                   value="{{$variants->quantity}}"
                                                   class="form-control number"
                                                   onkeyup="serviceproduct_price_changes('scharge{{$index}}','squantity{{$index}}','sprice{{$index}}','ssub_total{{$index}}');">
                                        </td>
                                        <td><input type="text" name="sprice[]" id="sprice{{$index}}"
                                                   value="{{$variants->QuoteProductsDetails->sale_price}}"
                                                   class="form-control" readonly></td>
                                        <input type="hidden" name="staxes[]" id="staxes{{$index}}"
                                               value="{{ floatval($sales_tax) }}" class="form-control"></td>
                                        <td><input type="text" name="ssub_total[]" id="ssub_total{{$index}}"
                                                   value="{{$variants->dayperiod*$variants->quantity*$variants->QuoteProductsDetails->sale_price}}"
                                                   class="form-control" readOnly></td>
                                        <td><a href="javascript:void(0)" class="delete removeclass"><i
                                                        class="fa fa-fw fa-trash fa-lg text-danger"></i></a></td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="button" id="AddMoreService"
                                class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add a service
                        </button>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group {{ $errors->has('total') ? 'has-error' : '' }}">
                        {!! Form::label('total', trans('quotation.total'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('total', null, ['class' => 'form-control','readonly']) !!}
                            <span class="help-block">{{ $errors->first('total', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                        {!! Form::label('discount', trans('quotation.discount').' (%)', ['class' => 'control-label']) !!}
                        @if(isset($quotation))
                        <input type="checkbox" name="discount_is_fixed" id="discount_is_fixed" <?php if($quotation->discount_is_fixed == 1) echo "checked"; ?> value="1"> {{trans('quotation.isfixed')}}
                        @else
                        <input type="checkbox" name="discount_is_fixed" id="discount_is_fixed"  value="1"> {{trans('quotation.isfixed')}}
                        @endif
                        <div class="controls">
                            <input type="text" name="discount" id="discount"
                                   value="{{(isset($quotation)?$quotation->discount:"0.00")}}"
                                   class="form-control number"
                                   onkeyup="update_total_price();">
                            <span class="help-block">{{ $errors->first('discount', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('grand_total') ? 'has-error' : '' }}">
                        {!! Form::label('grand_total', trans('quotation.grand_total'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('grand_total', null, ['class' => 'form-control','readonly']) !!}
                            <span class="help-block">{{ $errors->first('grand_total', ':message') }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('tax_amount') ? 'has-error' : '' }}">
                        {!! Form::label('tax_amount', trans('quotation.tax_amount').' ('.floatval(Settings::get('sales_tax')).'%)', ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('tax_amount', null, ['class' => 'form-control','readonly']) !!}
                            <span class="help-block">{{ $errors->first('tax_amount', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2">
                    <div class="form-group {{ $errors->has('final_price') ? 'has-error' : '' }}">
                        {!! Form::label('final_price', trans('quotation.final_price'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('final_price', null, ['class' => 'form-control','readonly']) !!}
                            <span class="help-block">{{ $errors->first('final_price', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('terms_and_conditions') ? 'has-error' : '' }}">
                        {!! Form::label('remarks', trans('quotation.remarks'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::textarea('remarks', null, ['class' => 'form-control resize_vertical']) !!}
                            <span class="help-block">{{ $errors->first('remarks', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('terms_and_conditions') ? 'has-error' : '' }}">
                        {!! Form::label('quotation_duration', trans('qtemplate.terms_and_conditions'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::textarea('terms_and_conditions', null, ['class' => 'form-control resize_vertical tinymce-editor']) !!}
                            <span class="help-block">{{ $errors->first('terms_and_conditions', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Actions -->
            <div class="form-group">
                <div class="controls">
                  @if($lead <> "")
                  <input type="hidden" name="convertleadid" value="{{$lead->customer_id}}">
                  @endif

                    <button type="submit" id="sbfrm" class="btn btn-success"><i
                                class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-warning"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                </div>
            </div>
        <!-- ./ form actions -->
        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
<script>

</script>
    <script>
        $(document).ready(function(){




          $("#quotation").bootstrapValidator({
              fields: {
                company_id: {
                    validators: {
                        notEmpty: {
                            message: 'The customer field is required.'
                        }
                    }
                },
                customer_id: {
                      validators: {
                          notEmpty: {
                              message: 'The customer contact field is required.'
                          }
                      }
                  },
                  date: {
                      validators: {
                          notEmpty: {
                              message: 'The start date field is required.'
                          }
                      }
                  },
                  payment_term: {
                      validators: {
                          notEmpty: {
                              message: 'The payment term field is required.'
                          }
                      }
                  },
                  status: {
                      validators: {
                          notEmpty: {
                              message: 'The quotation status field is required.'
                          }
                      }
                  },
                  product_list: {
                      validators: {
                          notEmpty: {
                              message: 'The products field is required.'
                          }
                      }
                  },
                  qsubject: {
                      validators: {
                          notEmpty: {
                              message: 'The subject field is required.'
                          }
                      }
                  },
                  quote_type: {
                      validators: {
                          notEmpty: {
                              message: 'The quote type field is required.'
                          }
                      }
                  },
                  sproduct_list: {
                      validators: {
                          notEmpty: {
                              message: 'The products field is required.'
                          }
                      }
                  }
              }
          });





          $("#company_id").change(function(){
              ajaxCustomersList($(this).val());
          });

          @if(old('company_id'))
          ajaxCustomersList({{old('company_id')}});
          $("#customer_id").val({{old('customer_id')}});\
          $("#exp_days").val({{old('exp_days')}});
          @endif

          @if(isset($ofcompanyid))
          $('#company_id').val({{$ofcompanyid}}).change();
          document.getElementById('company_id').value = {{$ofcompanyid}};

          ajaxCustomersList({{$ofcompanyid}});

            @if(isset($ofcustomerid))
            $(document).ajaxStop(function () {
              console.log('ajaxdone');
              $("#customer_id").val({{$ofcustomerid}}).change();
            });
            @endif
          @endif



          @if (isset($quotation))
          ajaxCustomersList({{$quotation->company_id}});
           $("#customer_id option[value='{{$quotation->customer_id}}']").prop('selected', true);
           $("#exp_days option[value='{{$quotation->exp_days}}']").prop('selected', true);
          @endif
          @if($lead <> "")
          $("#company_id option[value='{{$lead->company_id}}']").prop('selected', true);
          ajaxCustomersList({{$lead->company_id}});
          @endif


          function ajaxCustomersList(id){
            console.log(id);
              $.ajax({
                  type: "GET",
                  url: '{{ url('customer/ajax_customer_list')}}',
                  data: {'id': id, _token: '{{ csrf_token() }}' },
                  success: function (data) {
                      $("#customer_id").empty();
                      $("#customer_id").prop('disabled', true);
                      $.each(data.customer_name, function (val, text) {
                          $('#customer_id').append($('<option></option>').val(val).html(text));
                      });
                      $("#customer_id").prop('disabled', false);

                      @if (isset($quotation))
                       $("#customer_id option[value='{{$quotation->customer_id}}']").prop('selected', true);
                      @endif
                      @if($lead <> "")
                      $("#customer_id option[value='{{$lead->customer_id}}']").prop('selected', true);
                      @endif
                      //$('#quotation').bootstrapValidator('revalidateField', 'customer_id');
                  }
              });
          }



});



































        //$(function () {
            //update_total_price();
            $('#qtemplate_id').change(function () {
                if ($(this).val() > 0) {
                    $.ajax({
                        type: "GET",
                        url: '{{url("quotation/ajax_qtemplates_products")}}/' + $(this).val(),
                        success: function (data) {
                            content_data = '';
                            scontent_data = '';
                            $.each(data, function (i, item) {
                              if(item.dayperiod == 0) {
                                $('#tblproducts').removeClass('hide');
                                content_data += makeContent(FieldCount, item);
                                FieldCount++;
                                x++;
                              }
                              if(item.dayperiod > 0) {
                                $('#tblservices').removeClass('hide');
                                scontent_data += makeServiceContent(ServiceFieldCount, item);
                                ServiceFieldCount++;
                                y++;
                              }
                            });
                            $("#InputsWrapper").html(content_data);
                            $("#ServiceInputsWrapper").html(scontent_data);
                            //$("input[name='terms_and_conditions']").val();

                            update_total_price();
                        }
                    });
                }

            });
        //});


        $('#discount_is_fixed').change(function() {
           update_total_price()
        });


        function lastfrmcheck() {

          console.log(x);
          console.log(y);
          //if(x <= 1 && y <= 1) {
            console.log($("#sbfrm"));
            if($('#qplatform').val() == "Service" || $('#qplatform').val() == "Product / Service") {
              if(y<=1) {
                $('#errSrv').removeClass('hide');
                $("#sbfrm").prop('disabled', false);
                return false;
              } else {
                tsub_total = 0;
                $('input[name^="ssub_total"]').each(function () {
                    tsub = $(this).val();
                    if(tsub.length < 1) {
                        tsub = 0;
                    }
                    tsub_total += parseFloat(tsub);
                });
                if(tsub_total == 0) {
                  $('#errSrv').removeClass('hide');
                  $("#sbfrm").prop('disabled', false);
                  return false;
                }
              }
            }
            if($('#qplatform').val() == "Product" || $('#qplatform').val() == "Product / Service") {
              if(x<=1) {
                $('#errPrd').removeClass('hide');
                $("#sbfrm").prop('disabled', false);
                return false;
              } else {
                tsub_total = 0;
                $('input[name^="sub_total"]').each(function () {
                    tsub = $(this).val();
                    if(tsub.length < 1) {
                        tsub = 0;
                    }
                    tsub_total += parseFloat(tsub);
                });
                if(tsub_total == 0) {
                  $('#errPrd').removeClass('hide');
                  $("#sbfrm").prop('disabled', false);
                  return false;
                }
              }
            }
            // final_price


          //} else {
             return true;

        //  }



        }

        function product_value(FieldCount) {
            var all_Val = $("#product_list" + FieldCount).val();
            var res = all_Val.split("_");
            $('#product_id' + FieldCount).val(res[0]);
            $('#description' + FieldCount).val(res[1]);
            $('#quantity' + FieldCount).val(res[2]);
            $('#price' + FieldCount).val(res[3]);
            var quantity=$('#quantity'+FieldCount).val();
            var price=$('#price'+FieldCount).val();
            $('#sub_total' + FieldCount).val(price*quantity);
            $('#errPrd').addClass('hide');
            update_total_price();
        }

        function serviceproduct_value(FieldCount) {
            var all_Val = $("#sproduct_list" + FieldCount).val();
            console.log(all_Val);
            var res = all_Val.split("_");
            $('#sproduct_id' + FieldCount).val(res[0]);
            $('#sdescription' + FieldCount).val(res[1]);
            if(res[2] == 0) {
              $('#squantity' + FieldCount).val(1);
            } else {
              $('#squantity' + FieldCount).val(res[2]);
            }
            $('#sprice' + FieldCount).val(res[3]);
            //$('#scharge' + FieldCount).val(res[3]);
            var quantity=$('#squantity'+FieldCount).val();
            var price=$('#sprice'+FieldCount).val();
            var chrg = $('#scharge'+FieldCount).val();

            $('#ssub_total' + FieldCount).val(chrg*price*quantity);
            $('#errSrv').addClass('hide');
            update_total_price();
        }

        function product_price_changes(quantity, product_price, sub_total_id) {
            var no_quantity = $("#" + quantity).val();
            if(no_quantity.length < 1) {
                no_quantity = 0;
            }
            var no_product_price = $("#" + product_price).val();
            if(no_product_price.length < 1) {
                no_product_price = 0;
            }

            var sub_total = parseFloat(no_quantity * no_product_price);

            var tax_amount = 0;
            tax_amount = (sub_total * {{ floatval(Settings::get('sales_tax')) }}) / 100;
            $('#taxes').val(tax_amount.toFixed(2));

            $('#' + sub_total_id).val(sub_total);
            update_total_price();

        }


        function serviceproduct_price_changes(charge, quantity, product_price, sub_total_id) {
            var no_charge = $("#" + charge).val();

            var no_quantity = $("#" + quantity).val();
            if(no_quantity.length < 1) {
                no_quantity = 0;
            }
            var no_product_price = $("#" + product_price).val();
            if(no_product_price.length < 1) {
                no_product_price = 0;
            }

            var sub_total = parseFloat(no_charge * no_quantity * no_product_price);

            var tax_amount = 0;
            tax_amount = (sub_total * {{ floatval(Settings::get('sales_tax')) }}) / 100;
            $('#taxes').val(tax_amount.toFixed(2));

            $('#' + sub_total_id).val(sub_total);
            update_total_price();

        }




        function update_total_price() {
            var sub_total = 0;
            $('#total').val(0);
            $('#tax_amount').val(0);
            $('#grand_total').val(0);
            $('#final_price').val(0);
            var sub = 0;
            $('input[name^="sub_total"]').each(function () {
                sub = $(this).val();
                if(sub.length < 1) {
                    sub = 0;
                }
                sub_total += parseFloat(sub);
                $('#total').val(sub_total.toFixed(2));

                var discount = $("#discount").val();
                if($('#discount_is_fixed').prop("checked")) {
                  discount_amount =  discount;
                }
                else {
                    discount_amount = (sub_total * discount) / 100;
                }

                var grand_total = 0;
                grand_total = sub_total - discount_amount;
                $('#grand_total').val(grand_total.toFixed(2));


                var tax_per = {{ floatval(Settings::get('sales_tax')) }};
                var tax_amount = 0;

                tax_amount = (grand_total * tax_per) / 100;
                $('#tax_amount').val(tax_amount.toFixed(2));




                final_price = grand_total + tax_amount;
                $('#final_price').val(final_price.toFixed(2));
            });

            $('input[name^="ssub_total"]').each(function () {
                sub = $(this).val();
                if(sub.length < 1) {
                    sub = 0;
                }
                sub_total += parseFloat(sub);
                $('#total').val(sub_total.toFixed(2));

                var discount = $("#discount").val();
                if($('#discount_is_fixed').prop("checked")) {
                  discount_amount =  discount;
                }
                else {
                    discount_amount = (sub_total * discount) / 100;
                }

                var grand_total = 0;
                grand_total = sub_total - discount_amount;
                $('#grand_total').val(grand_total.toFixed(2));


                var tax_per = {{ floatval(Settings::get('sales_tax')) }};
                var tax_amount = 0;

                tax_amount = (grand_total * tax_per) / 100;
                $('#tax_amount').val(tax_amount.toFixed(2));




                final_price = grand_total + tax_amount;
                $('#final_price').val(final_price.toFixed(2));
            });



        }

        function makeContent(number, item) {
            item = item || '';

            var content = '';
            content += '<tr class="remove_tr"><td>';
            content += '<input type="hidden" name="product_id[]" id="product_id' + number + '" value="' + ((typeof item.product_id == 'undefined') ? '' : item.product_id) + '" readOnly>';
            content += '<select name="product_list" id="product_list' + number + '" class="form-control product_list" data-search="true" onchange="product_value(' + number + ');">' +
                '<option value=""></option>';
            @foreach( $products as $product)
                @if($product->is_service == 0)
                content += '<option value="{{ $product->id . '_' . $product->description.'_'.$product->quantity_on_hand.'_'.$product->sale_price}}"';
            if ((typeof item.product_id == 'undefined') ? '' : item.product_id =={{$product->id}}) {
                content += 'selected';
            }
            content += '>' +
                '{{ $product->product_name}}</option>';
                @endif
            @endforeach

                content += '</select>' +
                '<td><textarea name=description[]" id="description' + number + '" rows="2" class="form-control resize_vertical" readOnly>' + ((typeof item.description == 'undefined') ? '' : item.description) + '</textarea>' +
                '</td>' +
                '<td><input type="number" min="1" name="quantity[]" id="quantity' + number + '" value="' + ((typeof item.quantity == 'undefined') ? '' : item.quantity) + '" class="form-control number" onkeyup="product_price_changes(\'quantity' + number + '\',\'price' + number + '\',\'sub_total' + number + '\');"></td>' +
                '<td><input type="text" name="price[]" id="price' + number + '" value="' + ((typeof item.price == 'undefined') ? '' : item.price) + '" class="form-control" readOnly>' +
                '<input type="hidden" name="taxes[]" id="taxes' + number + '" value="{{floatval($sales_tax)}}" class="form-control" readOnly></td>' +
                '<td><input type="text" name="sub_total[]" id="sub_total' + number + '" value="' + ((typeof item.quantity == 'undefined') ? '' : item.quantity*item.price) + '" class="form-control" readOnly></td>' +
                '<td><a href="javascript:void(0)" class="delete removeclass" title="{{ trans('table.delete') }}"><i class="fa fa-fw fa-trash fa-lg text-danger"></i></a></td>' +
                '</tr>';
            return content;
        }


        function makeServiceContent(number, item) {
            item = item || '';

            var content = '';
            content += '<tr class="remove_tr"><td>';
            content += '<input type="hidden" name="sproduct_id[]" id="sproduct_id' + number + '" value="' + ((typeof item.product_id == 'undefined') ? '' : item.product_id) + '" readOnly>';
            content += '<select name="sproduct_list" id="sproduct_list' + number + '" class="form-control product_list" data-search="true" onchange="serviceproduct_value(' + number + ');">' +
                '<option value=""></option>';
            @foreach( $products as $product)
                @if($product->is_service == 1)
                content += '<option value="{{ $product->id . '_' . $product->description.'_'.$product->quantity_on_hand.'_'.$product->sale_price}}"';
            if ((typeof item.product_id == 'undefined') ? '' : item.product_id =={{$product->id}}) {
                content += 'selected';
            }
            content += '>' +
                '{{ $product->product_name}}</option>';
                @endif
            @endforeach

                content += '</select>' +
                '<td><textarea name=sdescription[]" id="sdescription' + number + '" rows="2" class="form-control resize_vertical" readOnly>' + ((typeof item.description == 'undefined') ? '' : item.description) + '</textarea>' +
                '</td>' +
                '<td><select name="scharge[]" id="scharge' + number + '" class="form-control scharge" data-search="true" onchange="serviceproduct_price_changes(\'scharge' + number + '\',\'squantity' + number + '\',\'sprice' + number + '\',\'ssub_total' + number + '\');">' +
                '<option ' + ((typeof item.dayperiod == 'undefined') ? '' : (item.dayperiod == 1) ? 'selected' : '') + ' value="1">Daily</option><option  ' + ((typeof item.dayperiod == 'undefined') ? '' : ((item.dayperiod == 7) ? 'selected' : '')) + '  value="7">Weekly</option><option  ' + ((typeof item.dayperiod == 'undefined') ? '' : (item.dayperiod == 30) ? 'selected' : '') + '  value="30">Monthly</option><option ' + ((typeof item.dayperiod == 'undefined') ? '' : ((item.dayperiod == 90) ? 'selected' : '')) + ' value="90">Quarterly</option><option ' + ((typeof item.dayperiod == 'undefined') ? '' : ((item.dayperiod == 180) ? 'selected' : '')) + ' value="180">Half Yearly</option><option ' + ((typeof item.dayperiod == 'undefined') ? '' : ((item.dayperiod == 360) ? 'selected' : '')) + ' value="360">Annually</option>' +
                '</select></td>' +
                '<td><input type="number" min="1" name="squantity[]" id="squantity' + number + '" value="' + ((typeof item.quantity == 'undefined') ? '' : item.quantity) + '" class="form-control number" onkeyup="serviceproduct_price_changes(\'scharge' + number + '\',\'squantity' + number + '\',\'sprice' + number + '\',\'ssub_total' + number + '\');"></td>' +
                '<td><input type="text" name="sprice[]" id="sprice' + number + '" value="' + ((typeof item.price == 'undefined') ? '' : item.price) + '" class="form-control" readOnly>' +
                '<input type="hidden" name="staxes[]" id="staxes' + number + '" value="{{floatval($sales_tax)}}" class="form-control" readOnly></td>' +
                '<td><input type="text" name="ssub_total[]" id="ssub_total' + number + '" value="' + ((typeof item.quantity == 'undefined') ? '' : item.dayperiod*item.quantity*item.price) + '" class="form-control" readOnly></td>' +
                '<td><a href="javascript:void(0)" class="delete removeclass" title="{{ trans('table.delete') }}"><i class="fa fa-fw fa-trash fa-lg text-danger"></i></a></td>' +
                '</tr>';
            return content;
        }


        var MaxInputs = 50; //maximum input boxes allowed
        var ServiceMaxInputs = 50;
        var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
        var ServiceInputsWrapper = $("#ServiceInputsWrapper");

        var AddButton = $("#AddMoreFile"); //Add button ID
        var AddServiceButton = $("#AddMoreService");

        @if(isset($quotation))
          var x = {{($productcount+1)}}; //initlal text box count
          var y = {{($servicecount+1)}};
        @else
        var x = InputsWrapper.length; //initlal text box count
        var y = ServiceInputsWrapper.length;
        @endif

        @php
          if($servicecount == 0) {
            $servicecount = 1;
          }
          if($productcount == 0) {
            $productcount = 1;
          }
        @endphp

        var FieldCount = {{$productcount}}; //to keep track of text box added
        var ServiceFieldCount = {{$servicecount}};

        $("#total").val("0");

        $('#qplatform').change(function() {
           if($('#qplatform').val() == 'Product') {
             $('#tblproducts').removeClass('hide');
             $('#tblservices').addClass('hide');
             $('input[name^="ssub_total"]').each(function () {
               $(this).parent().parent().remove(); //remove text box
               y--;
             });
             console.log(ServiceInputsWrapper.length);
             console.log(y);
           }
           if($('#qplatform').val() == 'Service') {
             $('#tblservices').removeClass('hide');
             $('#tblproducts').addClass('hide');
             console.log(InputsWrapper.length);
             console.log(x);

             $('input[name^="sub_total"]').each(function () {
               $(this).parent().parent().remove(); //remove text box
               x--;
             });
           }
           if($('#qplatform').val() == 'Product / Service') {
             $('#tblservices').removeClass('hide');
             $('#tblproducts').removeClass('hide');
           }
           update_total_price();
        });



        $(AddServiceButton).click(function (e)  //on add input button click
        {
          setTimeout(function(){

              //quantityChange(); // ?????
          });
          if (y <= ServiceMaxInputs) //max input box allowed
          {
            ServiceFieldCount++;
            scontent = makeServiceContent(ServiceFieldCount);
            $(ServiceInputsWrapper).append(scontent);
            y++; //text box increment
            //$('#quotation').data('bootstrapValidator').validate();
          }
          return false;
        });



        $(AddButton).click(function (e)  //on add input button click
        {

            setTimeout(function(){

                quantityChange();
            });
            if (x <= MaxInputs) //max input box allowed
            {
                FieldCount++; //text box added increment
                content = makeContent(FieldCount);
                $(InputsWrapper).append(content);
                x++; //text box increment
                //$('#quotation').data('bootstrapValidator').validate();
                $('.number').keypress(function (event) {
                    if (event.which < 46
                        || event.which > 59) {
                        event.preventDefault();
                    } // prevent if not number/dot

                    if (event.which == 46
                        && $(this).val().indexOf('.') != -1) {
                        event.preventDefault();
                    } // prevent if already dot
                });
            }
            //            $('#surveyForm').formValidation('addField', $option);

            return false;
        });




        quantityChange();
        function quantityChange(){
            $(".number").bind("keyup change click",function(){
                var no_quantity = $(this).val();
                var no_product_price = $(this).closest("tr").find("input[name='price[]']").val();
                var sub_total = parseFloat(no_quantity * no_product_price);
                var tax_amount = 0;
                tax_amount = (sub_total * {{floatval($sales_tax)}}) / 100;
                $('#taxes').val(tax_amount.toFixed(2));
                $(this).closest("tr").find("input[name='sub_total[]']").val(sub_total);
                update_total_price();
            });
        }

        $(InputsWrapper).on("click", ".removeclass", function (e) { //user click on remove text
            @if(!isset($quotation))
            if (x > 0) {
                $(this).parent().parent().remove(); //remove text box
                x--; //decrement textbox
            }
            @else
            $(this).parent().parent().remove(); //remove text box
            x--; //decrement textbox
            @endif
            update_total_price();
            return false;
        });

        $(ServiceInputsWrapper).on("click", ".removeclass", function (e) { //user click on remove text
            @if(!isset($quotation))
            if (y > 0) {
                $(this).parent().parent().remove(); //remove text box
                y--; //decrement textbox
            }
            @else
            $(this).parent().parent().remove(); //remove text box
            y--; //decrement textbox
            @endif
            update_total_price();
            return false;
        });


        function create_pdf(quotation_id) {
            $.ajax({
                type: "GET",
                url: "{{url('quotation' )}}/" + quotation_id + "/ajax_create_pdf",
                data: {'_token': '{{csrf_token()}}'},
                success: function (msg) {
                    if (msg != '') {
                        $("#pdf_url").attr("href", msg);
                        var index = msg.lastIndexOf("/") + 1;
                        var filename = msg.substr(index);
                        $("#pdf_url").html(filename);
                        $("#quotation_pdf").val(filename);
                    }
                }
            });
        }

        $('#quotation').on('keyup keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });

        var dateFormat = '{{ config('settings.date_format') }}';
        flatpickr('#date',{
            minDate: '{{ isset($quotation) ? $quotation->created_at : now() }}',
            dateFormat: dateFormat,
            disableMobile: "true"
        });

        @if(old('payment_term'))
            $("#payment_term").find("option[value='"+'{{old("payment_term")}}'+"']").attr('selected',true);
        @endif

        $("#sales_team_id").change(function(){
            //ajaxMainStaffList($(this).val());
        });
        @if(old('sales_person_id'))
        //ajaxMainStaffList({{old('sales_team_id')}});
        @endif
        function ajaxMainStaffList(id){
            $.ajax({
                type: "GET",
                url: '{{ url('opportunity/ajax_main_staff_list')}}',
                data: {'id': id, _token: '{{ csrf_token() }}' },
                success: function (data) {
                    $("#sales_person_id").empty();
                    var teamLeader;
                    $.each(data.main_staff, function (val, text) {
                        teamLeader =data.team_leader;
                        $('#sales_person_id').append($('<option></option>').val(val).html(text));
                    });
                    $("#sales_person_id").find("option[value='"+teamLeader+"']").attr('selected',true);
                    $("#sales_person_id").find("option[value!='"+teamLeader+"']").attr('selected',false);
                    {{--$("#sales_person_id").select2({--}}
                        {{--theme:'bootstrap',--}}
                        {{--placeholder:"{{ trans('salesteam.main_staff') }}"--}}
                    {{--});--}}
                    $('#quotation').bootstrapValidator('revalidateField', 'sales_person_id');
                }
            });
        }
        //$("#customer_id").change(function(){
            //ajaxSalesTeamList($(this).val());
        //});
        @if(old('sales_team_id'))
        //ajaxSalesTeamList({{old('customer_id')}});
        @endif
        @if(!isset($quotation))
        //$("#sales_team_id").empty();
        //$("#sales_person_id").empty();
        @endif
        function ajaxSalesTeamList(id){
            $.ajax({
                type: "GET",
                url: '{{ url('quotation/ajax_sales_team_list')}}',
                data: {'id': id, _token: '{{ csrf_token() }}' },
                success: function (data) {
                    $("#sales_team_id").empty();
                    $.each(data.sales_team, function (val, text) {
                        $('#sales_team_id').append($('<option></option>').val(val).html(text));
                    });
                    $("#sales_team_id").find("option[value='"+data.agent_name+"']").attr('selected',true);
                    $("#sales_team_id").find("option[value!='"+data.agent_name+"']").attr('selected',false);
                    {{--$("#sales_team_id").select2({--}}
                        {{--theme:'bootstrap',--}}
                        {{--placeholder:"{{ trans('quotation.sales_team_id') }}"--}}
                    {{--});--}}
                    ajaxMainStaffList(data.agent_name);
                    $('#quotation').bootstrapValidator('revalidateField', 'sales_team_id');
                }
            });
        }


/*
        $("#send_quotation").bootstrapValidator({
            fields: {
                'recipients[]': {
                    validators: {
                        notEmpty: {
                            message: 'The recipients field is required'
                        }
                    }
                },
                message_body:{
                    validators: {
                        notEmpty: {
                            message: 'The message field is required'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{url('quotation/send_quotation')}}",
                data: $('#send_quotation').serialize(),
                success: function(msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#sendby_ajax").html(msg);
                    setTimeout(function(){
                        $("#sendby_ajax").hide();
                    },5000);
                    $("#modal-send_by_email").modal('hide');
                },
                error: function(data) {
                    alert("Something's wrong, please check the errors and try again");
                }
            });
        });

        $("#modal-send_by_email").on('hide.bs.modal', function () {
            $("#recipients").find("option").attr('selected',false);
            $("#recipients").select2({
                placeholder:"{{ trans('quotation.recipients') }}",
                theme: 'bootstrap'
            });
            $("#send_quotation").data('bootstrapValidator').resetForm();
        });
        $('.icheckblue').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        $('.icheckblue').on('ifChecked',function(){
            $("#quotation").bootstrapValidator('revalidateField', 'status');
        });  */
    </script>

     <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
     <script type="text/javascript">
         tinymce.init({
             selector: 'textarea.tinymce-editor',
             height: 100,
             menubar: false,
             plugins: [
                 'advlist autolink lists link image charmap print preview anchor',
                 'searchreplace visualblocks code fullscreen',
                 'insertdatetime media table paste code help wordcount'
             ],
             toolbar: 'undo redo | formatselect | ' +
                 'bold italic backcolor | alignleft aligncenter ' +
                 'alignright alignjustify | bullist numlist outdent indent | ' +
                 'removeformat | help',
             content_css: '//www.tiny.cloud/css/codepen.min.css'
         });
     </script>
@endsection
