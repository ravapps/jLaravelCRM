{{Form::model($jbr,array('route' => array('jbr.update', $jbr->id), 'method' => 'PUT')) }}
  <div class="card-body p-0">
      <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                {{ Form::label('department_id', __('Department')) }}
                {{ Form::select('department_id', $departments,null, array('class' => 'form-control select2','required'=>'required')) }}
              </div>
              <div class="form-group">

                {{Form::label('Responsbilites Name',__('Responsbilites Name'))}}
                {{Form::text('res_name',null,array('class'=>'form-control','placeholder'=>__('Enter Responsbilites')))}}
                @error('name')

                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror


                <label for="department_id">Upload Responsbilites Excel</label>
                <input type="file" name="" value="" class="form-control">
                <a href="#" class="w-100 mt-2"><small>Download sample excel file</small></a>
              </div>
              <div class="form-group">
                <label for="department_id">Last Uploaded Excel</label>
                <div class="d-flex space-between">
                  <a href="#" class="w-100"><small>CleaningExcel.xls</small></a>
                  <a href="#" class="ml-2 text-danger"><small><i class="fa fa-times"></i></small></a>
                </div>
              </div>
          </div>
      </div>
  </div>
  <div class="modal-footer pr-0">
      <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{__('Cancel')}}</button>
      {{Form::submit(__('Update'),array('class'=>'btn btn-success'))}}
  </div>
{{Form::close()}}
