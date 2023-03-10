<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($customer))
            {!! Form::model($customer, ['url' => $type . '/' . $customer->id, 'method' => 'put', 'files'=> true,'id'=>'customer']) !!}
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true,'id'=>'customer']) !!}
        @endif
            <div class="row">
            <div class="col-md-12" style="display:none;">
                <div class="form-group {{ $errors->has('user_avatar_file') ? 'has-error' : '' }}">
                    {!! Form::label('user_avatar_file', trans('customera.customer_avatar'), ['class' => 'control-label hide']) !!}
                    <div class="controls row" v-image-preview>
                        <div class="col-sm-12">
                            <div class="fileinput fileinput-new hide" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail form_Blade" data-trigger="fileinput">
                                    <img id="image-preview" width="300">
                                    @if(isset($customer->user->user_avatar) && $customer->user->user_avatar!="")
                                        <img src="{{ url('uploads/avatar/thumb_'.$customer->user->user_avatar) }}"
                                             alt="Image" class="ima-responsive">
                                    @endif
                                </div>
                                <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">{{trans('dashboard.select_image')}}</span>
                                        <span class="fileinput-exists">{{trans('dashboard.change')}}</span>
                                        <input type="file" name="user_avatar_file">
                                    </span>
                                    <a href="#" class="btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">{{trans('dashboard.remove')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <span class="help-block">{{ $errors->first('user_avatar_file', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
                      {!! Form::label('company', trans('customer.company'), ['class' => 'control-label required']) !!}
                      <div class="controls">
                          {!! Form::select('company_id', $companies, (isset($user))?$user->customer->company_id:null, ['id'=>'company_id', 'class' => 'form-control select2']) !!}  <a href="#" onclick="createcompany();">{{ trans('company.create_company') }}</a>
                          <span class="help-block">{{ $errors->first('company_id', ':message') }}</span>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group {{ $errors->has('branch_id') ? 'has-error' : '' }}">
                      {!! Form::label('company', trans('customer.sitelocation'), ['class' => 'control-label required']) !!}
                      <div class="controls">
                          {!! Form::select('branch_id', $branches, null, ['id'=>'branch_id', 'class' => 'form-control select2']) !!}
                          <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                          <div id="ismaincontact">
                              <input type="checkbox" name="ismain" id="ismain" value="ismain">
                              <span id="sp">{{ trans('customer.ismaincontact') }}</span>
                              <a href="#" onclick="if(document.getElementById('company_id').value != '') { document.location.href='{{url('customer/')}}/'+document.getElementById('company_id').value+'/createsite';} else { alert('Please select customer.'); return false; }">{{ trans('customer.createsite') }}</a>
                          </div>
                      </div>
                  </div>
              </div>

                <div class="col-md-2">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', trans('customer.title'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('title', $titles, (isset($user))?$user->customer->title:null, ['id'=>'title', 'class' => 'form-control select2']) !!}
                            <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        {!! Form::label('first_name', trans('customer.first_name'), ['class' => 'control-label required']) !!}
                        <div class="controls">

                            {!! Form::text('first_name', isset($customer)?isset($customer->user)?$customer->user->first_name:null:null, ['class' => 'form-control','id' => 'first_name']) !!}
                            <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        {!! Form::label('last_name', trans('customer.last_name'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('last_name', isset($customer)?isset($customer->user)?$customer->user->last_name:null:null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('job_position') ? 'has-error' : '' }}">
                        {!! Form::label('job_position', trans('customer.job_position'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('job_position', (isset($user))?$user->customer->job_position:null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('job_position', ':message') }}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', trans('customer.email'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            <input type="hidden" name="sales_team_id" id="sales_team_id" value="1">
                            {!! Form::email('email', isset($customer)?isset($customer->user)?$customer->user->email:null:null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                        {!! Form::label('phone_number', trans('customer.phone'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('phone_number', isset($customer)?isset($customer->user)?$customer->user->phone_number:null:null, ['class' => 'form-control ','data-fv-integer' => 'true','id' => 'phone_number']) !!}
                            <span class="help-block">{{ $errors->first('phone_number', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        {!! Form::label('mobile', trans('customer.mobile'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('mobile', (isset($user))?$user->customer->mobile:null, ['class' => 'form-control','data-fv-integer' => 'true']) !!}
                            <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @if(!Request::is('customer/*/edit'))
                <div class="row" style="display:none">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            {!! Form::label('password', trans('customer.password'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            {!! Form::label('password_confirmation', trans('customer.password_confirmation'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
                                <small class="text-danger" id='message'>Password is not matching.</small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="row password_fields"  style="display:none">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            {!! Form::label('password', trans('customer.password'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            {!! Form::label('password_confirmation', trans('customer.password_confirmation'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
                                <small class="text-danger" id='message'>Password is not matching.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-b-10"  style="display:none">
                    <button class="btn btn-warning change_password">Change password</button>
                </div>
                @endif
            <div class="row" style="display:none;">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', trans('customer.address'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::textarea('address', (isset($user))?$user->customer->address:null, ['class' => 'form-control resize_vertical']) !!}
                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Actions -->
                    <div class="form-group">
                        <div class="controls">
                          @if($nextaction <> "")
                          <input type="hidden" name="editid" value="{{$editid}}">
                          <input type="hidden" name="editaction" value="{{$editaction}}">
                          <input type="hidden" name="idone" value="{{$idone}}">
                          <input type="hidden" name="idtwo" value="{{$idtwo}}">
                          <input type="hidden" name="nextaction" value="{{$nextaction}}">
                          @endif



                            <button type="submit" class="btn btn-success"><i
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






        $(document).ready(function(){
            $("#message").hide();
            $("#password, #password_confirmation").on("keyup", function () {
                if ($("#password").val() == $("#password_confirmation").val()) {
                    $("#message").hide();
                } else{
                    $("#message").show();
                    $('#customer').data('bootstrapValidator').validate();
                }
            });
            $(".change_password").on("click",function(){
                $(".password_fields").show();
                $(this).hide();
                $('#customer').data('bootstrapValidator').validate();
            });
            $(".password_fields").hide();





            $("#company_id").change(function(){
                ajaxBranchList($(this).val());
                if($('#branch_id').val() != '')
                ajaxBranchMainContact($('#branch_id').val());
            });


            @if(old('company_id'))
            ajaxBranchList({{old('company_id')}});
            if($('#branch_id').val() != '')
            ajaxBranchMainContact($('#branch_id').val());
            @endif

            function ajaxBranchList(id){
                $.ajax({
                    type: "GET",
                    url: '{{ url('company/ajax_branch_list')}}',
                    data: {'id': id, _token: '{{ csrf_token() }}' },
                    success: function (data) {
                        $("#branch_id").empty();
                        $("#branch_id").prop('disabled', true);
                        $('#branch_id').append($('<option></option>').val('').html('Select '));
                        $.each(data.branch_name, function (val, text) {
                            $('#branch_id').append($('<option></option>').val(val).html(text));
                        });
                        $("#branch_id").prop('disabled', false);
                        @if(isset($customer))
                        //ajaxBranchList({{$customer->company_id}});
                        $('#branch_id').val({{$customer->address}});
                        ajaxBranchMainContact({{$customer->address}});
                        @endif
                        $('#customer').bootstrapValidator('revalidateField', 'branch_id');
                    }
                });
            }

            $("#branch_id").change(function(){
                var myv = $(this).val();
                console.log(myv);
                if(myv != '' && myv != null)
                ajaxBranchMainContact(myv);
            });

            function ajaxBranchMainContact(id){
                $.ajax({
                    type: "GET",
                    url: '{{ url('customer/ajax_branch_havemain')}}',
                    data: {'id': id, _token: '{{ csrf_token() }}' },
                    success: function (data) {
                      if(data.have_main == "yes")
                      {
                        $("#ismain").prop('checked', false);
                        $("#ismain").hide();
                        $("#sp").hide();
                        //$("#ismaincontact").show();
                      } else {
                        $("#sp").show();
                        $("#ismain").show();
                        $("#ismain").prop('checked', true);
                        //$("#ismaincontact").show();
                      }
                      @if (!isset($customer))
                      $("#phone_number").val(data.mobile);
                      $("#first_name").val(data.cname);
                      $('#customer').bootstrapValidator('revalidateField', 'phone_number');
                      $('#customer').bootstrapValidator('revalidateField', 'first_name');
                      @else
                        console.log('dsfgdf');
                        console.log(data.addressid);
                        if((data.addressid == {{$customer->address}}) && {{$customer->is_main_contact}}) {
                          $("#sp").show();
                          $("#ismain").show();
                          $("#ismain").prop('checked', true);
                        }

                      @endif


                    }
                });
            }


            @if(isset($customer))
            ajaxBranchList({{$customer->company_id}});
            //$('#branch_id').val({{$customer->address}});
            //ajaxBranchMainContact({{$customer->address}});
            @endif

            @if(isset($ofcompanyid))
            $("#company_id").val({{$ofcompanyid}});
            ajaxBranchList({{$ofcompanyid}});
            //$('#branch_id').prop('selectedIndex', 1);
            if($('#branch_id').val() != '')
            ajaxBranchMainContact($('#branch_id').val());
            @endif


            @if (isset($customer))
            @if ($customer->is_main_contact == 1)
  //$("#sp").show();
  //$("#ismain").show();
  //$("#ismain").prop('checked', true);
  @endif
  @endif
            $("#customer").bootstrapValidator({
                fields: {
                    user_avatar_file: {
                        validators: {
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 1000000,
                                message: 'The logo format must be in jpeg, jpg or png and size less than 1MB'
                            }
                        }
                    },
                    title: {
                        validators: {
                            notEmpty: {
                                message: 'The title field is required.'
                            }
                        }
                    },
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: 'The first name field is required.'
                            }
                        }
                    },

                    company_id: {
                        validators: {
                            notEmpty: {
                                message: 'The company name field is required.'
                            }
                        }
                    },

                    branch_id: {
                        validators: {
                            notEmpty: {
                                message: 'The Site location of customer is required.'
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
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password field is required.'
                            },
                            stringLength: {
                                min: 3,
                                message: 'The password must be minimum 3 characters.'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation field is required.'
                            }
                        }
                    },
                    phone_number: {
                        validators: {
                            notEmpty: {
                                message: 'The phone number is required.'
                            },
                            regexp: {
                                regexp: /^\d{5,15}?$/,
                                message: 'The phone number can only consist of numbers.'
                            }
                        }
                    }
                }
            });
            $("#title").select2({
                theme:"bootstrap",
                placeholder:"{{ trans('customer.title') }}"
            });
            $("#company_id").select2({
                theme:"bootstrap",
                placeholder:"{{ trans('customer.company') }}"
            });
            @if(!empty($customer->address))
            $("#branch_id").val('{{$customer->address}}').change();
            @endif
        })
    </script>


    <script>

    function createcompany() {
        urlstr = '{{url('customer/')}}/';
        if(document.getElementById('company_id').value != '') {
          urlstr = urlstr+document.getElementById('company_id').value+'/';
        } else {
          urlstr = urlstr+'0/';
        }
        if(document.getElementById('branch_id').value != '') {
          urlstr = urlstr+document.getElementById('branch_id').value+'/';
        } else {
          urlstr = urlstr+'0/';
        }
        urlstr = urlstr+'createcompany';
      document.location.href=urlstr;

    }


    </script>
    @endsection
