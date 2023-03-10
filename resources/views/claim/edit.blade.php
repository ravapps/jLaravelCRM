@extends('layouts.dashboard')
@section('page-title')
    {{__('Create Claim')}}
@endsection
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="page-title-box-hori">
            <h4 class="page-title">{{__('Edit Claim')}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="{{__('home')}}">{{__('Dashboard')}}</a></li>
                  <li class="breadcrumb-item"><a href="{{route('claim.index')}}">{{__('Claim')}}</a></li>
                  <li class="breadcrumb-item active">{{__('Edit')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<hr class="mt-0">


{{Form::model($claim,array('route' => array('claim.update', $claim->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) }}
    <div class="row">
        <div class="col-md-12 ">
            <div class="card ">
                <!-- <div class="card-header"><h4>{{__('Claim Details')}}</h4></div> -->
                <div class="card-body ">

                    <div class="row">
                      <div class="col-md-3">
                          <div class="form-group" >
                              <label>Claim ID</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="id" value="123" id="" class="form-control" disabled  required>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group" >
                              <label>Claim Date</label><span class="text-danger pl-1">*</span>
                              <input type="text" name="date" value="" id="date" class="form-control datetime"   required>
                          </div>
                      </div>
                        <div class="col-md-3">
                            <div class="form-group">
                               <label>Employee Name</label><span class="text-danger pl-1">*</span>
                                <select name="employee_id" required class="form-control" id="">
                                   <option value="">Select Employee</option>
                                    @if($employees)
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" @if($employee->id==$claim->employee_id) selected='selected' @endif>{{$employee->first_name}} {{$employee->last_name}}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                                <div class="form-group" >
                                    <label>Claim Name</label><span class="text-danger pl-1">*</span>

                                    <input type="text" name="title" value="{{$claim->title}}" id="title" class="form-control"   required>
                                </select>
                                </div>
                        </div>
                        <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label>Amount</label><span class="text-danger pl-1">*</span>
                                <input type="text" name="amount" value="{{$claim->amount}}" id="amount" class="form-control"   required>
                                </div>
                        </div> -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label><span class="text-danger pl-1">*</span>
                                      <select name="status"  class="form-control" id="status">
                                            <option value="">Select Status</option>
                                            <option value="Pending" @if($claim->status=="Pending") selected='selected' @endif>Pending</option>
                                            <option value="Approved" @if($claim->status=="Approved") selected='selected' @endif>Approved</option>

                                        </select>
                                </div>
                        </div>

                    </div>

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTables_wrapper claim-table" id="items">
                                <thead>
                                    <tr>
                                      <th class="text-left">Item Name</th>
                                      <!-- <th class="text-center">Account Code</th> -->
                                      <th class="text-left">Quantity</th>
                                      <th class="text-right">Price</th>
                                      <th class="text-left">Tax/GST</th>
                                      <th class="text-right">Nett Total</th>
                                      <th class="text-left">Description</th>
                                      <th class="text-left">Attachment</th>
                                      <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  id="item-row-0">
                                        <td class="text-left typeahead-wrap">
                                            <!-- <select class="form-control typeahead select2">
                                              <option value="">Select Item Name</option>
                                              <option value="">WORKERS WORK PASS APPLICATION FEE</option>
                                              <option value="">ENCASH</option>
                                              <option value="">RECRUITMENT - DATA PASSPORT + USAGE</option>
                                            </select> -->
                                            <input type="text" name="" class="form-control typeahead" value="">
                                        </td>
                                        <!-- <td class="typeahead-wrap">
                                          <select class="form-control typeahead select2">
                                            <option value="">Select Account</option>
                                            <option value="">Account A</option>
                                            <option value="">Account B</option>
                                            <option value="">Account C</option>
                                          </select>
                                        </td> -->
                                        <td class="text-left typeahead-wrap">
                                            <input type="text" value="" class="form-control w-80px">
                                        </td>
                                        <td class="text-left typeahead-wrap">
                                            <input type="text" value="" class="form-control w-80px">
                                        </td>
                                        <td class="typeahead-wrap">
                                          <td class="typeahead-wrap">
                                              <select id="item-tax-0" class="form-control typeahead select2">
                                                <option value="">- Select Payable -</option>
                                                <option value="7">Yes</option>
                                                <option value="8">No</option>
                                              </select>
                                          </td>
                                        </td>
                                        <td class="text-center typeahead-wrap">
                                            <span id="item-total-0">0</span>
                                        </td>
                                        <td class="text-left typeahead-wrap">
                                            <textarea class="form-control custom-textarea" placeholder="Description"></textarea>
                                        </td>
                                        <td class="text-left typeahead-wrap">
                                            <input type="file" value="" class="form-control">
                                        </td>
                                        <td class="text-center typeahead-wrap">
                                            <button type="button" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete" onclick="$('.tooltip').remove(); $('#item-row-0').remove(); totalItem();">
                                              <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr id="addItem">
                                        <td colspan="9" class="text-center">
                                          <button type="button" onclick="addItem();" data-toggle="tooltip" title="" class="btn btn-xs btn-success" data-original-title="Add">
                                            <i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="payment-options row">
                          <div class="col-sm-8"></div>
                          <div class="col-sm-4">
                            <table class="table no-border">
                              <tbody>
                                <tr>
                                    <td class="text-right" style="width: 50%;"><strong>Gross Total</strong></td>
                                    <td class="text-right" style="width: 50%;"><span id="sub-total">0</span></td>
                                </tr>
                                <!-- <tr>
                                    <td class="text-right"><strong>Discount</strong></td>
                                    <td class="text-right">
                                        <span id="discount-total"></span>
                                        <input id="discount" class="form-control text-right" name="discount" type="hidden">
                                        <input id="discount_type" class="form-control text-right" name="discount_type" type="hidden" value="percentage">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td class="text-right"><strong>Tax Total</strong></td>
                                    <td class="text-right"><span id="tax-total">0</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>Nett Total</strong></td>
                                    <td class="text-right"><span id="grand-total">0</span></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                               <label>Remark</label><span class="text-danger pl-1">*</span>
                              <textarea name="remark" class="form-control" >{{$claim->remark}}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                               <label>Upload Documents</label>
                             <input type="file" name="documents[]" class="form-control">
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                               {!! Form::submit('Update', ['class' => 'btn btn-success float-right']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

{!! Form::close() !!}

@push('script-page')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

// tinymce.init({
//       selector: '.custom-textarea',
//       height: 100,
//       menubar: false,
//       plugins: [
//         'lists',
//         'code',
//         'table contextmenu paste code'
//       ],
//       toolbar: 'code',
// });
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

var item_row = 1;
function addItem() {
    html  = '<tr id="item-row-' + item_row + '">';

    html += '  <td class="text-left typeahead-wrap">';
    // html += '      <select class="form-control select2 typeahead" required="required" placeholder="Enter Item Name" name="item[' + item_row + '][name]" type="text" id="item-name-' + item_row + '" autocomplete="off"><option value="" data-select2-id="select2-data-12-l79h">Select Item Name</option><option value="">WORKERS WORK PASS APPLICATION FEE</option><option value="">ENCASH</option><option value="">RECRUITMENT - DATA PASSPORT + USAGE</option></select>';
    html += '      <input name="item[' + item_row + '][item_id]"  class="form-control typeahead" type="text" id="item-id-' + item_row + '">';
    html += '      <input name="item[' + item_row + '][item_id]" type="hidden" id="item-id-' + item_row + '">';
    html += '  </td>';
    // html += '  <td class="text-left typeahead-wrap">';
    // html += '      <select class="form-control select2 typeahead" name="item[' + item_row + '][de_account_id]" id="item-de-account-' + item_row + '">';
    // html += '         <option selected="selected" value="">- Select Account -</option>';
		// html += '         <option value="34">Account A</option>';
		// html += '         <option value="35">Account B</option>';
		// html += '         <option value="36">Account C</option>';
    // html += '      </select>';
    // html += '  </td>';
    html += '  <td class="text-left typeahead-wrap">';
    html += '      <input class="form-control w-80px" required="required" name="item[' + item_row + '][quantity]" type="text" id="item-quantity-' + item_row + '">';
    html += '  </td>';
    html += '  <td class="text-left typeahead-wrap">';
    html += '      <input class="form-control curr_amt w-80px" required="required" name="item[' + item_row + '][price]" type="text" id="item-price-' + item_row + '">';
    html += '  </td>';
    html += '  <td class="text-left typeahead-wrap">';
    html += '      <select class="form-control select2 typeahead" name="item[' + item_row + '][tax_id]" id="item-tax-' + item_row + '">';
    html += '         <option selected="selected" value="">- Select Payable -</option>';
    html += '         <option value="1">Yes</option>';
    html += '         <option value="7">No</option>';
    html += '      </select>';
    html += '  </td>';
    html += '  <td class="text-center typeahead-wrap"';
    html += '      <span id="item-total-' + item_row + '">0</span>';
    html += '  </td>';
    html += '  <td class="text-left typeahead-wrap">';
    html += '  <textarea class="form-control custom-textarea" placeholder="Description" name="item[' + item_row +'][description]" id="item-description-' + item_row + '" autocomplete="off"></textarea>';
    html += '  </td>';
    html += '  <td class="text-left typeahead-wrap">';
    html += '  <input type="file" value="" class="form-control">';
    html += '  </td>';
    html += '  <td class="text-center typeahead-wrap">';
    html += '      <button type="button" onclick="$(\'.tooltip\').remove(); $(\'#item-row-' + item_row + '\').remove(); totalItem();" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';
    html += '  </td>';

    $('#items tbody #addItem').before(html);

    $('[data-toggle="tooltip"]').tooltip('hide');
    $('.select2').select2();

    // tinymce.init({
    //   selector: '.custom-textarea',
    //   height: 100,
    //   menubar: false,
    //   plugins: [
    //     'lists',
    //     'code',
    //     'table contextmenu paste code'
    //   ],
    //   toolbar: 'code',
    // });

    item_row++;
};

</script>
@endpush
@endsection
