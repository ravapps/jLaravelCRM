<div class="card-body p-0">
  @if(Session::has('error'))
  <span class="text-danger pl-1">{{ Session::get('error') }}</span><br>
  @endif
  @if($displaytype=='create')
  <form method="post" action="{{route('team_management.store')}}"  id="myform">
  @endif
  @if($displaytype=='edit')
  {{Form::model($team,array('route' => array('team_management.update',$team->id), 'method' => 'PUT', 'id' => 'myform', 'enctype' => 'multipart/form-data')) }}
  @endif
  @csrf
    <div class="row ">

        <div class="col-md-12">
          <div class="form-group">
              <label class="form-label" for="">Team Id</label>
              {!! Form::text('id', $team_id, ['class' => 'form-control','disabled'=>'disabled']) !!}
                @if($displaytype=='edit')<input type="hidden"  name="id" id="id"  value="{{$team->id}}">@endif
          </div>
          <div class="form-group">
              <label class="form-label" for="">Team Name</label>
              <input type="text" name="team_name" id="team_name" required="required" @if($displaytype=='edit') value="{{$team->team_name}}"  @endif   class="form-control">
          </div>
          <div class="form-group">
              <label class="form-label" for="">Supervisor / Service Engineer</label>
              <select required="required" name="supervisor_emp_id" id="supervisor_emp_id" class="select2 form-control" @if($displaytype=='edit') disabled @endif>
                  <option value="">Select Name</option>
                  @if($employees_superviors)
                      @foreach($employees_superviors as $employee)
                      <option value="{{$employee->id}}"  @if($displaytype=='edit') @if($employee->id==$team->supervisor_emp_id) selected='selected'  @endif @endif>{{$employee->first_name}} {{$employee->last_name}}</option>
                      @endforeach
                  @endif
              </select>
              @if($displaytype=='edit')<input type="hidden"  name="supervisor_emp_id" id="supervisor_emp_id"  value="{{$team->supervisor_emp_id}}">@endif
          </div>
          <div class="form-group">
              <label class="form-label" for="">Technicians</label>
              @if($displaytype=='edit')
              @php $workerids = ','; @endphp
              @foreach($team->workers as $work)
                @php  $workerids =   $workerids.$work->worker_emp_id.","; @endphp
              @endforeach
              <!-- {{$workerids}}   {{$employees_workers}}  -->
              @endif

              <select required="required"  name="worker_emp_id[]" id="worker_emp_id[]"  class="select2 form-control" multiple="multiple">
                  <option value="">Select Name</option>
                  <option value="all">All</option>
                  @if($employees_workers)
                      @foreach($employees_workers as $employee)
                      <option value="{{$employee->id}}"  @if($displaytype=='edit')
                          @if(strpos($workerids,','.$employee->id.',') !== false)
                            selected="selected"
                          @endif
                        @endif >{{$employee->first_name}} {{$employee->last_name}}</option>
                      @endforeach
                  @endif
              </select>
          </div>
        </div>
        <div class="modal-footer pr-0">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
            @if($displaytype=='create') {!! Form::submit('Create', ['class' => 'btn btn-success']) !!} @endif
            @if($displaytype=='edit') {!! Form::submit('Update', ['class' => 'btn btn-success']) !!} @endif

        </div>

    </div>
    {!! Form::close() !!}


</div>
