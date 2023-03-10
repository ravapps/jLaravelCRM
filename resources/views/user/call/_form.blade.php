@section('styles')
    {{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">--}}
    @stop
<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($call))
            {!! Form::model($call, ['url' => $type . '/' . $call->id, 'id'=>'call', 'method' => 'put', 'files'=> true]) !!}
        @else
            {!! Form::open(['url' => $type, 'id'=>'call', 'method' => 'post', 'files'=> true]) !!}
        @endif
        <div class="row">
            <div class="col-md-6">

                    <div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
                        {!! Form::label('company_id', trans('call.company'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('company_id', $companies, null, ['id'=>'company_id', 'class' => 'form-control select2']) !!}   <a href="{{url('call/createcompany')}}">{{ trans('company.create_company') }}</a>
                            <span class="help-block">{{ $errors->first('company_id', ':message') }}</span>
                        </div>
                    </div>
                              </div>
  <div class="col-md-6">
                        <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                            {!! Form::label('customer_id', trans('customer.agent'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::select('customer_id', $customers, null, ['id'=>'customer_id', 'class' => 'form-control select2']) !!}  <a href="#"  onclick="if(document.getElementById('company_id').value != '') { document.location.href='{{url('call/')}}/'+document.getElementById('company_id').value+'/createcustomer';} else { alert('Please select customer.'); return false; }">{{ trans('customer.create_agent') }}</a>
                                <span class="help-block">{{ $errors->first('customer_id', ':message') }}</span>
                            </div>
                        </div>

          </div>
          <div class="col-md-6">
                                <div class="form-group {{ $errors->has('lead_id') ? 'has-error' : '' }}">
                                    {!! Form::label('lbllead_id', trans('lead.leadincall'), ['class' => 'control-label required']) !!}
                                    <div class="controls">
                                        {!! Form::select('lead_id', $leads, null, ['id'=>'lead_id', 'class' => 'form-control select2']) !!}
                                        <span class="help-block">{{ $errors->first('lead_id', ':message') }}</span>
                                    </div>
                                </div>

                  </div>
           <div class="col-md-6">
               <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                   {!! Form::label('date', trans('call.date'), ['class' => 'control-label required']) !!}
                   <div class="controls">
                        @php $mydt = date(config('settings.date_format'));   @endphp
                       {!! Form::text('date', isset($call) ? $call->call_date : $mydt, ['class' => 'form-control date']) !!}
                       <span class="help-block">{{ $errors->first('date', ':message') }}</span>
                   </div>
               </div>
           </div>
           <div class="col-md-6 hide" style="display:none;">
               <div class="form-group {{ $errors->has('duration') ? 'has-error' : '' }}">
                   {!! Form::label('duration', trans('call.duration'), ['class' => 'control-label']) !!}
                   <div class="controls">
                       {!! Form::input('number','duration',10, ['class' => 'form-control', 'min'=>'1']) !!}
                       <span class="help-block">{{ $errors->first('duration', ':message') }}</span>
                   </div>
               </div>
           </div>
       </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('call_summary') ? 'has-error' : '' }}">
                    {!! Form::label('call_summary', trans('call.summary'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                      {!! Form::textarea('call_summary', null, ['class' => 'form-control resize_vertical']) !!}

                        <span class="help-block">{{ $errors->first('call_summary', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="display:none;">
                <div class="form-group {{ $errors->has('resp_staff_id') ? 'has-error' : '' }}">
                    {!! Form::label('resp_staff_id', trans('salesteam.main_staff'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('resp_staff_id', $staffs, null, ['id'=>'resp_staff_id', 'class' => 'form-control select2']) !!}
                        <span class="help-block">{{ $errors->first('resp_staff_id', ':message') }}</span>
                    </div>
                </div>
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
      var cid = 0;
        $(document).ready(function(){




          $("#company_id").change(function(){
              ajaxCustomersList($(this).val());
              ajaxLeadList($("#customer_id").val(),$("#company_id").val());
          });
          @if(old('company_id'))
          ajaxCustomersList({{old('company_id')}});
          $("#customer_id").val({{old('customer_id')}});
          @endif

          function ajaxCustomersList(id){

              $.ajax({
                  type: "GET",
                  url: '{{ url('customer/ajax_customer_list')}}',
                  data: {'id': id, _token: '{{ csrf_token() }}' },
                  success: function (data) {
                      $("#customer_id").empty();
                      $("#lead_id").empty();
                      $("#customer_id").prop('disabled', true);
                      $('#customer_id').append($('<option></option>').val('0').html('Select'));
                      $.each(data.customer_name, function (val, text) {
                          $('#customer_id').append($('<option></option>').val(val).html(text));
                      });
                      $("#customer_id").prop('disabled', false);

                      @if (isset($call))
                       $("#customer_id option[value='{{$call->customer_id}}']").prop('selected', true);
                       ajaxLeadList($("#customer_id").val(),$("#company_id").val());

                      @endif
                      $('#call').bootstrapValidator('revalidateField', 'customer_id');
                  }
              });
          }


          $("#customer_id").change(function(){
              ajaxLeadList($(this).val(),$("#company_id").val());
          });
          @if(old('customer_id'))
          ajaxLeadList({{old('customer_id')}},{{old('company_id')}});
          $("#lead_id").val({{old('lead_id')}});
          @endif








          function ajaxLeadList(id,cmpid){
            console.log('id'+id);
            console.log('cmpid' + cmpid);
            console.log('cid' + cid);
            if(cid == id) {
                return;
            }
            cid = id;
              $.ajax({
                  type: "GET",
                  url: '{{ url('lead/ajax_lead_list')}}',
                  data: {'id': cmpid, 'cuid':id, _token: '{{ csrf_token() }}' },
                  success: function (data) {
                    console.log('here');
                      $("#lead_id").empty();
                    //  $("#lead_id").prop('disabled', true);
                      $.each(data.lead_name, function (val, text) {
                          $('#lead_id').append($('<option></option>').val(val).html(text));
                      });
                    //  $("#lead_id").prop('disabled', false);

                      @if (isset($call))
                       $("#lead_id option[value='{{$call->lead_id}}']").prop('selected', true);
                      @endif
                      $('#call').bootstrapValidator('revalidateField', 'lead_id');
                  }
              });
          }



            $("#company_name").select2({
                theme:"bootstrap",
                placeholder:"{{ trans('call.company') }}"
            });
            $("#resp_staff_id").select2({
                theme:"bootstrap",
                placeholder:"{{ trans('salesteam.main_staff') }}"
            });
            $("#call").bootstrapValidator({
                fields: {
                    company_id: {
                        validators: {
                            notEmpty: {
                                message: 'The company field is required.'
                            }
                        }
                    },
                    lead_id: {
                        validators: {
                            notEmpty: {
                                message: 'The lead field is required.'
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
                                message: 'The date field is required.'
                            }
                        }
                    },

                    call_summary: {
                        validators: {
                            notEmpty: {
                                message: 'The call summary field is required.'
                            }
                        }
                    }

                }
            });
            $("#date").on("dp.change",function(){
                $('#call').bootstrapValidator('revalidateField', 'date');
            });
            var dateFormat = '{{ config('settings.date_format') }}';
            flatpickr("#date", {
                maxDate: '{{ isset($call) ? $call->created_at : now() }}',
                dateFormat: dateFormat,
                disableMobile: "true",
            });


            @if (isset($call))
            ajaxCustomersList({{$call->company_id}});
             $("#customer_id option[value='{{$call->customer_id}}']").prop('selected', true);
            @endif


            @if(isset($ofcompanyid))
            $('#company_id').val({{$ofcompanyid}}).change();
            document.getElementById('company_id').value = {{$ofcompanyid}};

            //ajaxCustomersList({{$ofcompanyid}});

            @if(isset($ofcustomerid))
            $(document).ajaxStop(function () {
              console.log('ajaxdone');

$("#customer_id").val({{$ofcustomerid}}).change();
});
@endif

@endif
        });
    </script>
    @endsection
