<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($deliveryorder))
            {!! Form::model($deliveryorder, ['url' => $type . '/' . $deliveryorder->id, 'method' => 'put', 'files'=> true, 'id'=>'deliveryorder']) !!}
            <div id="sendby_ajax"></div>
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'deliveryorder']) !!}
        @endif
        <div class="row">
          <div class="col-xs-12 col-sm-6">
              <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                  {!! Form::label('company_id', trans('company.company_name'), ['class' => 'control-label ']) !!}
                  <br>{{$saleorder->company->name}} <br> {{$saleorder->company->address}} <br> {{$saleorder->company->website}} <br> {{$saleorder->company->phone}} {{$saleorder->company->mobile}}

                  <br>{!! Form::label('company_id', trans('delivery.sitelocation'), ['class' => 'control-label ']) !!}
                <br>

  <?php echo \App\Models\Customer::find($saleorder->customer->id)->contactSitelocation->sitelocation ?>
  <?php echo \App\Models\Customer::find($saleorder->customer->id)->contactSitelocation->postalcode ?>
<br>   <?php echo \App\Models\Customer::find($saleorder->customer->id)->contactSitelocation->street ?>
  <?php echo \App\Models\Customer::find($saleorder->customer->id)->contactSitelocation->building ?>
<br>  <?php echo \App\Models\Customer::find($saleorder->customer->id)->contactSitelocation->unitfrom ?>
  <?php echo " - ".\App\Models\Customer::find($saleorder->customer->id)->contactSitelocation->unitto ?>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6">
              <div class="form-group required {{ $errors->has('date') ? 'has-error' : '' }}">
                  {!! Form::label('date', trans('delivery.date'), ['class' => 'control-label required']) !!}
                  <div class="controls">
                      {{$deliveryorder->delivery_date}}
                      <span class="help-block">{{ $errors->first('delivery_date', ':message') }}</span>
                  </div>
                  {!! Form::label('company_id', trans('delivery.customer'), ['class' => 'control-label ']) !!}

                  <br>{{$saleorder->customer->first_name}}
                  {{$saleorder->customer->last_name}}
                  <br>{{$saleorder->customer->phone_number}}
                  <br>{{$saleorder->customer->email}}

              </div>
          </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <div class="form-group required {{ $errors->has('qtemplate_id') ? 'has-error' : '' }}">
                    {!! Form::label('qtemplate_id', trans('delivery.saledetails'), ['class' => 'control-label']) !!} {{$saleorder->sale_number}}
                    <div class="controls">
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="control-label required">{{trans('quotation.products')}}
                    <span>{!! $errors->first('products') !!}</span></label>
                <div class="{{ $errors->has('product_id.*') ? 'has-error' : '' }}">
                    <span class="help-block">{{ $errors->first('product_id.*', ':message') }}</span>
                </div>
                <div class="{{ $errors->has('product_id') ? 'has-error' : '' }}">
                    <span class="help-block">{{ $errors->first('product_id', ':message') }}</span>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="detailes-tr">
                        <th>{{trans('quotation.product')}}</th>
                        <th>{{trans('quotation.description')}}</th>
                        <th>{{trans('quotation.quantity')}}</th>
                        <th>{{trans('quotation.unit_price')}}</th>

                    </tr>
                    </thead>
                    <tbody id="InputsWrapper">

                    @if(isset($saleorder)&& $saleorder->salesOrderProductsList->count()>0)
                        @foreach($saleorder->salesOrderProductsList as $index)
                            <tr class="remove_tr">
                                <td>


                                        {{$index->OrderProductsDetails->product_name}}


                                  </td>
                                <td>    {{$index->OrderProductsDetails->description}}                           </td>
                                <td>{{$index->quantity}}</td>
                                <td>{{$index->price}}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

                <div class="row">&nbsp;</div>
            </div>
        </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('total') ? 'has-error' : '' }}">
                        {!! Form::label('total', trans('quotation.total'), ['class' => 'control-label']) !!} :   @money($saleorder->total)
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('discount') ? 'has-error' : '' }}">
                        {!! Form::label('discount', trans('quotation.discount').' (%)', ['class' => 'control-label']) !!}
                        :  @money($saleorder->discount) @if($saleorder->discount_is_fixed == 1) (fixed) @else % @endif


                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('grand_total') ? 'has-error' : '' }}">
                        {!! Form::label('grand_total', trans('quotation.grand_total'), ['class' => 'control-label']) !!}
                        :  @money($saleorder->grand_total)
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('tax_amount') ? 'has-error' : '' }}">
                        {!! Form::label('tax_amount', trans('quotation.tax_amount').' ('.floatval(Settings::get('sales_tax')).'%)', ['class' => 'control-label']) !!}
                        :  @money($saleorder->tax_amount)
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group required {{ $errors->has('final_price') ? 'has-error' : '' }}">
                        {!! Form::label('final_price', trans('quotation.final_price'), ['class' => 'control-label']) !!}
  : @money($saleorder->final_price)
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('total') ? 'has-error' : '' }}">
                        {!! Form::label('approved_by', trans('delivery.approved_by'), ['class' => 'control-label']) !!}
                        {{$deliveryorder->approved_by}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('total') ? 'has-error' : '' }}">
                        {!! Form::label('delivered_by', trans('delivery.delivered_by'), ['class' => 'control-label']) !!}
                        {{$deliveryorder->delivered_by}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group required {{ $errors->has('total') ? 'has-error' : '' }}">
                        {!! Form::label('received_by', trans('delivery.received_by'), ['class' => 'control-label']) !!}
                        {{$deliveryorder->received_by}}
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group required {{ $errors->has('terms_and_conditions') ? 'has-error' : '' }}">
                        {!! Form::label('quotation_duration', trans('qtemplate.terms_and_conditions'), ['class' => 'control-label']) !!}
                        <br>{{$saleorder->terms_and_conditions}}
                    </div>
                </div>
            </div>
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
              <input type="hidden" name="salejob_id" value="{{$saleorder->id}}">

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
        $(document).ready(function() {



            $("#deliveryorder").bootstrapValidator({
                fields: {

                    delivery_date: {
                        validators: {
                            notEmpty: {
                                message: 'The delivery date field is required.'
                            }
                        }
                    }

                }
            });
        });





        function create_pdf(saleorder_id) {
            $.ajax({
                type: "GET",
                url: "{{url('sales_order' )}}/" + saleorder_id + "/ajax_create_pdf",
                data: {'_token': '{{csrf_token()}}'},
                success: function (msg) {
                    if (msg != '') {
                        $("#pdf_url").attr("href", msg);
                        var index = msg.lastIndexOf("/") + 1;
                        var filename = msg.substr(index);
                        $("#pdf_url").html(filename);
                        $("#saleorder_pdf").val(filename);
                    }
                }
            });
        }




        var dateFormat = '{{ config('settings.date_format') }}';
        flatpickr('#delivery_date',{
            minDate: '{{ isset($saleorder) ? $saleorder->created_at : now() }}',
            dateFormat: dateFormat,
            disableMobile: "true"

        });



    </script>
@endsection
