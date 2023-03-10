@extends('layouts.dashboard')
@section('page-title')
    {{__('Employee')}}
@endsection
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="page-title-box-hori">
            <h4 class="page-title">{{__('Edit Employee')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="{{__('home')}}">{{__('Dashboard')}}</a></li>
                  <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
                  <li class="breadcrumb-item active">{{__('Edit')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<hr class="mt-0">

{{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data')) }}
    @csrf
    <div class="row">
        <div class="col-md-12 ">
            <div class="card ">
                <div class="card-header"><h4>{{__('Basic Information')}}</h4></div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label>First Name</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="first_name" value="{{$employee->first_name}}" class="form-control txtOnly" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                               <label>Last Name</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="last_name" value="{{$employee->last_name}}" class="form-control txtOnly" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                               <label>Username</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="username" value="{{$employee->username}}" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                               <label>Email</label><span class="text-danger pl-1">*</span>
                                <input type="email" name="email" value="{{$employee->email}}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                        <div class="form-group">
                               <label>Date Of Birth</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="dob" value="{{date('d-m-Y', strtotime($employee->dob))}}" class="form-control datetime" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label><span class="text-danger pl-1">*</span>
                                        <input type="text" name="address" value="{{$employee->address}}" class="form-control" required>
                                    </div>
                                </div>
                        </div>
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label>Password</label><span class="text-danger pl-1">*</span>
                                <input type="password" name="password" value="" class="form-control" placeholder="" >
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                               <label>Confirm Password</label><span class="text-danger pl-1">*</span>
                                <input type="password" name="confirm_password" value="" class="form-control" >
                            </div>
                        </div>
                    </div> -->


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label>Employee Type</label><span class="text-danger pl-1">*</span>
                                <select name="emp_type" required class="form-control " id="emp_type">
                                <option value="">Select Employee Type</option>
                                    <option value="Singapore Citizen" <?php if($employee->emp_type=="Singapore Citizen") echo 'selected="selected"'?>>Singapore Citizen</option>
                                    <option value="Permanent Resident" <?php if($employee->emp_type=="Permanent Resident") echo 'selected="selected"'?>>Permanent Resident</option>
                                    <option value="Malaysia" <?php if($employee->emp_type=="Malaysia") echo 'selected="selected"'?>>Malaysia</option>
                                    <option value="Work Pass" <?php if($employee->emp_type=="Work Pass") echo 'selected="selected"'?>>Work Pass</option>
                                    <option value="Foreign Worker Levy" <?php if($employee->emp_type=="Foreign Worker Levy") echo 'selected="selected"'?>>Foreign Worker Levy</option>
                                    <option value="Other" <?php if($employee->emp_type=="Other") echo 'selected="selected"'?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 ">

                        <div class="form-group" id="emp_type_text" @if($employee->emp_type=="Other")  @else  style="display:none" @endif>
                               <label>If Other Employee Type</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="other_emp" value="{{$employee->other_emp}}" id="other_emp" class="form-control txtOnly" >
                            </div>


                                <div class="form-group" id="emp_type_year"  @if($employee->emp_type=="Singapore Citizen" || $employee->emp_type=="Permanent Resident")  @else style="display:none" @endif >
                                <label>Years From</label><span class="text-danger pl-1">*</span>
                                <select name="year_type"  class="form-control" id="year_type">
                                        <option value="">Select years</option>
                                        <option value="One Year" <?php if($employee->year_type=="One Year") echo 'selected="selected"'?>>One Year</option>
                                        <option value="Two Year" <?php if($employee->year_type=="Two Year") echo 'selected="selected"'?>>Two Year</option>
                                        <option value="More Than 3 Years" <?php if($employee->emyear_typep_type=="More Than 3 Years") echo 'selected="selected"'?>>More Than 3 Years</option>
                                    </select>
                                </div>


                           <!-- <div class="form-group" id="emp_type_year" style="display:none;">
                               <label>Years From</label><span class="text-danger pl-1">*</span>
                               <select name="year_type"  class="form-control select2" id="year_type">
                                    <option value="">Select years</option>
                                    <option value="One Year">One Year</option>
                                    <option value="Two Year">Two Year</option>
                                    <option value="More Than 3 Years">More Than 3 Years</option>
                                </select>
                            </div> -->
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                               <label>Work Pass Type</label><span class="text-danger pl-1">*</span>
                                <select name="pass_type" required class="form-control">
                                <option value="">Select Type</option>
                                <option value="Work Permit" <?php if($employee->pass_type=="Work Permit") echo 'selected="selected"'?>>Work Permit</option>
                                <option value="S-Pass" <?php if($employee->pass_type=="S-Pass") echo 'selected="selected"'?>>S-Pass</option>
                                <option value="E-Pass" <?php if($employee->pass_type=="E-Pass") echo 'selected="selected"'?>>E-Pass</option>
                                </select>
                            </div>
                        </div> -->


                        <div class="col-md-6">
                            <div class="form-group" id="emp_pass_type" @if($employee->emp_type=="Singapore Citizen" || $employee->emp_type=="Permanent Resident")  style="display:none" @else  @endif>
                               <label>Work Pass Type</label><span class="text-danger pl-1">*</span>
                                <select name="pass_type"  class="form-control">
                                <option value="">Select Type</option>
                                <option value="Work Permit" <?php if(!empty($employee->pass_type) && $employee->pass_type=="Work Permit") echo 'selected="selected"'?>>Work Permit</option>
                                <option value="S-Pass" <?php if(!empty($employee->pass_type) && $employee->pass_type=="Work Permit") echo 'selected="selected"'?>>S-Pass</option>
                                <option value="E-Pass" <?php if(!empty($employee->pass_type) && $employee->pass_type=="Work Permit") echo 'selected="selected"'?>>E-Pass</option>
                                </select>
                            </div>



                            <div class="form-group" id="emp_donation_type" @if($employee->emp_type=="Singapore Citizen" || $employee->emp_type=="Permanent Resident")  @else style="display:none" @endif>
                               <label>CPF Donation Type</label><span class="text-danger pl-1">*</span>
                               <select name="donation_type"  class="form-control" id="donation_type">
                               <option value=""> Select Donation Type</option>
                                    <option value="N/A" <?php if(!empty($employee->donation_type) && $employee->donation_type=="N/A") echo 'selected="selected"'?>> N/A</option>
                                    <option value="CDAC" <?php if(!empty($employee->donation_type) && $employee->donation_type=="CDAC") echo 'selected="selected"'?>> CDAC</option>
                                    <option value="SINDA" <?php if(!empty($employee->donation_type) && $employee->donation_type=="SINDA") echo 'selected="selected"'?>> SINDA</option>
                                    <option value="ECF" <?php if(!empty($employee->donation_type) && $employee->donation_type=="ECF") echo 'selected="selected"'?>> ECF</option>
                                    <option value="MBMF" <?php if(!empty($employee->donation_type) && $employee->donation_type=="MBMF") echo 'selected="selected"'?>> MBMF</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6 ">
                        <div class="form-group">
                        {{ Form::label('branch_id', __('Branch')) }}
                        {{ Form::select('branch_id', $branches,null, array('class' => 'form-control  select2','required'=>'required')) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {{ Form::label('department_id', __('Department')) }}
                        {{ Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required')) }}
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                        {{ Form::label('designation_id', __('Designation')) }}
                        <select class="select2 form-control" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                            <option value="">{{__('Select any Designation')}}</option>
                        </select>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Role</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="user_type" value="employee" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                        {!! Form::label('employee_id', __('Employee ID')) !!}
                        {!! Form::text('employee_id', $employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <!-- {!! Form::label('company_doj', __('Company Date Of Joining')) !!}
                        {!! Form::text('company_doj', null, ['class' => 'form-control datepicker','required' => 'required']) !!} -->
                        <label>Company Date Of Joining</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="company_doj" value="{{date('d-m-Y', strtotime($employee_personal->passport_expire))}}" class="form-control datetime" required>

                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                        <!-- {!! Form::label('phone', __('Phone')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('phone', null, ['class' => 'form-control','required' => 'required']) !!} -->


                        <label>Phone</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="phone" value="{{$employee->phone}}" class="form-control" required>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <!-- {!! Form::label('company', __('Company')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('company', null, ['class' => 'form-control','required' => 'required']) !!} -->

                        <label>Company</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="company" value="{{$employee->company}}" class="form-control txtOnly" required>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                        <!-- {!! Form::label('nok', __('NOK')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('nok', null, ['class' => 'form-control','required' => 'required']) !!} -->

                        <label>NOK</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="nok" value="{{$employee->nok}}" class="form-control" required>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <!-- {!! Form::label('uniform', __('Uniform')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('uniform', null, ['class' => 'form-control','required' => 'required']) !!} -->

                        <label>Uniform</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="uniform" value="{{$employee->uniform}}" class="form-control txtOnly" required>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">
                        <!-- {!! Form::label('uniform_size', __('Uniform Size')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('uniform_size', null, ['class' => 'form-control','required' => 'required']) !!} -->

                        <label>Uniform Size</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="uniform_size" value="{{$employee->uniform_size}}" class="form-control" required>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <!-- {!! Form::label('contract_period', __('Probation Period/Contract ')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('contract_period', null, ['class' => 'form-control','required' => 'required']) !!} -->

                        <label>Probation Period/Contract</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="contract_period" value="{{$employee->contract_period}}" class="form-control" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                      <div class="col-md-6">
                          <div class="demo-upload-container">
                              <div class="custom-file-container" data-upload-id="myFirstImage">
                                  <label>Upload Profile Picture</label>

                                  <label class="custom-file-container__custom-file" >
                                  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                  <input type="file" class="custom-file-container__custom-file__custom-file-input" id="profile_images" name="profile_images" accept="*">
                                  <span class="custom-file-container__custom-file__custom-file-control"></span>
                                  </label>
                                  <em>Upload only jpg,jpeg,png file</em>
                                  <div class="custom-file-container__image-preview" style="height:120px !important">
                                  <img src="{{asset('public/uploads/document/')}}/{{$employee->documents}}" style="width:150px;height:150px;">
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
              <div class="card-header"><h4>{{__('Personal Information')}}</h4></div>
              <div class="card-body employee-detail-create-body">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Passport Number</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="passport_no" value="{{$employee_personal->passport_no}}" class="form-control" required>

                              <!-- {!! Form::label('passport_no', __('Passport Number')) !!}<span class="text-danger pl-1">*</span>
                              {!! Form::text('passport_no', null, ['class' => 'form-control','required' => 'required']) !!} -->
                          </div>
                      </div>
                      <div class="col-md-6 ">
                        <div class="form-group">
                          <!-- {!! Form::label('passport_expire', __(' Passport Expiry Date ')) !!}
                          {!! Form::text('passport_expire', null, ['class' => 'form-control datepicker','required' => 'required']) !!} -->

                          <label>Passport Expiry Date</label><span class="text-danger pl-1">*</span>
                          <input type="text" name="passport_expire" value="{{date('d-m-Y', strtotime($employee_personal->passport_expire))}}" class="form-control datetime" required>

                      </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                          <!-- {!! Form::label('tel', __('Tel')) !!}<span class="text-danger pl-1">*</span>
                      {!! Form::text('tel', null, ['class' => 'form-control']) !!} -->

                      <label>Tel</label>
                              <input type="text" name="tel" value="{{$employee_personal->tel}}" class="form-control numberOnly" >

                          </div>
                      </div>
                      <div class="col-md-6 ">
                      <div class="form-group">


                      <label>Nationality</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="nationality" value="{{$employee_personal->nationality}}" class="form-control txtOnly" required>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                          <!-- {!! Form::label('religion', __('Religion')) !!}<span class="text-danger pl-1">*</span>
                      {!! Form::text('religion', null, ['class' => 'form-control','required' => 'required']) !!} -->

                      <label>Religion</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="religion" value="{{$employee_personal->religion}}" class="form-control txtOnly" required>
                          </div>
                      </div>
                      <div class="col-md-6 ">
                      <div class="form-group">
                      {!! Form::label('nationality', __(' Marital Status ')) !!}
                      <select class="form-control" id="marital_status" name="marital_status" required>
                                  <option value="">Select status</option>
                                  <option value="Single" <?php if($employee_personal->marital_status=="Single") echo 'selected="selected"'?>>Single</option>
                                  <option value="Married" <?php if($employee_personal->marital_status=="Married") echo 'selected="selected"'?>>Married</option>
                      </select>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                              <!-- {!! Form::label('spouse', __('Employment of spouse')) !!}<span class="text-danger pl-1">*</span>
                          {!! Form::text('spouse', null, ['class' => 'form-control']) !!} -->
                          <label>Employment Of Spouse</label>
                              <input type="text" name="spouse" value="{{$employee_personal->spouse}}" class="form-control txtOnly" >
                              </div>
                          </div>
                          <div class="col-md-6 ">
                                  <div class="form-group">
                                      <!-- {!! Form::label('no_of_child', __('No. of children')) !!}<span class="text-danger pl-1">*</span>
                                      {!! Form::text('no_of_child', null, ['class' => 'form-control']) !!} -->

                                          <label>No. Of Children</label>
                                          <input type="text" name="no_of_child" value="{{$employee_personal->no_of_child}}" class="form-control" >
                                  </div>
                          </div>
                      </div>
              </div>
            </div>
        </div>


        <div class="col-md-12 ">
            <div class="card">
              <div class="card-header"><h4>{{__('Emergency Contact(Primary)')}}</h4></div>
              <div class="card-body employee-detail-create-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <!-- {!! Form::label('emr_name1', __('Name')) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::text('emr_name1', null, ['class' => 'form-control','required' => 'required']) !!} -->


                            <label>Name</label><span class="text-danger pl-1">*</span>
                            <input type="text" name="emr_name1" value="{{$employee_primary->emr_name1}}" class="form-control txtOnly" required>

                        </div>
                    </div>
                    <div class="col-md-6 ">
                      <div class="form-group">
                      <!-- {!! Form::label('emr_relation1', __('Relationship')) !!}
                      {!! Form::text('emr_relation1', null, ['class' => 'form-control ','required' => 'required']) !!} -->

                            <label>Relationship</label>
                            <input type="text" name="emr_relation1" value="{{$employee_primary->emr_relation1}}" class="form-control txtOnly" >

                        </div>
                    </div>
                </div>


                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>Phone</label>
                                <input type="text" name="emr_phone1" value="{{$employee_primary->emr_phone1}}" class="form-control numberOnly" >

                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">


                        <label>Phone2</label>
                                <input type="text" name="emr_phone12" value="{{$employee_primary->emr_phone12}}" class="form-control numberOnly" >

                            </div>
                        </div>
                    </div>
              </div>
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="card">
              <div class="card-header"><h4>{{__('Emergency Contact(Secondary)')}}</h4></div>
                <div class="card-body employee-detail-create-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>Name</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="emr_name2" value="{{$employee_secondry->emr_name2}}" class="form-control txtOnly" required>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">


                        <label>Relationship</label>
                                <input type="text" name="emr_relation2" value="{{$employee_secondry->emr_relation2}}" class="form-control txtOnly" >

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">


                        <label>Phone</label>
                                <input type="text" name="emr_phone2" value="{{$employee_secondry->emr_phone2}}" class="form-control numberOnly" >

                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">

                                <label>Phone2</label>
                                <input type="text" name="emr_phone22" value="{{$employee_secondry->emr_phone22}}" class="form-control numberOnly" >
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>

          <div class="col-md-12 ">
              <div class="card">
                <div class="card-header"><h4>{{__('Family Informations')}}</h4></div>
                  <div class="card-body employee-detail-create-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">


                        <label>Name</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="emr_family_name2" value="{{$employee_family->emr_family_name2}}" class="form-control txtOnly" required>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">


                        <label>Relationship</label>
                                <input type="text" name="emr_family_relation2" value="{{$employee_family->emr_family_relation2}}" class="form-control txtOnly" >

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">


                        <label>Date of birth</label>
                                <input type="text" name="emr_dob" value="{{date('d-m-Y', strtotime($employee_family->emr_dob))}}" class="form-control datetime" >

                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="form-group">

                                <label>Phone</label>
                                <input type="text" name="emr_family_phone" value="{{$employee_family->emr_family_phone}}" class="form-control numberOnly" >
                            </div>
                        </div>
                    </div>

                  </div>
                </div>
            </div>

            <div class="col-md-12 ">
                <div class="card">
                  <div class="card-header"><h4>{{__('Education  Qualification')}}</h4></div>
                    <div class="card-body employee-detail-create-body">
                      <div class="row">
                      <div class="col-md-2">
                      <div class="form-group">
                      <input type="checkbox" class="mr-1 get_qualification" value="Cert" <?php if(in_array("Cert",$employee_qalification1)) {?> checked="checked" <?php }?> name="emp_qualification[]" >
                      <label for="">Cert</label>
                      </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                      <input type="checkbox" class="mr-1 get_qualification" value="CO/A levelert" <?php if(in_array("CO/A levelert",$employee_qalification1)) {?> checked="checked" <?php }?>  name="emp_qualification[]" >
                      <label for="">O/A level</label>
                      </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                      <input type="checkbox" class="mr-1 get_qualification" value="Diploma" <?php if(in_array("Diploma",$employee_qalification1)) {?> checked="checked" <?php }?>  name="emp_qualification[]" >
                      <label for="">Diploma</label>
                      </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                      <input type="checkbox" class="mr-1 get_qualification" value="Degree" <?php if(in_array("Degree",$employee_qalification1)) {?> checked="checked" <?php }?>  name="emp_qualification[]" >
                      <label for="">Degree</label>
                      </div>
                      </div>
                      <div class="col-md-2">
                      <div class="form-group">
                      <input type="checkbox" class="mr-1 get_qualification" value="Others"  <?php if(in_array("Others",$employee_qalification1)) {?> checked="checked" <?php }?> name="emp_qualification[]" >
                      <label for="">Others</label>
                      </div>
                      </div>
                      <div class="col-md-2">
                          <?php if(in_array("Others",$employee_qalification1)) {?>
                          <div class="form-group" id="emp_qal_id">
                          <input type="text" class="form-control" placeholder="If Others Please Specify" value="{{$extra_text['emp_qual_text']}}" name="emp_qual_text">
                          </div>
                          <?php }?>
                      </div>
                      </div>

                    </div>
                  </div>
              </div>
              <div class="col-md-12 ">
                  <div class="card">
                    <div class="card-header"><h4>{{__('License ')}}</h4></div>
                      <div class="card-body employee-detail-create-body">
                        <div class="row">
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="M-bike" <?php if(in_array("M-bike",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]" >
                        <label for="">M-bike</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="Car" <?php if(in_array("Car",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]">
                        <label for="">Car</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="Lorry" <?php if(in_array("Lorry",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]">
                        <label for="">Lorry</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="E-bike" <?php if(in_array("E-bike",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]">
                        <label for="">E-bike</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="Forkli" <?php if(in_array("Forkli",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]">
                        <label for="">Forkli</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="Boat" <?php if(in_array("Boat",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]">
                        <label for="">Boat</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                        <input type="checkbox" class="mr-1 get_license" value="Others" <?php if(in_array("Others",$employee_license1)) {?> checked="checked" <?php }?> name="emp_license[]">
                        <label for="">Others</label>
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <?php if(in_array("Others",$employee_license1)) {?>
                        <div class="form-group"  id="emp_licence_id">
                        <input type="text" class="form-control" placeholder="If Others Please Specify" name="emp_licence_text" value="{{$extra_text['emp_licence_text']}}">
                        </div>
                        <?php }?>
                        </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-12 ">
                  <div class="card">
                    <div class="card-header"><h4>{{__('IT')}}</h4></div>
                      <div class="card-body employee-detail-create-body">

                        <div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="MsOﬃce" <?php if(in_array("MsOﬃce",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">MsOﬃce</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="MYOB" <?php if(in_array("MYOB",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">MYOB</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="AutoCAD" <?php if(in_array("AutoCAD",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">AutoCAD</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="Accounts" <?php if(in_array("Accounts",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">Accounts*</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="ShipDesign" <?php if(in_array("ShipDesign",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">ShipDesign*</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="Programming" <?php if(in_array("Programming",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">Programming*</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="ArtDesign" <?php if(in_array("ArtDesign",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">ArtDesign*</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="VideoEdit" <?php if(in_array("VideoEdit",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">VideoEdit*</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="WebDesign" <?php if(in_array("WebDesign",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">WebDesign*</label>
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="checkbox" class="mr-1 get_technical" value="Others" <?php if(in_array("Others",$employee_it1)) {?> checked="checked" <?php }?> name="emp_technical[]">
                        <label for="">Others</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                    <?php if(in_array("Others",$employee_it1)) {?>
                      <div class="form-group" id="id_get_technical">
                        <input type="text" class="form-control" name="technical_other_text" placeholder="If Others Please Specify" value="{{$extra_text['technical_other_text']}}">
                      </div>
                    <?php }?>
                    </div>

                  </div>
                      </div>
                    </div>
              </div>

        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header"><h4>{{__('Certificates')}}</h4></div>
                <div class="card-body employee-detail-create-body">
                  <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="ISO" <?php if(in_array("ISO",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">ISO</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="WHS Safety" <?php if(in_array("WHS Safety",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">WHS Safety</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="Shipyard Supv" <?php if(in_array("Shipyard Supv",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">Shipyard Supv</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="SSIC" <?php if(in_array("SSIC",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">SSIC</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="Seaman Book" <?php if(in_array("Seaman Book",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">Seaman Book</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="BOSIT" <?php if(in_array("BOSIT",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">BOSIT</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_ertificates" value="Others" <?php if(in_array("Others",$employee_certificates1)) {?> checked="checked" <?php }?> name="emp_ertificates[]">
                      <label for="">Others</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                  <?php if(in_array("Others",$employee_certificates1)) {?>
                    <div class="form-group"  id="id_get_ertificates">
                      <input type="text" class="form-control" placeholder="If Others Please Specify" name="emp_ertificates_text" value="{{$extra_text['emp_ertificates_text']}}">
                    </div>
                  <?php }?>
                  </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="card">
              <div class="card-header"><h4>{{__('Skills')}}</h4></div>
              <div class="card-body employee-detail-create-body">
                <div class="row">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_skills" value="Welding" <?php if(in_array("Welding",$employee_skills1)) {?> checked="checked" <?php }?> name="emp_skills[]">
                      <label for="">Welding*</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_skills" value="Engine" <?php if(in_array("Engine",$employee_skills1)) {?> checked="checked" <?php }?> name="emp_skills[]">
                      <label for="">Engine*</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_skills" value="PLC Prog" <?php if(in_array("PLC Prog",$employee_skills1)) {?> checked="checked" <?php }?> name="emp_skills[]">
                      <label for="">PLC Prog*</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_skills" value="FirstAid" <?php if(in_array("FirstAid",$employee_skills1)) {?> checked="checked" <?php }?> name="emp_skills[]">
                      <label for="">FirstAid*</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_skills" value="Fire" <?php if(in_array("Fire",$employee_skills1)) {?> checked="checked" <?php }?> name="emp_skills[]">
                      <label for="">Fire*</label>
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <input type="checkbox" class="mr-1 get_skills" value="Others" <?php if(in_array("Others",$employee_skills1)) {?> checked="checked" <?php }?> name="emp_skills[]">
                      <label for="">Others</label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <?php if(in_array("Others",$employee_skills1)) {?>
                    <div class="form-group" id="id_get_skills">
                      <input type="text" class="form-control" placeholder="If Others Please Specify" name="emp_skills_text" value="{{$extra_text['emp_skills_text']}}">
                    </div>
                  <?php }?>
                  </div>
                </div>
              </div>
          </div>
      </div>
      <div class="col-md-12 ">
          <div class="card">
            <div class="card-header"><h4>{{__('Experience Informations')}}</h4></div>
            <div class="card-body employee-detail-create-body">
              <div class="row">
              <div class="col-md-6">
              <div class="form-group">


              <label>Company Name</label><span class="text-danger pl-1">*</span>
              <input type="text" name="exp_name" value="{{$employee_experience->exp_name}}" class="form-control txtOnly" required>
              </div>
              </div>
              <div class="col-md-6 ">
              <div class="form-group">


              <label>Location</label>
              <input type="text" name="exp_location" value="{{$employee_experience->exp_location}}" class="form-control" >

              </div>
              </div>
              </div>

              <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">


                  <label>Job Position</label>
                  <input type="text" name="exp_job_position" value="{{$employee_experience->exp_job_position}}" class="form-control txtOnly" >

                  </div>
                  </div>
                  <div class="col-md-6 ">
                  <div class="form-group">

                  <label>Period From</label>
                  <input type="text" name="exp_from" value="{{date('d-m-Y', strtotime($employee_experience->exp_from))}}" class="form-control datetime" >
                  </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                  <div class="form-group">


                  <label>Period To</label>
                  <input type="text" name="exp_to" value="{{date('d-m-Y', strtotime($employee_experience->exp_to))}}" class="form-control datetime" >

                  </div>
                  </div>

              </div>

            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <div class="card">
          <div class="card-header"><h4>{{__('Bank information')}}</h4></div>
          <div class="card-body employee-detail-create-body">
            <div class="row">
            <div class="col-md-6">
            <div class="form-group">


            <label>Bank Name</label><span class="text-danger pl-1">*</span>
            <input type="text" name="bank_name" value="{{$employee_bank->bank_name}}" class="form-control txtOnly" required>
            </div>
            </div>
            <div class="col-md-6 ">
            <div class="form-group">


            <label>Bank Account No.</label><span class="text-danger pl-1">*</span>
            <input type="text" name="bank_account_no" value="{{$employee_bank->bank_account_no}}" class="form-control" required>

            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="form-group">


            <label>Bank Branch Code</label><span class="text-danger pl-1">*</span>
            <input type="text" name="bank_branch_code" value="{{$employee_bank->bank_branch_code}}" class="form-control " required>

            </div>
            </div>
            <div class="col-md-6 ">
            <div class="form-group">

            <label>Unique No.</label><span class="text-danger pl-1">*</span>
            <input type="text" name="unique_no" value="{{$employee_bank->unique_no}}" class="form-control" required>
            </div>
            </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-12 ">
          <div class="card">
            <div class="card-header"><h4>{{__('Basic Salary Information')}}</h4></div>
            <div class="card-body employee-detail-create-body">

                                                    <!-- <div class="row">
                                                    <div class="col-md-4">
                                                    <div class="form-group">


                                                    <label> Salary Basis </label>
                                                            <select class="form-control select2 select2-hidden-accessible"  aria-hidden="true" name="salary_type" required>
                                                                    <option value="">Select salary basis type</option>
                                                                    <option value="Hourly" <?php if($employee_slary->salary_type=="Hourly") echo 'selected="selected"'?>>Hourly</option>
                                                                    <option value="Daily" <?php if($employee_slary->salary_type=="Daily") echo 'selected="selected"'?>>Daily</option>
                                                                    <option value="Weekly" <?php if($employee_slary->salary_type=="Weekly") echo 'selected="selected"'?>>Weekly</option>
                                                                     <option value="Monthly" <?php if($employee_slary->salary_type=="Monthly") echo 'selected="selected"'?>>Monthly</option>
                                                            </select>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-4 ">
                                                    <div class="form-group">


                                                    <label>Salary Amount.</label>
                                                    <input type="text" name="salary_amount" value="{{$employee_slary->salary_amount}}" class="form-control numberOnly" required>

                                                    </div>
                                                    </div>

                                                    <div class="col-md-4 ">
                                                    <div class="form-group">


                                                    <label>Payment Type</label>
                                                    <select class="form-control select2 select2-hidden-accessible" data-select2-id="select2-data-22-3vdp" tabindex="-1" aria-hidden="true" name="payment_type" required>
                                                                    <option value="">Select payment type</option>
                                                                    <option value="Bank transfer" <?php if($employee_slary->payment_type=="Bank transfer") echo 'selected="selected"'?>>Bank transfer</option>
                                                                    <option value="Cheque" <?php if($employee_slary->payment_type=="Cheque") echo 'selected="selected"'?>>Cheque</option>
                                                                    <option value="Cash" <?php if($employee_slary->payment_type=="Cash") echo 'selected="selected"'?>>Cash</option>

                                                            </select>

                                                    </div>
                                                    </div>


                                                    </div> -->

                                                    <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">


                                                        <label> Salary Basis </label><span class="text-danger pl-1">*</span>
                                                                <select class="form-control" data-select2-id="select2-data-22-3vdp" tabindex="-1" aria-hidden="true" name="salary_type" id="salary_type" required>
                                                                        <option value="">Select salary basis type</option>

                                                                    <option value="Hourly" <?php if($employee_slary->salary_type=="Hourly") echo 'selected="selected"'?>>Hourly</option>
                                                                    <option value="Daily" <?php if($employee_slary->salary_type=="Daily") echo 'selected="selected"'?>>Daily</option>

                                                                     <option value="Monthly" <?php if($employee_slary->salary_type=="Monthly") echo 'selected="selected"'?>>Monthly</option>
                                                                </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                             <label>Pay Grade</label><span class="text-danger pl-1">*</span>
                                                            <select class="form-control" name="pay_grade" id="pay_grade" required>

                                                               @if(!empty($employee_all_grade))
                                                                    @foreach($employee_all_grade as $row)
                                                                        <option value="{{$row->id}}" <?php if($employee->pay_grade==$row->id) echo 'selected="selected"'?>>{{$row->grade_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 ">
                                                        <!-- <div class="form-group">


                                                        <label>Salary Amount</label>
                                                        <input type="text" name="salary_amount" value="{{$employee_slary->salary_amount}}" id="salary_amount" class="form-control numberOnly" required readonly>

                                                        </div> -->

                                                        <div class="form-group">
                                                            <label class="">Gross Salary</label><span class="text-danger pl-1">*</span>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">$</span>
                                                                    </div>
                                                                    <input type="text" name="salary_amount" value="{{$employee_slary->salary_amount}}" id="salary_amount" class="form-control numberOnly" required readonly>
                                                                </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3 ">
                                                    <div class="form-group">


                                                    <label>Payment Type</label><span class="text-danger pl-1">*</span>
                                                    <select class="form-control" data-select2-id="select2-data-22-3vdp" tabindex="-1" aria-hidden="true" name="payment_type" required>
                                                                    <option value="">Select payment type</option>
                                                                    <option value="Bank transfer" <?php if($employee_slary->payment_type=="Bank transfer") echo 'selected="selected"'?>>Bank transfer</option>
                                                                    <option value="Cheque" <?php if($employee_slary->payment_type=="Cheque") echo 'selected="selected"'?>>Cheque</option>
                                                                    <option value="Cash" <?php if($employee_slary->payment_type=="Cash") echo 'selected="selected"'?>>Cash</option>

                                                            </select>

                                                    </div>
                                                    </div>


                                                    </div>


                                                  </div>
                                              </div>
                                          </div>


                                          <div class="col-md-12 ">
                                              <div class="card">
                                                <div class="card-header" id="cpf_title"><h4>{{__('CPF Information')}}</h4></div>
                                                <div class="card-body employee-detail-create-body">







                                                  <div class="row">
                                                  <div class="col-md-4">
                                                  <div class="form-group"  id="cpf_contribution_text" @if($employee->emp_type=="Singapore Citizen" || $employee->emp_type=="Permanent Resident")  @else style="display:none" @endif>


                                                  <label>CPF Contribution</label>
                                                  <select class="form-control" name="cpf_contribution" id="cpf_contribution" >
                                                                  <option value="">Select CPF contribution</option>
                                                                  <option value="Yes" <?php if(!empty($employee_cpf->cpf_contribution) && $employee_cpf->cpf_contribution=="Yes") echo 'selected="selected"'?>>Yes</option>
                                                                  <option value="No" <?php if(!empty($employee_cpf->cpf_contribution) && $employee_cpf->cpf_contribution=="No") echo 'selected="selected"'?>>No</option>


                                                          </select>
                                                  </div>
                                                  </div>
                                                      <div class="col-md-4">
                                                          <div class="form-group" id="cpf_no_text"  @if($employee->emp_type=="Singapore Citizen" || $employee->emp_type=="Permanent Resident")  @else style="display:none" @endif>


                                                          <label>CPF No.</label>
                                                          <input type="text" name="cpf_no" value="@if(!empty($employee_cpf->cpf_no)) {{$employee_cpf->cpf_no}} @endif" class="form-control" id="cpf_no" >

                                                          </div>
                                                      </div>

                                                      <div class="col-md-4">
                                                  <div class="form-group" id="emp_cpf_contribution_text"  @if($employee->emp_type=="Singapore Citizen" || $employee->emp_type=="Permanent Resident")  @else style="display:none" @endif>


                                                  <label> Employee CPF Contribution </label>
                                                          <select class="form-control"  name="emp_cpf_contribution" id="emp_cpf_contribution" >
                                                                  <option value="">Select Employee CPF contribution</option>
                                                                  <option value="Yes" <?php if(!empty($employee_cpf->emp_cpf_contribution) &&  $employee_cpf->emp_cpf_contribution=="Yes") echo 'selected="selected"'?>>Yes</option>
                                                                  <option value="No" <?php if(!empty($employee_cpf->emp_cpf_contribution) && $employee_cpf->emp_cpf_contribution=="No") echo 'selected="selected"'?>>No</option>


                                                          </select>

                                                  </div>
                                                  </div>

                                                  </div>
                                                    @php  $get_images=DB::table("employee_documents")->where("employee_id",$employee->id)->get(); @endphp
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <label>Documents Upload</label><span class="text-danger pl-1">*</span>
                                                            <input type="file" name="document_upload[]" id="document_upload" multiple required class="form-control" >
                                                                <em>Upload files only: png,jpg,jpeg,pdf,xlsx,csv</em><br/>
                                                                @if(!empty($get_images))
                                                                @foreach($get_images as $row1)
                                                                <a href="{{asset('public/uploads/document/'.$row1->document_value)}}" class="" target="_blank">{{$row1->document_value}}</a> <a href="javascript:void(0)" onclick="delete_emp_docs({{$row1->id}},{{$employee->id}})" class="" style="color:red;">Remove</a><br/>
                                                                @endforeach
                                                                @endif
                                                        </div>
                                                    </div>





                </div>
            </div>
        </div>









    </div>
{!! Form::submit('Update', ['class' => 'btn btn-success float-right']) !!}
{!! Form::close() !!}

@endsection

@push('script-page')
<script>
// $('.datetime').daterangepicker({

//             singleDatePicker: true,

//             locale: {
//                 format: 'DD-MM-YYYY'
//             }

//         });
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


           // var d_id = $('#department_id').val();
           // getDesignation(d_id);
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
                // $('#emp_type').on('change', function() {
                // var emply_type=$(this).val();

                //     if(emply_type=='Other')
                //     {
                //         $("#emp_type_text").show();
                //     }else
                //     {
                //          $("#emp_type_text").hide();
                //     }

                // });

                // $('#cpf_contribution').on('change', function() {
                // var cpf_type=$(this).val();

                //     if(cpf_type=='No')
                //     {

                //         $("#cpf_no").prop("disabled", true);
                //         $("#emp_cpf_contribution").prop("disabled", true);
                //         $("#additional_rate").prop("disabled", true);
                //         $("#total_rate").prop("disabled", true);

                //     }
                //     else
                //     {
                //         $("#cpf_no").prop("disabled", false);
                //         $("#emp_cpf_contribution").prop("disabled", false);
                //         $("#additional_rate").prop("disabled", false);
                //         $("#total_rate").prop("disabled", false);
                //     }

                // });

                $('#emp_type').on('change', function() {
                var emply_type=$(this).val();

                    if(emply_type=='Other')
                    {
                        $("#emp_type_text").show();
                        $("#emp_type_year").hide();


                        $("#cpf_no_text").hide();
                        $("#cpf_contribution_text").hide();
                        $("#emp_cpf_contribution_text").hide();
                        $("#additional_rate_text").hide();
                        $("#total_rate_text").hide();
                        $("#cpf_title").hide();
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
                        $("#donation_type").val('');

                    }else if(emply_type=='Singapore Citizen')
                    {
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
                    }
                    else
                    {

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
                        $("#donation_type").val('');
                        $("#pass_type").prop('required',true);
                        $("#donation_type").prop('required',false);
                        $("#cpf_title").hide();
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


                    $('.get_license').click(function(){

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
                    });

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





        });



    </script>

<script type="text/javascript">
        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });
        function delete_emp_docs(image_id,docs_id)
{

    if(confirm("Are you sure to delete this document file?"))
    {
        $.ajax({
                url: '{{route('employee.delete_emp_docs')}}',
                type: 'POST',
                data: {
                    "image_id": image_id,"docs_id": docs_id, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {

                   window.location.href=data.docs_id;
                }
            });
    }
    return false;
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
});

    </script>

@endpush
