@extends('layouts.dashboard')
@section('page-title')
    {{__('Team Management')}}
@endsection
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="page-title-box-hori">
            <h4 class="page-title">{{__('Team List')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="{{__('home')}}">{{__('Dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{__('Team List')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@if(Session::has('error'))
<span class="text-danger pl-1">{{ Session::get('error') }}</span><br>
@endif
<hr class="mt-0 mb-2">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>{{--__('Team List')--}}</h4>
                    <a href="#" data-url="{{ route('team_management.create') }}" class="btn btn-icon icon-left btn-success" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Create New Team')}}" data-original-title="{{__('Create New Team')}}">
                        <i class="fa fa-plus"></i> {{__('Create')}}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dataTable table-striped mb-0">
                        <thead>
                            <tr class="bg-transparent">
                                <th>S.N.</th>
                                <th>Team ID</th>
                                <th>Team Name</th>
                                <!-- <th>Team Manager</th> -->
                                <th>Supervisor / Service Engineer</th>
                                <th>Workers / Technicians</th>
                                <th class="no-sort" style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php $number = 0;@endphp
                          @foreach ($get_teams as $row)
                          @php $number++; //var_dump($row->supervisor);//$get_employee=DB::table("employees")->where("id",$row->employee_id)->first();@endphp
                            <tr>
                                <td>{{$number}}</td>
                                <td><a href="javascript:void(0);">{{$row->id}}</a> </td>
                                <td>{{$row->team_name}}</td>
                                <td>{{$row->supervisor->first_name}} {{$row->supervisor->last_name}}</td>
                                <td>
                                  <a href="javascript:;" data-toggle="modal" data-target="#myModal{{$number}}">{{$row->workers->count()}}</a>
                                </td>

                                <td class="text-right">
                                  <div class="d-flex">
                                    <a href="javascript:;" data-url="{{ URL::to('team_management/'.$row->id.'/edit') }}" class="btn btn-outline-success" data-ajax-popup="true" data-toggle="tooltip" data-title="{{__('Edit Team')}}" data-original-title="{{__('Edit Team')}}"><i class="fas fa-pencil-alt"></i> <span>{{__('Edit')}}</span></a>

                                    <a href="#" class="btn btn-outline-danger " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$row->id}}').submit();"><i class="fas fa-trash"></i> <span>{{__('Delete')}}</span></a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['team_management.destroy', $row->id],'id'=>'delete-form-'.$row->id]) !!}
                                    {!! Form::close() !!}


                                  </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@php $number = 0;@endphp
@foreach ($get_teams as $row)
@php $number++; //var_dump($row->supervisor);//$get_employee=DB::table("employees")->where("id",$row->employee_id)->first();@endphp
<div id="myModal{{$number}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog large">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Workers/Technicians</h5>
                    <button type="button" class=" btn btn-defult text-white btn-sm" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="table-responsive dataTables_wrapper">
                      <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th>Employee ID</th>
                                  <th>Image</th>
                                  <th>Employee Name</th>
                              </tr>
                          </thead>

                          <tbody>
                            @foreach ($row->workers as $item)
                              <tr>
                                  <td>{{$item->worker_emp_id}}</td>
                                  <td><img src="{{url('public/assets/img/avatar/avatar-1.png')}}" alt="" class="rounded avatar-sm"></td>
                                  <td>{{$item->worker->first_name}} {{$item->worker->last_name}}</td>
                              </tr>
                              @endforeach

                          </tbody>
                      </table>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button> -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endforeach
@endsection
