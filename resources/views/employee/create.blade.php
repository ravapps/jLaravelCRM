@extends('layouts.dashboard')
@section('page-title')
    {{__('Employee')}}
@endsection
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="page-title-box-hori">
            <h4 class="page-title">{{__('Create Employee')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="{{__('home')}}">{{__('Dashboard')}}</a></li>
                  <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
                  <li class="breadcrumb-item active">{{__('Create')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<form method="post" action="{{route('employee.store')}}" enctype="multipart/form-data" name="myEForm" id="myEForm">
    @csrf
    <div class="row">
        <div class="col-md-12 ">
            <div class="card ">
                <div class="card-header bg-success">
                  <h4 class="text-white">{{__('Basic Information')}}</h4>
                </div>
                <div class="card-body ">
                  <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                           <label>First Name</label><span class="text-danger pl-1">*</span>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control txtOnly" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Last Name</label><span class="text-danger pl-1">*</span>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control txtOnly" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                           <label>Username</label><span class="text-danger pl-1">*</span>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="" required>
                            <input type="hidden" name="user_type" value="employee">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tel</label>
                            <input type="text" name="tel" value="{{old('tel')}}" class="form-control numberOnly" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          {!! Form::label('phone', __('Mobile No.')) !!}<span class="text-danger pl-1">*</span>
                          {!! Form::text('phone', null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                         <label>Email</label><span class="text-danger pl-1">*</span>
                          <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                         <label>Date Of Birth</label><span class="text-danger pl-1">*</span>
                          <input type="text" name="dob" value="{{ old('email') }}" class="form-control datetime" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                           <label>Password</label><span class="text-danger pl-1">*</span>
                            <input type="password" name="password" value="" class="form-control" placeholder="" required>
                            <span style="font-size:10px;color:red;">Use 6 or more characters with a mix of letters, numbers & symbols (Ex. - Sample@1)</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Confirm Password</label><span class="text-danger pl-1">*</span>
                        <input type="password" name="confirm_password" value="" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="demo-upload-container">
                        <div class="custom-file-container" data-upload-id="myFirstImage">
                          <label>Upload Profile Picture</label>
                          <label class="custom-file-container__custom-file w-100" >
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <input type="file" class="form-control custom-file-container__custom-file__custom-file-input" id="profile_images" name="profile_images" accept="*">
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                          </label>
                          <span style="font-size:10px;color:red;">Upload only jpg,jpeg,png file</span>
                          <div class="custom-file-container__image-preview"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header bg-success">
                  <h4 class="text-white">{{__('Employment Information')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          {!! Form::label('employee_id', __('Employee ID')) !!}
                          {!! Form::text('employee_id', $employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}
                        </div>
                      </div>

                      <div class="col-md-3">
                          <div class="form-group">
                            {!! Form::label('company', __('Company')) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('company', null, ['class' => 'form-control txtOnly','required' => 'required']) !!}
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label>Company Date Of Joining</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="company_doj" id="company_doj" value="" class="form-control datetime" required>
                          </div>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Employee Type</label><span class="text-danger pl-1">*</span>
                          <select name="emp_type" required class="form-control" id="emp_type">
                              <option value="">Select Employee Type</option>
                              <option value="Singapore Citizen">Singapore Citizen</option>
                              <option value="Permanent Resident">Permanent Resident</option>
                              <option value="Malaysia">Malaysia</option>
                              <option value="Work Pass">Work Pass</option>
                              <option value="Foreign Worker Levy">Foreign Worker Levy</option>
                              <option value="Other">Other</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3" id="emp_type_text" style="display:none;">
                          <div class="form-group">
                             <label>If Other Employee Type</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="other_emp" value="" id="other_emp" class="form-control" >
                          </div>
                      </div>
                      <div class="col-md-3" id="emp_donation_type" style="display:none;">
                          <div class="form-group">
                             <label>CPF Donation Type<span class="text-danger pl-1">*</span></label>
                             <select name="donation_type" class="form-control" id="donation_type">
                             <option value=""> Select Donation Type</option>
                                  <option value="N/A"> N/A</option>
                                  <option value="CDAC"> CDAC</option>
                                  <option value="SINDA"> SINDA</option>
                                  <option value="ECF"> ECF</option>
                                  <option value="MBMF"> MBMF</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3" id="emp_type_year" style="display:none;">
                          <div class="form-group">
                             <label>Years From</label><span class="text-danger pl-1">*</span>
                             <select name="year_type"  class="form-control" id="year_type">
                                  <option value="">Select years</option>
                                  <option value="One Year">One Year</option>
                                  <option value="Two Year">Two Year</option>
                                  <option value="More Than 3 Years">More Than 3 Years</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3" id="emp_pass_type" style="display:none;">
                        <div class="form-group">
                           <label>Work Pass Type</label><span class="text-danger pl-1">*</span>
                            <select name="pass_type"  class="form-control">
                            <option value="">Select Type</option>
                            <option value="Work Permit">Work Permit</option>
                            <option value="S-Pass">S-Pass</option>
                            <option value="E-Pass">E-Pass</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <h3 class="section-heading">Department Information</h3>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              {{ Form::label('branch_id', __('Branch')) }}<span class="text-danger pl-1">*</span>
                              {{ Form::select('branch_id', $branches,null, array('class' => 'form-control  select2','required'=>'required')) }}
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                          {{ Form::label('department_id', __('Department')) }}<span class="text-danger pl-1">*</span>
                          {{ Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required')) }}
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            {{ Form::label('designation_id', __('Designation')) }}<span class="text-danger pl-1">*</span>
                            <select class="select2 form-control" id="designation_id" required="required" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                <option value="">{{__('Select any Designation')}}</option>
                            </select>
                          </div>
                      </div>
                      <div class="col-md-3 designation_worker hide">
                          <div class="form-group">
                            {{ Form::label('lworker_id', __('Worker Type')) }}
                            <select class="select2 form-control" id="worker_id" name="worker_id"  >
                              <option value="">{{__('Select Worker Type')}}</option>
                              <option value="cleaner">Cleaner </option>
                              <option value="floater">Floater</option>
                            </select>
                          </div>
                      </div>
                      <div class="col-md-3 worker_team hide">
                          <div class="form-group">
                            {{ Form::label('lteam_id', __('Team Name')) }} <span class="text-danger pl-1">*</span>

                            {{ Form::select('team_id[]', $teams_dropdown,null, array('class' => 'form-control  select2','id'=>'team_id','multiple'=>'multiple')) }}


                          </div>
                      </div>
                      <div class="col-md-3 client_location hide">
                          <div class="form-group">
                            {{ Form::label('client_location', __('Client Site')) }} <span class="text-danger pl-1">*</span>
                            <select class="select2 form-control" id="client_location[]" name="client_location[]" multiple="multiple">
                              <option value="0">{{__('Select Client Site')}}</option>
                            </select>
                          </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label>Reporting Designation<span class="text-danger pl-1">*</span></label>
                            <select class="select2 form-control" required="required" id="report_id" name="report_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                <option value="">Select Designation</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Job Responsiblities.<span class="text-danger pl-1">*</span></label>
                          <select name="responsibilties_id[]" required="required"  class="select2 form-control" id="responsibilties_id" multiple="multiple">
                            <option value="">Select Responsiblities</option>
                          </select>
                        </div>
                      </div>


                      <div class="col-md-3">
                          <div class="form-group">
                            {!! Form::label('uniform', __('Uniform')) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('uniform', null, ['class' => 'form-control txtOnly','required' => 'required']) !!}
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            {!! Form::label('uniform_size', __('Uniform Size')) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('uniform_size', null, ['class' => 'form-control','required' => 'required']) !!}
                          </div>
                      </div>

                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Probation Period<span class="text-danger pl-1">*</span></label>
                              <select name="probation_period" class="form-control" id="probation_period" required="">
                                  <option value="">Select</option>
                                  <option value="90">3 Months</option>
                                  <option value="180">6 Months</option>
                                  <option value="365">1 Year</option>
                                  <option value="730">2 Years</option>
                                  <option value="Other">Other</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3" id="emp_other_prob" style="display: none;">
                          <div class="form-group">
                             <label>If Other Probation<span class="text-danger pl-1">*</span></label>
                              <input type="text" name="other_prob" value="" id="other_prob" class="form-control">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Contract Period</label>
                              <select name="contract_period" class="form-control" id="contract_period">
                                  <option value="">Select</option>
                                  <option value="365">1 Years</option>
                                  <option value="730">2 Years</option>
                                  <option value="1095">3 Years</option>
                                  <option value="1460">4 Years</option>
                                  <option value="1825">5 Years</option>
                                  <option value="Other">Other</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3" id="emp_other_contract" style="display: none;">
                          <div class="form-group">
                             <label>If Other Contract Period<span class="text-danger pl-1">*</span></label>
                              <input type="text" name="other_contract1" value="" id="other_contrat1" class="form-control">
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Notice Period<span class="text-danger pl-1">*</span></label>
                              <select name="notice_period" class="form-control" id="notice_period" required="">
                                  <option value="">Select</option>
                                  <option value="7">7 days</option>
                                  <option value="14">14 days</option>
                                  <option value="30">30 days</option>
                                  <option value="60">60 days</option>
                                  <option value="90">90 days</option>
                                  <option value="Other">Other</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-3" id="emp_other_notice" style="display: none;">
                          <div class="form-group">
                             <label>If Other Notice Period<span class="text-danger pl-1">*</span></label>
                              <input type="text" name="other_notice" value="" id="other_notice" class="form-control">
                          </div>
                      </div>

                      <div class="col-md-12">
                        <h3 class="section-heading">Employee Address</h3>
                      </div>
                      <div class="col-sm-12">
                        <div class="row foreign_worker hide">
                          <div class="col-sm-12">
                            <h5 class="mt-0">(Current Address) <span class="text-danger pl-1">*</span></h5>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Postal Code</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control"  name="ca_postalcode" value="" id="ca_postalcode" >
                                    <span class="input-group-text">
                                      <i class="fa fa-search"></i>
                                    </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Street Name</label>
                                  <input type="text" class="form-control"  name="ca_street" value="" id="ca_street">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Building Name</label>
                                  <input type="text" class="form-control"   name="ca_build" value="" id="ca_build">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Unit No.</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control"   name="ca_unitfrm" value="" id="ca_unitfrm">
                                    <span class="input-group-text">
                                      <i class="fas fa-minus"></i>
                                    </span>
                                    <input type="text" class="form-control"    name="ca_unitto" value="" id="ca_unitto">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <h5 class="mt-0">(Permanent Address) <span class="text-danger pl-1">*</span></h5>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Postal Code</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control" required   name="pa_postalcode" value="" id="pa_postalcode">
                                    <span class="input-group-text">
                                      <i class="fa fa-search"></i>
                                    </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Street Name</label>
                                  <input type="text" class="form-control"  required  name="pa_street" value="" id="pa_street">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Building Name</label>
                                  <input type="text" class="form-control" required   name="pa_build" value="" id="pa_build">
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="form-label" for="">Unit No.</label>
                                  <div class="input-group">
                                    <input type="text" class="form-control"  required  name="pa_unitfrm" value="" id="pa_unitfrm">
                                    <span class="input-group-text">
                                      <i class="fas fa-minus"></i>
                                    </span>
                                    <input type="text" class="form-control"    name="pa_unitto" id="pa_unitto">
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="card">
              <div class="card-header bg-success">
                <h4 class="text-white">{{__('Personal Information')}}</h4>
              </div>
              <div class="card-body employee-detail-create-body">
                  <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                           <label>NRIC No/FIN/Work Permit No<span class="text-danger pl-1">*</span></label>
                            <input type="text" name="identifications_no" value="" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label>Passport Number</label><span class="text-danger pl-1">*</span>
                            <input type="text" name="passport_no" value="{{old('passport_no')}}" class="form-control" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                            <label>Passport Expiry Date</label><span class="text-danger pl-1">*</span>
                            <input type="text" name="passport_expire" value="{{old('passport_expire')}}" class="form-control datetime" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Race<span class="text-danger pl-1">*</span></label>
                              <input type="text" name="race" value="{{old('race')}}" class="form-control " required>
                          </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                            <label>Nationality<span class="text-danger pl-1">*</span></label>
                            <select class="form-control" id="nationality" name="nationality" required>
                                <option value="">Select Nationality</option>
                                @if($nationalities)
                                    @foreach($nationalities as $nationality)
                                    <option value="{{$nationality->nationality}}">{{$nationality->nationality}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Religion</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="religion" value="{{old('religion')}}" class="form-control txtOnly" required>
                          </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label>Marital Status<span class="text-danger pl-1">*</span></label>
                            <select class="select2 form-control" id="marital_status" name="marital_status" required>
                                <option value="">Select status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-3" id="emp_marital" style="display:none;">
                          <div class="form-group">
                             <label>If Other Marital Status<span class="text-danger pl-1">*</span></label>
                              <input type="text" name="marital_status1" value="" id="marital_status1" class="form-control" >
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Employment Of Spouse</label>
                              <input type="text" name="spouse" value="{{old('spouse')}}" class="form-control txtOnly" >
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>No. Of Children</label>
                              <input type="text" name="no_of_child" value="{{old('no_of_child')}}" class="form-control numberOnly" >
                          </div>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr class="mt-1">
                        <div class="row mt-2">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                  <input type="checkbox" class="mr-1 get_skills" value="Own Bike" name="own_bike" id="own_bike">
                                  <label for="">Own Bike</label>
                                </div>
                                <div class="row" id="own_bike1" style="display:none;">
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                      <div class="form-group">
                                         <label>IU number<span class="text-danger pl-1"></span></label>
                                          <input type="text"  value="" id="IU_number" name="IU_number" class="form-control" >
                                      </div>
                                  </div>
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                      <div class="form-group">
                                          <label>Registration number<span class="text-danger pl-1"></span></label>
                                          <input type="text"  value="" id="Registration_number" name="Registration_number" class="form-control" >
                                      </div>
                                  </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                  <input type="checkbox" class="mr-1 get_skills" value="Own SG Car" name="own_sg_car" id="own_sg_car" >
                                  <label for="">Own SG Car</label>
                                </div>
                                <div class="row" id="own_car1" style="display:none;">
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                      <div class="form-group">
                                         <label>IU number<span class="text-danger pl-1"></span></label>
                                          <input type="text"  value="" id="IU_number_c" name="IU_number_c" class="form-control" >
                                      </div>
                                  </div>
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                      <div class="form-group">
                                          <label>Registration number<span class="text-danger pl-1"></span></label>
                                          <input type="text" value="" id="Registration_number_c" name="Registration_number_c" class="form-control" >
                                      </div>
                                  </div>
                                </div>
                            </div>

                        </div>
                      </div>

                  </div>
              </div>
           </div>
        </div>

        <div class="col-md-12 ">
            <div class="card">
              <div class="card-header bg-success"><h4 class="text-white">{{__('Emergency Contact')}}</h4></div>
              <div class="card-body employee-detail-create-body">
                <div class="row">
                  <div class="col-sm-12">
                    <h5 class="mt-0">(Primary Contact)</h5>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Name</label>  <span class="text-danger pl-1">*</span>
                        <input type="text" name="emr_name1" value="{{old('emr_name1')}}" class="form-control txtOnly" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Relationship</label>
                            <input type="text" name="emr_relation1" value="{{old('emr_relation1')}}" class="form-control txtOnly" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label>Phone</label>
                          <input type="text" name="emr_phone1" value="{{old('emr_phone1')}}" class="form-control numberOnly" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label>Phone2</label>
                          <input type="text" name="emr_phone12" value="{{old('emr_phone12')}}" class="form-control numberOnly" >
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <h5 class="">(Secondary Contact)</h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Name</label> <span class="text-danger pl-1">*</span>
                          <input type="text" name="emr_name2" value="{{old('emr_name2')}}" class="form-control txtOnly" required>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="emr_relation2" value="{{old('emr_relation2')}}" class="form-control txtOnly" >

                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="emr_phone2" value="{{old('emr_phone2')}}" class="form-control numberOnly" >
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <label>Phone2</label>
                        <input type="text" name="emr_phone22" value="{{old('emr_phone22')}}" class="form-control numberOnly" >
                      </div>
                  </div>
                </div>

              </div>
            </div>
        </div>


        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Family Informations')}}</h4></div>
            <div class="card-body employee-detail-create-body">
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="emr_family_name2[]" id="emr_family_name2[]" value="" class="form-control txtOnly" >
                        </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Relationship</label>
                          <input type="text" name="emr_family_relation2[]" id="emr_family_relation2[]" value="" class="form-control txtOnly" >
                      </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date Of Birth</label>
                            <input type="text" name="emr_dob[]" id="emr_dob[]" value="" class="form-control datetime1" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="emr_family_phone[]" id="emr_family_phone[]" value="" class="form-control numberOnly" >
                        </div>
                    </div>
                    <div class="col-sm-12" id="append_row12"></div>
                    <div class="col-sm-12 text-right">
                      <div class="form-group">
                        <a href="javascript:void(0);" id="add_more12" class="btn btn-success"><i class="fa fa-plus"></i> Add More</a>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Education  Qualification')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="checkbox" class="mr-1 get_qualification" value="Cert"  name="emp_qualification[]" >
                    <label for="">Cert</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="checkbox" class="mr-1 get_qualification" value="CO/A levelert"  name="emp_qualification[]" >
                    <label for="">O/A level</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="checkbox" class="mr-1 get_qualification" value="Diploma"  name="emp_qualification[]" >
                    <label for="">Diploma</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="checkbox" class="mr-1 get_qualification" value="Degree"  name="emp_qualification[]" >
                    <label for="">Degree</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="checkbox" class="mr-1 get_qualification" value="Others"  name="emp_qualification[]" >
                    <label for="">Others</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" style="display:none;" id="emp_qal_id">
                    <input type="text" class="form-control" placeholder="If Others Please Specify" name="emp_qual_text">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('License ')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="table-responsive dataTables_wrapper">
                      <table class="table table-striped mb-0" id="">
                          <thead>
                            <tr>
                                <th >{{__('License Name')}}</th>
                                <th>{{__('Expire Date')}}</th>
                                <th>{{__('Other')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                          </thead>
                          <tbody id="append_row">
                            <tr>
                              <td>
                                  <select name="emp_license[0]" id="emp_license[0]" class="form-control"  onChange="licenseChecks(0)">
                                      <option value="">Select License</option>
                                      <option value="M-bike">M-bike</option>
                                      <option value="Car">Car</option>
                                      <option value="Lorry">Lorry</option>
                                      <option value="E-bike">E-bike</option>
                                      <option value="Forklift">Forklift</option>
                                      <option value="Boat">Boat</option>
                                      <option value="Others">Others</option>
                                  </select>
                              </td>
                              <td><input type="text" class="form-control datetime " name="lic_expire_Date[0]" id="lic_expire_Date[0]" readonly></td>
                              <td><input type="text" class="form-control  " placeholder="" name="other_text[0]" id="other_text[0]" readonly></td>
                             <td><a href="javascript:void(0);" id="add_more" class="btn btn-success" style="min-width: 82px;">Add</a></th></td>
                          </tr>
                          </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Experience Informations')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Company Name</label> <span class="text-danger pl-1">*</span>
                        <input type="text" name="exp_name[]" value="{{old('exp_name')}}" class="form-control txtOnly" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="exp_location[]" value="{{old('exp_location')}}" class="form-control" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Job Position</label>
                        <input type="text" name="exp_job_position[]" value="{{old('exp_job_position')}}" class="form-control txtOnly" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Period</label>
                        <div class="input-group">
                          <input type="text" name="exp_from[]" value="{{old('exp_from')}}" class="form-control datetime" placeholder="From" />
                          <input type="text" name="exp_to[]" value="{{old('exp_to')}}" class="form-control datetime" placeholder="To" />
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="append_row13"></div>
                <div class="col-md-12 text-right">
                  <div class="form-group">
                    <a href="javascript:void(0);" id="add_more13" class="btn btn-success"><i class="fa fa-plus"></i> Add More</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Bank information')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Bank Name</label><span class="text-danger pl-1">*</span>
                    <input type="text" name="bank_name" value="{{old('bank_name')}}" class="form-control txtOnly" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Bank Account No.</label><span class="text-danger pl-1">*</span>
                    <input type="text" name="bank_account_no" value="{{old('bank_account_no')}}" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Bank Branch Code</label><span class="text-danger pl-1">*</span>
                    <input type="text" name="bank_branch_code" value="{{old('bank_branch_code')}}" class="form-control " required>
                  </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>SWIFT/BIC/IFSC Code<span class="text-danger pl-1"></span></label>
                        <input type="text" name="unique_no" value="{{old('unique_no')}}" class="form-control"  />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>PayNow</label>
                        <input type="text" name="bank_pay_now" value="" class="form-control" />
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Working Hours')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">


                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Shift</label><span class="text-danger pl-1">*</span>
                        <select class="form-control" name="shift_type" required="">
                            <option value=""> Select Shift</option>
                            @if($shift_types)
                                @foreach($shift_types as $shift_type)
                                <option value="{{$shift_type->id}}">{{$shift_type->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                  </div>


            </div>
          </div>

        </div>
</div>




        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Basic Salary Information')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label> Salary Basis </label><span class="text-danger pl-1">*</span>
                        <select class="form-control" data-select2-id="select2-data-22-3vdp" tabindex="-1" aria-hidden="true" name="salary_type" id="salary_type" required>
                            <option value="">Select salary basis type</option>
                            <option value="Hourly">Hourly</option>
                            <option value="Daily">Daily</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                     <label>Pay Grade</label><span class="text-danger pl-1">*</span>
                     <select class="form-control" name="pay_grade" id="pay_grade" required></select>
                  </div>
                </div>
                <div class="col-md-3 ">
                  <div class="form-group">
                    <label class="">Gross Salary</label><span class="text-danger pl-1">*</span>
                    <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text">$</span>
                      </div>
                      <input type="text" name="salary_amount" value="{{old('salary_amount')}}" id="salary_amount" class="form-control numberOnly" required readonly>
                    </div>
                  </div>
                </div>




                <div class="col-md-3">
                    <div class="form-group">
                        <label>Payment Type<span class="text-danger pl-1">*</span></label>
                        <select class="form-control select2" name="payment_type" id="payment_type" required>
                            <option value="">Select payment type</option>
                            <option value="Bank transfer">Bank transfer</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Cash">Cash</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" id="emp_payment" style="display:none;">
                    <div class="form-group">
                       <label>If Other Payment<span class="text-danger pl-1">*</span></label>
                        <input type="text" name="other_payment" value="" id="other_payment" class="form-control" >
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Deduction')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="table-responsive dataTables_wrapper">
                      <table class="table table-striped mb-0" id="">
                          <thead>
                            <tr>
                                <th >{{__('Deduction Name')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Other Text')}}</th>
                                <th>{{__('Other Amount')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                          </thead>
                          <tbody id="append_row1">
                            <tr>
                                <td>
                                  <select class="form-control  select2" id="deduction_id[0]" name="deduction_id[0]" onChange="deductChecks(0)">
                                    <option value="">Select</option>
                                  @foreach($deductions as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                  @endforeach
                                  </select>
                                </td>
                                <td><input type="text" class="form-control" name="deduction_amount[0]" id="deduction_amount[0]" readonly></td>
                                <td><input type="text" class="form-control" name="other_text_d[0]" id="other_text_d[0]" readonly></td>
                                <td><input type="text" class="form-control numberOnly" name="other_amount[0]" id="other_amount[0]" readonly></td>
                                <td><a href="javascript:void(0);" id="add_more1" class="btn btn-success">Add</a></th></td>
                            </tr>
                          </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12" id="cpf_title">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('CPF Information')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                  <div class="col-md-3" id="cpf_contribution_text">
                    <div class="form-group">
                      <label>CPF Contribution</label><span class="text-danger pl-1">*</span>
                      <select class="form-control" name="cpf_contribution" id="cpf_contribution" >
                        <option value="">Select CPF contribution</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3" id="cpf_no_text">
                    <div class="form-group">
                      <label>CPF No.</label><span class="text-danger pl-1">*</span>
                      <input type="text" name="cpf_no" value="{{old('cpf_no')}}" class="form-control" id="cpf_no">
                    </div>
                  </div>

                  <div class="col-md-3" id="emp_cpf_contribution_text">
                    <div class="form-group">
                      <label> Employee CPF Contribution </label><span class="text-danger pl-1">*</span>
                      <select class="form-control" data-select2-id="select2-data-22-3vdp" tabindex="-1" aria-hidden="true" name="emp_cpf_contribution" id="emp_cpf_contribution" >
                        <option value="">Select Employee CPF contribution</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-success"><h4 class="text-white">{{__('Other Documents')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
                <div class="col-md-12">
                    <label>Documents Upload</label><span class="text-danger pl-1">*</span>
                    <input type="file" name="document_upload[]" id="document_upload" multiple required class="form-control" >
                    <span style="font-size:10px;color:red;">Upload files only: png,jpg,jpeg,pdf,xlsx,csv</span>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-12 mb-2">
          {!! Form::submit('Create', ['class' => 'btn btn-success float-right']) !!}
        </div>

      </div>


{!! Form::close() !!}

@endsection

@push('script-page')
<script>


        $('.datetime').daterangepicker({
    locale: {
      format: 'DD-MM-YYYY'
    },
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });

  </script>
    <script>

    var totaldeductrows = 1;
    var totallicsense = 1;
    function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('.custom-file-container__image-preview').html('<img src="'+e.target.result+'" style="width:150px;height:150px;">');
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


        $(document).ready(function () {


                $( ".txtOnly" ).keypress(function(e) {
                    var key = e.keyCode;
                    if (key >= 48 && key <= 57) {
                        e.preventDefault();
                    }
                });
                $(".numberOnly").keypress(function (e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                   // $("#errmsg").html("Digits Only").show().fadeOut("slow");
                    return false;
                        }
                });


                $("#profile_images").change(function() {

                    var check_format=$(this).val();
                var ext = check_format.split('.').pop();
                if(ext=='png' || ext=='jpg' || ext=='jpeg' || ext=='xlsx' || ext=='csv' || ext=='pdf' || ext=='PDF')
                {
                readURL(this);
                }
                else
                {
                alert("Please select valid file format");
                $("#check_format").val('');
                return false;
                }

                });

            var b_id = $('#branch_id').val();
            getDepartment(b_id);


            var d_id = $('#department_id').val();
            getDesignation(d_id);
            getjbr(d_id);



                $('#emp_type').on('change', function() {
                var emply_type=$(this).val();

                    if(emply_type=='Other')
                    {
                        $(".foreign_worker").removeClass('hide');
                        $("#ca_postalcode").prop('required',true);
                        $("#ca_street").prop('required',true);
                        $("#ca_build").prop('required',true);
                        $("#ca_unitfrm").prop('required',true);
                        $("#emp_type_text").show();
                        $("#emp_type_year").hide();


                        $("#cpf_no_text").hide();
                        $("#cpf_contribution_text").hide();
                        $("#emp_cpf_contribution_text").hide();
                        $("#additional_rate_text").hide();
                        $("#total_rate_text").hide();

                        $("#other_emp").prop('required',true);
                        $("#year_type").prop('required',false);
                        $("#pass_type").prop('required',true);
                        $("#donation_type").prop('required',false);
                        $("#cpf_contribution").val('No');
                        $("#cpf_no").val('');
                        $("#emp_cpf_contribution").val('');
                        $("#additional_rate").val('');
                        $("#total_rate").val('');
                        $("#emp_donation_type").hide();
                        $("#emp_pass_type").show();
                        $("#cpf_title").hide();


                    }else if(emply_type=='Singapore Citizen')
                    {
                      $(".foreign_worker").addClass('hide');
                      $("#ca_postalcode").prop('required',false);
                      $("#ca_street").prop('required',false);
                      $("#ca_build").prop('required',false);
                      $("#ca_unitfrm").prop('required',false);
                        $("#cpf_contribution").val('Yes');
                        $("#emp_cpf_contribution").val('Yes');
                         $("#emp_type_text").hide();
                         $("#emp_type_year").show();

                         $("#cpf_no_text").show();
                        $("#cpf_contribution_text").show();
                        $("#emp_cpf_contribution_text").show();
                        $("#additional_rate_text").show();
                        $("#total_rate_text").show();
                        $("#other_emp").val('');
                        $("#emp_donation_type").show();
                        $("#emp_pass_type").hide();
                        $("#cpf_title").show();
                        $("#other_emp").prop('required',false);
                        $("#year_type").prop('required',true);
                        $("#cpf_contribution").prop('required',true);
                        $("#cpf_no").prop('required',true);
                        $("#emp_cpf_contribution").prop('required',true);
                        $("#additional_rate").prop('required',true);
                        $("#total_rate").prop('required',true);
                        $("#emp_pass_type").hide();
                        $("#pass_type").prop('required',false);
                        $("#donation_type").prop('required',true);


                    }else if(emply_type=='Permanent Resident')
                    {
                      $(".foreign_worker").addClass('hide');
                      $("#ca_postalcode").prop('required',false);
                      $("#ca_street").prop('required',false);
                      $("#ca_build").prop('required',false);
                      $("#ca_unitfrm").prop('required',false);
                         $("#emp_type_text").hide();
                         $("#emp_type_year").show();
                         $("#cpf_no_text").show();
                        $("#cpf_contribution_text").show();
                        $("#emp_cpf_contribution_text").show();
                        $("#additional_rate_text").show();
                        $("#total_rate_text").show();
                        $("#other_emp").val('');
                        $("#emp_donation_type").show();
                        $("#emp_pass_type").hide();
                        $("#cpf_title").show();
                        $("#other_emp").prop('required',false);
                        $("#year_type").prop('required',true);
                        $("#cpf_contribution").prop('required',true);
                        $("#cpf_no").prop('required',true);
                        $("#emp_cpf_contribution").prop('required',true);
                        $("#additional_rate").prop('required',true);
                        $("#total_rate").prop('required',true);
                        $("#pass_type").prop('required',false);
                        $("#donation_type").prop('required',true);
                        $("#cpf_contribution").val('Yes');
                        $("#emp_cpf_contribution").val('Yes');
                    }
                    else if(emply_type=='Foreign Worker Levy'){
                      $(".foreign_worker").removeClass('hide');
                      $("#ca_postalcode").prop('required',true);
                      $("#ca_street").prop('required',true);
                      $("#ca_build").prop('required',true);
                      $("#ca_unitfrm").prop('required',true);
                    } else
                    {   $(".foreign_worker").removeClass('hide');
                    $("#ca_postalcode").prop('required',true);
                    $("#ca_street").prop('required',true);
                    $("#ca_build").prop('required',true);
                    $("#ca_unitfrm").prop('required',true);
                        $("#cpf_title").hide();
                        $("#emp_donation_type").hide();
                        $("#emp_pass_type").show();
                        $("#other_emp").prop('required',false);
                        $("#year_type").prop('required',false);
                        $("#cpf_contribution").prop('required',false);
                        $("#cpf_no").prop('required',false);
                        $("#emp_cpf_contribution").prop('required',false);
                        $("#additional_rate").prop('required',false);
                        $("#total_rate").prop('required',false);

                        $("#other_emp").val('');
                        $("#year_type").val('');
                        $("#cpf_contribution").val('No');
                        $("#cpf_no").val('');
                        $("#emp_cpf_contribution").val('');
                        $("#additional_rate").val('');
                        $("#total_rate").val('');

                         $("#emp_type_text").hide();
                         $("#emp_type_year").hide();
                         $("#cpf_no_text").hide();
                        $("#cpf_contribution_text").hide();
                        $("#emp_cpf_contribution_text").hide();
                        $("#additional_rate_text").hide();
                        $("#total_rate_text").hide();
                        $("#year_type").val('');
                        $("#pass_type").prop('required',true);
                        $("#donation_type").prop('required',false);
                    }



                });







                $('.get_qualification').click(function(){

                        var emp_ql_id=$(this).val();
                    if($(this).prop("checked") == true){

                            if(emp_ql_id=='Others')
                            {
                                $("#emp_qal_id").show();
                            }

                    }
                   if($(this).prop("checked") == false){

                            if(emp_ql_id=='Others')
                            {
                                $("#emp_qal_id").hide();
                            }

                    }
                 });


                  /*  $('.get_license').click(function(){

                        var emp_ql_id=$(this).val();
                        if($(this).prop("checked") == true){

                            if(emp_ql_id=='Others')
                            {
                                $("#emp_licence_id").show();
                            }

                        }
                        if($(this).prop("checked") == false){

                                if(emp_ql_id=='Others')
                                {
                                 $("#emp_licence_id").hide();
                                }

                        }
                    });   */

                    $('.get_technical').click(function(){

                        var emp_ql_id=$(this).val();
                        if($(this).prop("checked") == true){

                            if(emp_ql_id=='Others')
                            {
                                $("#id_get_technical").show();
                            }

                        }
                        if($(this).prop("checked") == false){

                                if(emp_ql_id=='Others')
                                {
                                 $("#id_get_technical").hide();
                                }

                        }
                    });

                    $('.get_ertificates').click(function(){

                        var emp_ql_id=$(this).val();
                        if($(this).prop("checked") == true){

                            if(emp_ql_id=='Others')
                            {
                                $("#id_get_ertificates").show();
                            }

                        }
                        if($(this).prop("checked") == false){

                                if(emp_ql_id=='Others')
                                {
                                 $("#id_get_ertificates").hide();
                                }

                        }
                    });


                    $('.get_skills').click(function(){

                        var emp_ql_id=$(this).val();
                        if($(this).prop("checked") == true){

                            if(emp_ql_id=='Others')
                            {
                                $("#id_get_skills").show();
                            }

                        }
                        if($(this).prop("checked") == false){

                                if(emp_ql_id=='Others')
                                {
                                 $("#id_get_skills").hide();
                                }

                        }
                    });

         $("#salary_type").on('change',function () {
            $("#salary_amount").val('');
            var salary_type = $(this).val();
            $.ajax({
                url: '{{route('employee.json_salry')}}',
                type: 'POST',
                data: {
                    "salary_type": salary_type, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $("#pay_grade").html(data.html);
                }
            });

        });

        $("#pay_grade").on('change',function () {
            var pay_grade = $(this).val();
            $.ajax({
                url: '{{route('employee.json_salry_amount')}}',
                type: 'POST',
                data: {
                    "pay_grade": pay_grade, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {

                    $("#salary_amount").val(data.gross_salary);
                }
            });
        });


                $("#branch_id").on('change',function () {
                  var branch_id = $(this).val();
                  getDepartment(branch_id);
                });


        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
            getjbr(department_id);
        });


        function getjbr(did) {

            $.ajax({
                url: '{{route('employee.json1')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    //$('#responsibilties_id').disabled = !  $('#responsibilties_id').disabled;
                    $("#responsibilties_id").prop('readOnly',true);
                    $('#responsibilties_id').empty();
                    $.each(data, function (key, value) {
                        $('#responsibilties_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    //$('#responsibilties_id').disabled = !  $('#responsibilties_id').disabled;
                    $("#responsibilties_id").prop('readonly',false);
                }
            });
        }



        function getDeductAmt(eledmt,did) {

            $.ajax({
                url: '{{route('employee.json7')}}',
                type: 'POST',
                data: {
                    "deduction_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    eledmt.value = "0";
                    $.each(data, function (key, value) {
                      eledmt.value=value;
                    });


                }
            });
        }





        function getDepartment(did) {

            $.ajax({
                url: '{{route('employee.json6')}}',
                type: 'POST',
                data: {
                    "branch_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    //$('#department_id').disabled = !  $('#department_id').disabled;
                    $("#department_id").prop('readonly',true);

                    $('#department_id').empty();
                    $.each(data, function (key, value) {
                        $('#department_id').append('<option value="">{{__('Select Department')}}</option>');
                        $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $("#department_id").prop('readonly',false);
                    //$('#department_id').disabled = !  $('#department_id').disabled;

                }
            });
        }





        function getDesignation(did) {

            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    //$('#designation_id').disabled = !  $('#designation_id').disabled;
                    $("#designation_id").prop('readonly',true);
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">{{__('Select any Designation')}}</option>');
                    $.each(data, function (key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    //$('#designation_id').disabled = !  $('#designation_id').disabled;
                    $("#designation_id").prop('readonly',false);

                    //$('#report_id').disabled = !  $('#report_id').disabled;
                    $("#report_id").prop('readonly',true);
                    $('#report_id').empty();
                    $('#report_id').append('<option value="">{{__('Select any Designation')}}</option>');
                    $.each(data, function (key, value) {
                        $('#report_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    //$('#report_id').disabled = !  $('#report_id').disabled;
                    $("#report_id").prop('readonly',false);
                }
            });
        }
$(document).ready(function(){
    $("#document_upload").on("change",function(){
        var check_format=$(this).val();
        var ext = check_format.split('.').pop();
        if(ext=='png' || ext=='jpg' || ext=='jpeg' || ext=='xlsx' || ext=='csv' || ext=='pdf' || ext=='PDF')
        {

        }
        else
        {
            alert("Please select valid file format");
            $("#document_upload").val('');
            return false;
        }
    });

    $('#designation_id').on('change', function() {
        var designation_type=$(this).val();

        if(designation_type=='{{App\Employee::worker_desig_id()}}')
        {
            $(".designation_worker").removeClass('hide');
            $(".worker_team").removeClass('hide');
            $("#team_id").prop('required',true);
            $("#worker_id").prop('required',true);
          //  console.log($("#team_id").readOnly);
            //$('#team_id').on('change', function() {
                //var team_type=$(this).val();

              //  if(team_type=='Unassigned')
            //    {
                //  $(".worker_supervisor").removeClass('hide');
              //  } else {
                //  $(".worker_supervisor").addClass('hide');
            //    }
            //  });

        }
        else if(designation_type=='{{App\Employee::supervisor_desig_id()}}')
        {
            $(".designation_worker").addClass('hide');
            $(".worker_team").addClass('hide');
            $("#team_id").prop('required',false);
              $("#worker_id").prop('required',false);
          //  $(".worker_supervisor").addClass('hide');
          //  $('#team_id').on('change', function() {
              //  var team_type=$(this).val();

            //    if(team_type=='Unassigned')
              //  {
                //  $(".worker_supervisor").addClass('hide');
            //    } else {
                //  $(".worker_supervisor").addClass('hide');
            //    }
          //    });

        } else {
          $(".designation_worker").addClass('hide');
          $(".worker_team").addClass('hide');
        //  $(".worker_supervisor").addClass('hide');
        //  $('#team_id').on('change', function() {
        //      var team_type=$(this).val();

        //      if(team_type=='Unassigned')
        //      {
              //  $(".worker_supervisor").addClass('hide');
          //    } else {
            //    $(".worker_supervisor").addClass('hide');
        //      }
        //    });
        }
      });

      $('#worker_id').on('change', function() {
          var team_type=$(this).val();
          if(team_type=='cleaner')
          {
            $(".client_location").removeClass('hide');
          } else if(team_type=='floater') {
            $(".client_location").addClass('hide');
          } else {
            $(".client_location").addClass('hide');
          }
        });
        $('#probation_period').on('change', function() {
          var prob_type=$(this).val();
          //alert(dept_type);
          if(prob_type=='Other')
          {
             $("#emp_other_prob").show();
          }
          else{
              $("#emp_other_prob").hide();

          }
        });
        $('#contract_period').on('change', function() {
            var contract_type=$(this).val();
            //alert(dept_type);
            if(contract_type=='Other')
            {
               $("#emp_other_contract").show();
            }
            else{
                $("#emp_other_contract").hide();

            }
      });
      $('#notice_period').on('change', function() {
          var notice_type=$(this).val();
          //alert(dept_type);
          if(notice_type=='Other')
          {
             $("#emp_other_notice").show();
          }
          else{
              $("#emp_other_notice").hide();

          }
        });
        $('#marital_status').on('change', function() {
          var marital_type=$(this).val();
          //alert(dept_type);
          if(marital_type=='Other')
          {
             $("#emp_marital").show();
          }
          else{
              $("#emp_marital").hide();

          }
        });
        $("#own_bike").click(function () {
            if ($(this).is(":checked")) {
                $("#own_bike1").show();
            } else {
                $("#own_bike1").hide();
            }
        });
        $("#own_sg_car").click(function () {
            if ($(this).is(":checked")) {
                $("#own_car1").show();
            } else {
                $("#own_car1").hide();
            }
        });
        $('input:radio[name="own_friday"]').change(function(){
          if($(this).val() == 'friday'){
             $('.own_friday_input').removeClass('hide');
             $('.own_saturday_input').addClass('hide');
          } else if($(this).val() == 'saturday') {
            $('.own_friday_input').addClass('hide');
            $('.own_saturday_input').removeClass('hide');
          } else {
            $('.own_friday_input').addClass('hide');
            $('.own_saturday_input').addClass('hide');
          }
      });
      $("#alloancw_type").on("change",function(){
        var  alloancw_type=$("#alloancw_type").val();

        if(alloancw_type=='')
        {
            $("#div_variation").hide();
            $("#div_fixed").hide();
            $("#variation_text").prop('required',false);
            $("#fixed_amount").prop('required',false);
            $("#variation_text").val('');
            $("#fixed_amount").val('');

        }
        else if(alloancw_type=='Variation')
        {
            $("#div_variation").show();
            $("#div_fixed").hide();
            $("#variation_text").prop('required',true);
            $("#fixed_amount").prop('required',false);
            $("#variation_text").val('');
        }
        else
        {
            $("#div_variation").hide();

            $("#div_fixed").show();
            $("#fixed_amount").val('');
            $("#fixed_amount").prop('required',true);
            $("#variation_text").prop('required',false);
        }

    });
    $('#payment_type').on('change', function() {
      var payment_type1=$(this).val();
      //alert(payment_type1);
      if(payment_type1=='Other')
      {
         $("#emp_payment").show();
      }
      else{
          $("#emp_payment").hide();

      }
    });
///////////////////////////////////////////////////////////////////////

$("#add_more").click(function(){

    //var emp_license=$("#emp_license[0]").val();
    //var lic_expire_Date=$("#lic_expire_Date").val();
    //var other_text=$("#other_text").val();
    //alert(emp_license);
    if(1 != 1) //if(emp_license=='')
    {
      //alert("Please fill data.");
      //return false;
    }
    else
    {
      $html= '<tr class="set_value"><td><select name="emp_license['+totallicsense+']" id="emp_license['+totallicsense+']" class="form-control" onChange="licenseChecks('+totallicsense+')">';
      $html= $html+'<option value="">Select License</option>';
      $html= $html+'<option value="M-bike">M-bike</option>';
      $html= $html+'<option value="Car">Car</option>';
      $html= $html+'<option value="Lorry">Lorry</option>';
      $html= $html+'<option value="E-bike">E-bike</option>';
      $html= $html+'<option value="Forklift">Forklift</option>';
      $html= $html+'<option value="Boat">Boat</option>';
      $html= $html+'<option value="Others">Others</option>';
      $html= $html+'</select></td><td><input type="text" class="form-control datetime1 "  name="lic_expire_Date['+totallicsense+']" id="lic_expire_Date['+totallicsense+']" readOnly></td> <td><input type="text" class="form-control  " placeholder="" id="other_text['+totallicsense+']" name="other_text['+totallicsense+']"  readonly></td><td><a href="javascript:void(0);"   id="remove_current" class="btn btn-danger remove_current_element">Remove</a></td></tr>';
    $("#append_row").append($html);
    $('.datetime1').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      },
      singleDatePicker: true,
      showDropdowns: true,
      autoUpdateInput: false,
      minYear: 1901,
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      var years = moment().diff(start, 'years');

    });
    $('.datetime1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
    totallicsense = totallicsense + 1;

    }
});

$("body").on("click",".remove_current_element",function(){
        $(this).parents(".set_value").remove();
});

$("#add_more12").click(function(){

    var family_name=$("#emr_family_name2").val();
    var family_relation=$("#emr_family_relation2").val();
    var fam_dob=$("#emr_dob").val();
    if(family_relation=='' && family_name=='')
    {
    alert("Please fill data.");
    return false;
    }
    else
    {
    $html= '<div class="row set_value12"><div class="col"><div class="row"><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Name" name="emr_family_name2[]" value="" ></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Relationship" name="emr_family_relation2[]" value="" ></div></div><div class="col-md-3"><div class="form-group"><input type="text" placeholder="Date Of Birth" name="emr_dob[]" value="" class="form-control datetime1" ></div></div><div class="col-md-3"><div class="input-group"><input type="text" class="form-control" placeholder="Phone" name="emr_family_phone[]" value="" ><a href="javascript:void(0);" id="remove_current" class="btn btn-danger remove_current_element"><i class="fa fa-times"></i></a></div></div></div></div></div>';
    $("#append_row12").append($html);
    $('.datetime1').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      },
      singleDatePicker: true,
      showDropdowns: true,
      autoUpdateInput: false,
      minYear: 1901,
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      var years = moment().diff(start, 'years');

    });
    $('.datetime1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
    }

});

$("body").on("click",".remove_current_element",function(){
        $(this).parents(".set_value12").remove();
});

$("#add_more13").click(function(){

    var exp_name=$("#exp_name").val();
    var exp_location=$("#exp_location").val();
    var exp_job_position=$("#exp_job_position").val();
    var exp_from=$("#exp_from").val();
    var exp_to=$("#exp_to").val();
    if(exp_name=='' && exp_location=='' && exp_job_position=='')
    {
    alert("Please fill data.");
    return false;
    }
    else
    {
    $html= '<div class="set_value13">            <div class="row">              <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Company Name" name="exp_name[]" value=""></div></div>              <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Location" name="exp_location[]" value="" ></div></div>              <div class="col-md-3"><div class="form-group"><input type="text" class="form-control" placeholder="Job Position" name="exp_job_position[]" value="" ></div></div>            <div class="col-md-3">            <div class="input-group"><input type="text" class="form-control datetime1" placeholder="Period From" name="exp_from[]" value="" >            <input type="text" class="form-control datetime1" placeholder="Period To" name="exp_to[]" value="" ><a href="javascript:void(0);" id="remove_current" class="btn btn-danger remove_current_element"><i class="fa fa-times"></i></a> </div> </div>   </div>            </div>';
    $("#append_row13").append($html);
    $('.datetime1').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      },
      singleDatePicker: true,
      showDropdowns: true,
      autoUpdateInput: false,
      minYear: 1901,
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      var years = moment().diff(start, 'years');

    });
    $('.datetime1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
    }

});

$("body").on("click",".remove_current_element",function(){
        $(this).parents(".set_value13").remove();
});


$("#add_more1").click(function(){
    //var deduction_id=$("#deduction_id").val();
    //var deduction_text=$( "#deduction_id option:selected" ).text();
    //var deduction_amount=$("#deduction_amount").val();
    //var other_amount=$("#other_amount").val();
    //var other_text_d=$("#other_text_d").val();
    if(1 != 1)  //if(emp_license=='')
    {
      alert("Please fill data.");
      return false;
    }
      else
    {
      //alert(totaldeductrows);
      $html= '<tr class="set_value'+totaldeductrows+'" id="set_value'+totaldeductrows+'"><td><select class="form-control  select2" id="deduction_id['+totaldeductrows+']" name="deduction_id['+totaldeductrows+']" onChange="deductChecks('+totaldeductrows+')">';
      @foreach($deductions as $key => $value)
        $html= $html+'<option value="{{$key}}">{{$value}}</option>';
      @endforeach
      $html= $html+'</select></td><td><input type="text" class="form-control" placeholder="" id="deduction_amount['+totaldeductrows+']" name="deduction_amount['+totaldeductrows+']" value="" ></td> <td><input type="text" class="form-control" placeholder="" name="other_text_d['+totaldeductrows+']" id="other_text_d['+totaldeductrows+']" value="" readonly></td> <td><input type="text" class="form-control  " placeholder="" name="other_amount['+totaldeductrows+']" id="other_amount['+totaldeductrows+']" value="" readonly></td><td><a href="javascript:void(0);"   id="remove_current'+totaldeductrows+'" class="btn btn-danger remove_current_element1" onClick="removeDeduct('+totaldeductrows+')">Remove</a></td></tr>';

      $("#append_row1").append($html);
      totaldeductrows = totaldeductrows + 1;
    }
});




//$("body").on("click",".remove_current_element1",function(){
//        $(this).parents(".set_value1").remove();
//});
/////////////////////////////////////////////////////////////////

$('#branch_id').on('change', function() {
//var branch_type=$(this).val();

    /* if(branch_type=='Other')
    {
       $("#emp_other_branch").show();
    }
    else{
        $("#emp_other_branch").hide();

    } */
  });
  $('#department_id').on('change', function() {
  /*var dept_type=$(this).val();
  //alert(dept_type);
  if(dept_type=='Other')
  {
    // $("#emp_other_dep").show();
  }
  else{
    //  $("#emp_other_branch").hide();

  } */
});





});


function removeDeduct(rownum) {
  var liElements = document.getElementById("set_value"+rownum);
  liElements.remove();
}


function deductChecks(rownum) {
    var liElements = document.getElementById("deduction_id["+rownum+"]");
    var deduction_id = liElements.value;
    var oamt =  document.getElementById("other_amount["+rownum+"]");
    var ot =  document.getElementById("other_text_d["+rownum+"]");
    var dmt =   document.getElementById("deduction_amount["+rownum+"]");
    getDeductAmt(dmt,deduction_id);
    if(deduction_id=='987')
    {

          oamt.required = true;
          oamt.readOnly  = false;
          ot.required = true;
          ot.readOnly  = false;
          dmt.value = '';
          dmt.required = false;
          dmt.readOnly  = true;
    }
    else
    {
          if(deduction_id=='') {
            oamt.required = false;
            dmt.required = false;
            ot.required = false;
            oamt.readOnly = true;
            dmt.readOnly = true;
            ot.readOnly = true;
            dmt.value = '';
            ot.value = '';
            oamt.value = '';
          } else {
            oamt.value = '';
            oamt.required = false;
            oamt.readOnly  = true;
            ot.required = false;
            ot.readOnly  = true;
            dmt.value = '';
            ot.value = '';
            dmt.required = true;
            dmt.readOnly  = true;
          }
    }
}


function licenseChecks(rownum) {

  var liElements = document.getElementById("emp_license["+rownum+"]");
  var license_id = liElements.value;
  var dtamt =  document.getElementById("lic_expire_Date["+rownum+"]");
  var ot =  document.getElementById("other_text["+rownum+"]");
  //.var dmt =   document.getElementById("deduction_amount["+rownum+"]");



       if(license_id=='')
       {
         dtamt.required = false;
         ot.required = false;
         dtamt.readOnly  = true;
         ot.readOnly  = true;
       }
       else if(license_id=='Others')
        {
          dtamt.required = true;
          ot.required = true;
          dtamt.readOnly  = false;
          ot.readOnly  = false;
        }
        else
        {
          dtamt.required = true;
          ot.required = false;
          dtamt.readOnly  = false;
          ot.readOnly  = true;
        }

}




    </script>

@endpush
