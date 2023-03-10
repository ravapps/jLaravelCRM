<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($lead))
            {!! Form::model($lead, ['url' => $type . '/' . $lead->id, 'method' => 'put', 'id'=>'lead', 'files'=> true, 'enctype' => 'multipart/form-data']) !!}
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true,'id'=>'lead', 'enctype' => 'multipart/form-data']) !!}
        @endif

        <div class="row">
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
                  {!! Form::label('company', trans('lead.company_name'), ['class' => 'control-label required']) !!}
                  <div class="controls">
                      {!! Form::select('company_id', $companies, null, ['id'=>'company_id', 'class' => 'form-control select2']) !!}  <a href="{{url('lead/createcompany')}}">{{ trans('company.create_company') }}</a>
                      <span class="help-block">{{ $errors->first('company_id', ':message') }}</span>
                  </div>
              </div>
            </div>
              <div class="col-md-6">
                  <div class="form-group {{ $errors->has('client_name') ? 'has-error' : '' }}">
                      {!! Form::label('client_name', trans('lead.agent_name'), ['class' => 'control-label required']) !!}
                      <div class="controls">
                          {!! Form::select('customer_id', $customers, null, ['id'=>'customer_id', 'class' => 'form-control select2']) !!}  <a href="#"  onclick="if(document.getElementById('company_id').value != '') { document.location.href='{{url('lead/')}}/'+document.getElementById('company_id').value+'/createcustomer';} else { alert('Please select customer.'); return false; }">{{ trans('customer.create_agent') }}</a>
                          <!-- {!! Form::text('client_name', null, ['class' => 'form-control', 'placeholder'=>'Agent Name']) !!} -->
                          <span class="help-block">{{ $errors->first('client_name', ':message') }}</span>
                      </div>
                  </div>
              </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('function') ? 'has-error' : '' }}">
                    {!! Form::label('function', trans('lead.function'), ['class' => 'control-label required', 'placeholder' => 'Please select']) !!}
                    <div class="controls">
                        {!! Form::select('function', $functions, null, ['id'=>'function', 'class' => 'form-control select_function']) !!}
                        <span class="help-block">{{ $errors->first('function', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('product_name') ? 'has-error' : '' }}">
                    {!! Form::label('product_name', trans('lead.product_name'), ['class' => 'control-label required' ]) !!}
                    <div class="controls">
                        {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder'=>'Product Name']) !!}
                        <span class="help-block">{{ $errors->first('product_name', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="display:none;">
                <div class="form-group {{ $errors->has('company_site') ? 'has-error' : '' }}">
                    {!! Form::label('company_site', trans('lead.company_site'), ['class' => 'control-label required' ]) !!}
                    <div class="controls">
                        {!! Form::text('company_site', null, ['class' => 'form-control', 'placeholder'=>'Company Web Site']) !!}
                        <span class="help-block">{{ $errors->first('company_site', ':message') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                {!! Form::label('additionl_info', trans('lead.additionl_info'), ['class' => 'control-label']) !!}
                <div class="form-group {{ $errors->has('additionl_info') ? 'has-error' : '' }}">
                    <div class="controls">
                        {!! Form::textarea('additionl_info', null, ['class' => 'form-control resize_vertical']) !!}
                        <span class="help-block">{{ $errors->first('additionl_info', ':message') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr/>
            </div>
            <div class="col-md-12">
                <h4>Personal Info:</h4>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-5">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {!! Form::label('title', trans('lead.title'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('title', $titles, null, ['id'=>'title', 'class' => 'form-control title_select select2']) !!}
                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                    </div>
                </div>
            </div>

        </div> --->
        <!-- <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                    {!! Form::label('country_id', trans('lead.country'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('country_id', $countries, null, ['id'=>'country_id', 'class' => 'form-control']) !!}
                        <span class="help-block">{{ $errors->first('country_id', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    {!! Form::label('state_id', trans('lead.state'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('state_id', isset($lead)?$states:[0=>trans('lead.select_state')], null, ['id'=>'state_id', 'class' => 'form-control']) !!}
                        <span class="help-block">{{ $errors->first('state_id', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                    {!! Form::label('city_id', trans('lead.city'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('city_id', isset($lead)?$cities:[0=>trans('lead.select_city')], null, ['id'=>'city_id', 'class' => 'form-control']) !!}
                        <span class="help-block">{{ $errors->first('city_id', ':message') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::label('address', trans('lead.address'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {!! Form::textarea('address', null, ['class' => 'form-control resize_vertical']) !!}
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>
            </div>
        </div> --->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    {!! Form::label('phone', trans('lead.phone'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::text('phone', null, ['id' => 'phone','class' => 'form-control','data-fv-integer' => "true",'placeholder'=>'Phone Number']) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                    {!! Form::label('mobile', trans('lead.mobile'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {!! Form::text('mobile', null, ['id' => 'mobile','class' => 'form-control','data-fv-integer' => 'true', 'placeholder'=>'Mobile number']) !!}
                        <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', trans('lead.email'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Email Address']) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                    {!! Form::label('priority', trans('lead.priority'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('priority', $priority, null, ['id'=>'priority','class' => 'form-control select2', 'placeholder'=>trans('lead.select_priority')]) !!}
                        <span class="help-block">{{ $errors->first('priority', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                    {!! Form::label('documents', 'Documents Attached', ['class' => 'control-label ']) !!}
                    <div class="controls">
                        <input type="file" name="document_upload[]" id="document_upload" multiple  class="form-control" >
                        <span class="help-block">Upload files only: jpg,png,pdf,docs,xls</span>
                        @if(isset($lead->documents))
                          @if($lead->documents)
                            @php $tmpArr = explode(',',$lead->documents); @endphp
                            @foreach($tmpArr as $key => $index)
                            @if($tmpArr[$key] != "")
                              <br><span id="def{{$loop->index}}"><a href="{{asset('public/uploads/document/')}}/{{$tmpArr[$key]}}" target="_blank" >{{$tmpArr[$key]}}</a> <a href="#" onclick="return delfile('def{{$loop->index}}','{{$tmpArr[$key]}}', 'lead' ,{{$lead->id}});" title="Delete">
                                            <i class="fa fa-fw fa-trash text-danger"></i> </a></span>
                            @endif
                            @endforeach
                          @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Form Actions -->
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success" form="lead"><i
                                    class="fa fa-check-square-o"></i> {{trans('table.ok')}}</button>
                        <a href="{{ route($type.'.index') }}" class="btn btn-warning"><i
                                    class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>

                    </div>
                </div>
                <!-- ./ form actions -->
            </div>
        </div>


        {!! Form::close() !!}
    </div>
</div>

@section('scripts')
    <script>

    function delfile(linid,flnm, appsegmnt ,sgmntid) {
      $.ajax({
          type: "GET",
          url: '{{ url('globalfiledel')}}',
          data: {'id': sgmntid, 'appsegmnt':appsegmnt, 'flnm':flnm, _token: '{{ csrf_token() }}' },
          success: function (data) {
              $('#'+linid).addClass('hide');
          }
      });
    }


        $(document).ready(function () {

          $("#customer_id").change(function(){
              ajaxCustomersDetails($(this).val());
          });





          function ajaxCustomersDetails(id){
            console.log(id);
            if(id)
              $.ajax({
                  type: "GET",
                  url: '{{ url('customer/ajax_customer_details')}}',
                  data: {'id': id, _token: '{{ csrf_token() }}' },
                  success: function (data) {
                      $('#phone').val(data.phone);
                      $('#mobile').val(data.mobile);
                      $('#email').val(data.email);
                      $('#lead').bootstrapValidator('revalidateField', 'customer_id');
                  }
              });
          }



                      $("#company_id").change(function(){
                          ajaxCustomersList($(this).val());
                      });
                      @if(old('company_id'))
                      ajaxCustomersList({{old('company_id')}});
                      $("#customer_id").val({{old('customer_id')}}).change();
                      @endif

                      function ajaxCustomersList(id){
                        console.log(id);
                          if(id)
                          $.ajax({
                              type: "GET",
                              url: '{{ url('customer/ajax_customer_list')}}',
                              data: {'id': id, _token: '{{ csrf_token() }}' },
                              success: function (data) {
                                $("#company_id").val(id);
                                  $("#customer_id").empty();
                                  $("#customer_id").prop('disabled', true);
                                  $.each(data.customer_name, function (val, text) {
                                      $('#customer_id').append($('<option></option>').val(val).html(text));
                                  });
                                  $("#customer_id").prop('disabled', false);
                                  @if (!isset($lead))
                                  ajaxCustomersDetails($("#customer_id").val());
                                  @endif
                                  @if (isset($lead))
                                   $("#customer_id option[value='{{$lead->customer_id}}']").prop('selected', true);
                                  @endif
                                  $('#lead').bootstrapValidator('revalidateField', 'customer_id');
                                  console.log('ajaxends');
                              }
                          });
                      }
            $("#lead").bootstrapValidator({
                fields: {
                    company_id: {
                        validators: {
                            notEmpty: {
                                message: 'The company name field is required.'
                            }
                        }
                    },
                    customer_id: {
                        validators: {
                            notEmpty: {
                                message: 'The customer name field is required.'
                            }
                        }
                    },
                    'document_upload[]': {
                        validators: {
                            file: {
                                extension: 'jpg,png,pdf,docs,xls',
                                message: 'You must select a valid  file to upload'
                            }
                        }
                    },
                    product_name: {
                        validators: {
                            notEmpty: {
                                message: 'The product name field is required.'
                            }
                        }
                    },
                    company_site: {
                        validators: {
                            notEmpty: {
                                message: 'The company web site field is required.'
                            },
                            uri: {
                                allowLocal: true,
                                message: 'The input is not a valid URL'
                            }
                        }
                    },

                    country_id: {
                        validators: {
                            notEmpty: {
                                message: 'The country field is required.'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'The phone number is required.'
                            },
                            regexp: {
                                regexp: /^\d{5,15}?$/,
                                message: 'The phone number can only consist of numbers.'
                            }
                        }
                    },
                    mobile: {
                        validators: {
                            regexp: {
                                regexp: /^\d{5,15}?$/,
                                message: 'The mobile number can only consist of numbers.'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'The email field is required.'
                            }
                        }
                    },
                    function: {
                        validators: {
                            notEmpty: {
                                message: 'The lead type field is required.'
                            }
                        }
                    },
                    priority: {
                        validators: {
                            notEmpty: {
                                message: 'The priority field is required.'
                            }
                        }
                    }

                }
            });

            @if (isset($lead))
            ajaxCustomersList({{$lead->company_id}});
             $("#customer_id option[value='{{$lead->customer_id}}']").prop('selected', true);
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

        });





        function getstates(country) {
            $.ajax({
                type: "GET",
                url: '{{ url('lead/ajax_state_list')}}',
                data: {'id': country, _token: '{{ csrf_token() }}'},
                success: function (data) {
                    $('#state_id').empty();
                    $('#city_id').empty();
                    $('#state_id').select2({
                        theme: "bootstrap",
                        placeholder: "Select State"
                    }).trigger('change');
                    $('#city_id').select2({
                        theme: "bootstrap",
                        placeholder: "Select City"
                    }).trigger('change');
                    $.each(data, function (val, text) {
                        $('#state_id').append($('<option></option>').val(val).html(text).attr('selected', val == "{{old('state_id')}}" ? true : false));
                    });
                }
            });
        }


        function getcities(cities) {
            $.ajax({
                type: "GET",
                url: '{{ url('lead/ajax_city_list')}}',
                data: {'id': cities, _token: '{{ csrf_token() }}'},
                success: function (data) {
                    $('#city_id').empty();
                    $('#city_id').select2({
                        theme: "bootstrap",
                        placeholder: "Select City"
                    }).trigger('change');
                    $.each(data, function (val, text) {
                        $('#city_id').append($('<option></option>').val(val).html(text).attr('selected', val == "{{old('city_id')}}" ? true : false));
                    });
                }
            });
        }
    </script>

@endsection
