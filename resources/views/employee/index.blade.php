@extends('layouts.dashboard')
@section('page-title')
    {{__('Employee')}}
@endsection
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="page-title-box-hori">
            <h4 class="page-title">{{__('Manage Employee')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{__('home')}}">{{__('Dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{__('Employee')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h4 class="header-title mb-0">{{--__('Manage Employee')--}}</h4>
                    <div>
                      @can('Create Employee')
                          <a href="{{ route('employee.create') }}" class="btn btn-icon icon-left btn-success">
                              <i class="fa fa-plus"></i> {{ __('Create') }}
                          </a>
                      @endcan
                      <a href="javascript:void(0)" class="btn btn-icon icon-left btn-success" data-toggle="modal" data-target="#myModal">
                          <i class="fa fa-plus"></i> {{ __('Set Salary Date') }}
                      </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

            <form action="{{route('employee.index')}}" methode="get">
              <div class="row">
                  <div class="col">
                      <div class="form-group">
                         <label>Employee Name</label><span class="text-danger pl-1">*</span>
                         <input type="text" name="emp_name" value="" class="form-control"  required>
                      </div>
                  </div>
                  <div class="col" >
                      <div class="form-group">
                         <label>Department</label><span class="text-danger pl-1">*</span>
                         <select name="department_id" required class="form-control" id="department_id" required>
                              <option value="">Select Department</option>
                              @if(!empty($departments))
                                  @foreach($departments as $department)
                                      <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endforeach
                              @endif
                          </select>
                      </div>
                  </div>

                  <div class="col">
                      <div class="form-group">
                         <label>Designation</label><span class="text-danger pl-1">*</span>
                         <select name="designation_id" required class="form-control" id="designation_id" required>
                              <option value="">Select Designation</option>
                              @if(!empty($designations))
                                  @foreach($designations as $designation)
                                      <option value="{{$designation->id}}">{{$designation->name}}</option>
                                  @endforeach
                              @endif
                          </select>
                      </div>
                  </div>
                  <div class="col-auto">
                      <div class="form-group">
                        <label class="w-100">&nbsp;</label>
                      {{Form::submit(__('Apply'),array('class'=>'btn btn-success'))}}
                        <a href="{{route('employee.index')}}" class="btn btn-danger">{{__('Reset')}}</a>
                      </div>
                  </div>
              </div>
            </form>

                <div class="table-responsive no-header">
                    <table class="table table-striped mb-0" id="dataTable">
                        <thead>
                          <tr>
                              <th>{{__('Employee ID')}}</th>
                              <th>{{__('Photo')}}</th>
                              <th>{{__('Name')}}</th>
                             <th>{{__('Department') }}</th>
                              <th>{{__('Phone') }}</th>
                              <th>{{__('Employee Type') }}</th>
                              <th>{{__('Date Of Joining') }}</th>
                              <th>{{__('Employment Letter') }}</th>
                              <th>{{__('KET Letter') }}</th>

                              @if(Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                                  <th class="text-right">{{__('Action')}}</th>
                              @endif
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($employees as $employee)


                            <tr>
                                <td>
                                    @can('Show Employee')
                                        <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn  btn-success">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                    @else
                                        <a href="#" class="btn  btn-success">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                                    @endcan
                                </td>

                                <td> <img src="{{asset('public/uploads/document/')}}/{{$employee->documents}}" style="width:50px;"></td>
                                <td class="font-style">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td class="font-style">{{!empty(\Auth::user()->getDepartment($employee->department_id ))?\Auth::user()->getDepartment($employee->department_id )->name:''}} <br/>Designation :{{!empty(\Auth::user()->getDesignation($employee->designation_id ))?\Auth::user()->getDesignation($employee->designation_id )->name:''}}</td>
                                <td class="font-style">{{$employee->phone}}</td>
                                <td class="font-style">{{$employee->emp_type}}</td>

                                <td class="font-style">{{ \Auth::user()->dateFormat($employee->company_doj )}}</td>
                                <td class="font-style"><a href="#">Generate Employment Letter</a></td>
                                <td class="font-style"><a href="{{route('employee.ket')}}">KET Letter</a></td>


                                @if(Gate::check('Edit Employee') || Gate::check('Delete Employee') || Gate::check('Manage Leave Employee'))
                                    <td class="text-right">


                                        @if($employee->is_active==1)
                                        @can('Manage Leave Employee')
                                          <a href="{{route('manage_leave_employee.show',$employee->id)}}" class="btn btn-outline-success  mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Manage Leave')}}</span></a>
                                          <!-- <a href="{{ URL::to('manage_leave_employee/'.\Illuminate\Support\Facades\Crypt::encrypt($employee->id).'/index') }}" class="btn btn-outline-success  mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Manage Leave')}}</span></a> -->
                                          <!-- <a href="{{url('show_salary_date')}}/{{$employee->id}}" class="btn btn-outline-success  mr-1" ><i class="fas fa-pencil-alt"></i> <span>{{__('Set Employee Salary Date')}}</span></a> -->
                                         @endcan
                                            @can('Edit Employee')
                                                {{--<a href="{{ URL::to('employee/'.$employee->id.'/edit') }}" class="btn btn-outline-success  mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>--}}
                                                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-outline-success  mr-1"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>
                                            @endcan
                                            @can('Delete Employee')
                                                <a href="#" class="btn btn-outline-danger " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        @else
                                            <i class="fas fa-lock"></i>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>












    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Set Salary</h4>
        </div>

        @php $data_range=range(1,31);@endphp
        @if(empty($emp_set_date))
          <form action="{{url('set_salary_date')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>From</label><span class="text-danger pl-1">*</span>
                            <select name="from_d" required class="form-control" id="from_d">
                            <option value="">Select From</option>
                            @foreach($data_range as $row)
                                <option value="{{$row}}">{{$row}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slot</label><span class="text-danger pl-1">*</span>
                            <select name="to_d" required class="form-control" id="to_d">
                            <option value="">Select Slot</option>
                            @foreach($data_range as $row)
                                <option value="{{$row}}">{{$row}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" >{{__('Save')}}</button>
            </div>
          <form>
        @else
          <form action="{{url('set_salary_date')}}" method="post">
            @csrf
            <div class="modal-body">
              <input type="hidden" name="set_salry_d" value="{{$emp_set_date->id}}">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>From</label><span class="text-danger pl-1">*</span>
                          <select name="from_d" required class="form-control" id="from_d">
                          <option value="">Select From</option>
                          @foreach($data_range as $row)
                              <option value="{{$row}}" @if($emp_set_date->from_d==$row) selected="selected" @endif>{{$row}}</option>
                          @endforeach
                      </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Slot</label><span class="text-danger pl-1">*</span>
                          <select name="to_d" required class="form-control" id="to_d">
                          <option value="">Select Slot</option>
                          @foreach($data_range as $row)
                              <option value="{{$row}}" @if($emp_set_date->to_d==$row) selected="selected" @endif>{{$row}}</option>
                          @endforeach
                      </select>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" >{{__('Save')}}</button>
            </div>
          <form>
        @endif
      </div>

    </div>
  </div>







@endsection
@push('script-page')
<script>
$(document).ready(function(){
        $("#get_emp_info").on("click",function(){
            var emp_sal_id  = $(this).attr("data-emp_sal_id");
            var emp_from_d  =$(this).attr("data-emp_from_d");
            var emp_to_d    =$(this).attr("data-emp_to_d");
            var emp_c_d     =$(this).attr("data-emp_c_d");
           if(emp_c_d=='')
           {
               $("#emp_sal_id").val(emp_sal_id);
           }
           else
           {
            $("#emp_c_d").val(emp_c_d);
            $("#emp_sal_id").val(emp_sal_id);
            $("#emp_from_d").val(emp_from_d);
            $("#emp_to_d").val(emp_to_d);
           }
    });
});
</script>
@endpush
