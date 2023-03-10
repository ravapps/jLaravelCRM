<div class="panel panel-primary">
    <div class="panel-body">
        @if (isset($company))
            {!! Form::model($company, ['url' => $type . '/' . $company->id, 'method' => 'put', 'files'=> true, 'id'=>'company']) !!}
        @else
            {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'company']) !!}
        @endif
            <div class="form-group required {{ $errors->has('company_avatar_file') ? 'has-error' : '' }}">
                {!! Form::label('company_avatar_file', trans('company.company_avatar'), ['class' => 'control-label hide']) !!}
                <div class="controls row" v-image-preview>
                    <div class="col-sm-12">
                        <div class="fileinput fileinput-new hide" data-provides="fileinput" style="display:none;">
                            <div class="fileinput-preview thumbnail form_Blade" data-trigger="fileinput">
                                <img id="image-preview" width="300" class="img-responsive">
                                @if(isset($company->company_avatar) && $company->company_avatar!="")
                                    <img src="{{ url('uploads/company/thumb_'.$company->company_avatar) }}"
                                         alt="Image" class="img-responsive" width="300">
                                @endif
                            </div>
                            <div class="m-t-10">
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">{{trans('dashboard.select_image')}}</span>
                                    <span class="fileinput-exists">{{trans('dashboard.change')}}</span>
                                    <input type="file" name="company_avatar_file">
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists"
                                   data-dismiss="fileinput">{{trans('dashboard.remove')}}</a>
                            </div>
                            <span class="help-block">{{ $errors->first('company_avatar_file', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', trans('company.company_name'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Customer name','id'=>'name']) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('website') ? 'has-error' : '' }}">
                        {!! Form::label('website', trans('company.website'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('website', null, ['class' => 'form-control','placeholder'=>'Website Eg- http://www.domain.com']) !!}
                            <span class="help-block">{{ $errors->first('website', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', trans('company.phone'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('phone', null, ['class' => 'form-control','data-fv-integer' => "true",'placeholder'=>'Phone']) !!}
                            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        {!! Form::label('mobile', trans('company.mobile'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('mobile', null, ['class' => 'form-control','data-fv-integer' => "true",'placeholder'=>'Mobile No.']) !!}
                            <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <h3>Addresses</h3>
            </div>
            {{--<!--<div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                        {!! Form::label('country_id', trans('company.country'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('country_id', $countries, null, ['id'=>'country_id', 'class' => 'form-control select2']) !!}
                            <span class="help-block">{{ $errors->first('country_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('state_id') ? 'has-error' : '' }}">
                        {!! Form::label('state_id', trans('company.state'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('state_id', isset($company)?$states:[0=>trans('company.select_state')], null, ['id'=>'state_id', 'class' => 'form-control select2']) !!}
                            <span class="help-block">{{ $errors->first('state_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group required {{ $errors->has('city_id') ? 'has-error' : '' }}">
                        {!! Form::label('city_id', trans('company.city'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('city_id', isset($company)?$cities:[0=>trans('company.select_city')], null, ['id'=>'city_id', 'class' => 'form-control select2']) !!}
                            <span class="help-block">{{ $errors->first('city_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
           <div class="row">
               <div class="col-md-12">
                   <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                       {!! Form::label('address', trans('company.address'), ['class' => 'control-label required']) !!}
                       <div class="controls">
                           {!! Form::textarea('address', null, ['class' => 'form-control resize_vertical','placeholder'=>'Address']) !!}
                           <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                       </div>
                   </div>
               </div>
           </div>-->--}}
           <div class="row">
              <div class="col-md-12 compShow">
                <h3 class="section-heading">Office Address</h3>
              </div>
              <div class="col-md-3">
                  <div class="form-group required {{ $errors->has('postalcode') ? 'has-error' : '' }}">
                      <label class="control-label required" for="">Postal Code</label>
                      <div class="input-group">

                        {!! Form::text('mpostalcode', null, ['class' => 'form-control','placeholder'=>'Postal Code','id'=>'mpostalcode']) !!}
                        <span class="input-group-text">
                          <i class="fa fa-search"></i>
                        </span>
                      </div>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group required {{ $errors->has('street') ? 'has-error' : '' }}">
                      <label class="control-label required" for="">Street Name</label>
                      {!! Form::text('mstreet', null, ['class' => 'form-control','placeholder'=>'Street Name','id'=>'mstreet']) !!}

                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group required {{ $errors->has('building') ? 'has-error' : '' }}">
                      <label class="control-label required" for="">Building Name</label>
                      {!! Form::text('mbuilding', null, ['class' => 'form-control','placeholder'=>'Building Name','id'=>'mbuilding']) !!}

                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group required {{ $errors->has('unitnofrom') ? 'has-error' : '' }}">
                      <label class="control-label required" for="">Unit No.</label>
                      <div class="input-group">

                        {!! Form::text('munitnofrom', null, ['class' => 'form-control','placeholder'=>'Floor/Unit No.','required'=>'required','id'=>'munitnofrom']) !!}
                        <span class="input-group-text">
                          <i class="fa fa-minus"></i>
                        </span>

                        {!! Form::text('munitnoto', null, ['class' => 'form-control','placeholder'=>'Floor/Unit No.']) !!}
                      </div>
                  </div>
              </div>
           </div>
           <div class="row">
              <div class="col-md-12 mb-2 compShow">
                <h3 class="section-heading">{{trans('company.br_add')}}</h3>
              </div>
           </div>
           <div>
             <span class="help-block">{{ $errors->first('groupbranch.*.sitelocation', ':message') }}</span>
             <span class="help-block">{{ $errors->first('groupbranch.*.postalcode', ':message') }}</span>
             <span class="help-block">{{ $errors->first('groupbranch.*.branchcategory', ':message') }}</span>
             <span class="help-block">{{ $errors->first('groupbranch.*.contact', ':message') }}</span><br>

           </div>
           <div class="repeater mb-4">
              <div data-repeater-list="groupbranch">


                  @if(!empty($company))
                  <!--- Repeater edit form row begin --->
                  @foreach($company->companybranches as $ite)
                  <div data-repeater-item class="repeater-row no-border">
                    <div class="row">
                      <div class="col">

                        <div class="row">

                          <div class="col-md-3">
                              <div class="form-group required {{ $errors->has('postalcode') ? 'has-error' : '' }}">
                                  <label class="control-label required" for="">Postal Code</label>
                                  <div class="input-group">
                                    {!! Form::hidden('siteid', $ite->id, ['required'=>'required']) !!}
                                    {!! Form::text('postalcode', $ite->postalcode, ['class' => 'form-control','placeholder'=>'Postal Code','required'=>'required']) !!}
                                    <span class="input-group-text">
                                      <i class="fa fa-search"></i>
                                    </span>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-3">

                              <div class="form-group required {{ $errors->has('groupbranch.0.sitelocation') ? 'has-error' : '' }}">
                                  <label class="control-label required" for="">Site Location</label>
                                  {!! Form::text('sitelocation', $ite->sitelocation, ['class' => 'form-control','placeholder'=>'Site Location','required'=>'required']) !!}
                              </div>

                          </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" for="">Street Name</label>
                                  {!! Form::text('street', $ite->street, ['class' => 'form-control','placeholder'=>'Street Name']) !!}
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" for="">Building Name</label>
                                  {!! Form::text('building', $ite->building, ['class' => 'form-control','placeholder'=>'Building Name']) !!}

                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" for="">Unit No.</label>
                                  <div class="input-group">

                                    {!! Form::text('unitnofrom', $ite->unitnofrom, ['class' => 'form-control','placeholder'=>'Unit From']) !!}
                                    <span class="input-group-text">
                                      <i class="fa fa-minus"></i>
                                    </span>
                                    {!! Form::text('unitnoto',  $ite->unitnoto, ['class' => 'form-control','placeholder'=>'Unit To']) !!}

                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label required" for="">{{trans('company.br_type')}}</label>
                                  {!! Form::select('branchcategory', $categories, $ite->branchcategory, ['class' => 'form-control bc','required'=>'required']) !!}

                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label required" for="">Contact Person</label>

                                  {!! Form::text('contact',  $ite->contact, ['class' => 'form-control','placeholder'=>'Contact Person','required'=>'required']) !!}
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" name="mobile" for="">Mobile No.</label>

                                  {!! Form::text('mobile', $ite->mobile, ['class' => 'form-control','placeholder'=>'Mobile No.']) !!}
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-auto">
                          <div class="form-group text-right">
                              <label class="form-label" for="">&nbsp;</label>
                              <input data-repeater-delete type="button" class="btn btn-danger btn-block" value="-">
                          </div>
                      </div>
                    </div>
                    <hr>
                  </div>
                  @endforeach
                  <!--- Repeater edit form row end --->
                  @else
                  <!--- Repeater add form row start --->
                  <div data-repeater-item class="repeater-row no-border">
                    <div class="row">
                      <div class="col">

                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group required {{ $errors->has('postalcode') ? 'has-error' : '' }}">
                                  <label class="control-label required" for="">Postal Code</label>
                                  <div class="input-group">
                                    {!! Form::text('postalcode', null, ['class' => 'form-control','placeholder'=>'Postal Code','required'=>'required']) !!}
                                    <span class="input-group-text">
                                      <i class="fa fa-search"></i>
                                    </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">

                              <div class="form-group required {{ $errors->has('groupbranch.0.sitelocation') ? 'has-error' : '' }}">
                                  <label class="control-label required" for="">Site Location</label>
                                  {!! Form::text('sitelocation', null, ['class' => 'form-control','placeholder'=>'Site Location','required'=>'required']) !!}
                              </div>

                          </div>

                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" for="">Street Name</label>
                                  {!! Form::text('street', null, ['class' => 'form-control','placeholder'=>'Street Name']) !!}
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" for="">Building Name</label>
                                  {!! Form::text('building', null, ['class' => 'form-control','placeholder'=>'Building Name']) !!}

                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" for="">Unit No.</label>
                                  <div class="input-group">

                                    {!! Form::text('unitnofrom', null, ['class' => 'form-control','placeholder'=>'Floor/Unit From']) !!}
                                    <span class="input-group-text">
                                      <i class="fa fa-minus"></i>
                                    </span>
                                    {!! Form::text('unitnoto', null, ['class' => 'form-control','placeholder'=>'Floor/Unit To']) !!}

                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label required" for="">{{trans('company.br_type')}}</label>
                                  {!! Form::select('branchcategory', $categories, null, ['class' => 'form-control bc','required'=>'required']) !!}

                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label required" for="">Contact Person</label>

                                  {!! Form::text('contact', null, ['class' => 'form-control','placeholder'=>'Contact Person','required'=>'required']) !!}
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label class="control-label" name="mobile" for="">Mobile No.</label>

                                  {!! Form::text('mobile', null, ['class' => 'form-control','placeholder'=>'Mobile No.']) !!}
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-auto">
                          <div class="form-group text-right">
                              <label class="form-label" for="">&nbsp;</label>
                              <input data-repeater-delete type="button" class="btn btn-danger btn-block" value="-">
                          </div>
                      </div>
                    </div>
                    <hr>
                  </div>
                  <!--- Repeater add form row emd --->
                  @endif



              </div>
              <div class="row">
                <div class="col-md-12">
                  <input data-repeater-create id="repeater-button" type="button" class="btn btn-success mt-3 float-end" value="+"/>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
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
                </div>
            </div>
        {!! Form::hidden('latitude', null, ['class' => 'form-control', 'id'=>"latitude"]) !!}
        {!! Form::hidden('longitude', null, ['class' => 'form-control', 'id'=>"longitude"]) !!}
        {!! Form::close() !!}
    </div>
</div>
@section('scripts')
    <!-- <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}&libraries=places"></script>  --->
    <script>
    // https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:1441|country:PH&key=YOUR_API_KEY
    // https://maps.googleapis.com/maps/api/place/details/json?fields=address_components%2Cadr_address%2Cformatted_phone_number&place_id=ChIJrUZSChQ92jER71O1DzII9Zo&key=AIzaSyDIhiJfDpWqZ-bVOJEtCcCNaYtONs2lUuk
    // https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:521147|country:SG&key=AIzaSyDIhiJfDpWqZ-bVOJEtCcCNaYtONs2lUuk
    // https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:310145|country:SG&key=AIzaSyDIhiJfDpWqZ-bVOJEtCcCNaYtONs2lUuk

        $(document).ready(function () {
            $("#company").bootstrapValidator({
                fields: {
                    company_avatar_file: {
                       validators:{
                           file: {
                               extension: 'jpeg,jpg,png',
                               type: 'image/jpeg,image/png',
                               maxSize: 1000000,
                               message: 'The logo format must be in jpeg, jpg or png and size less than 1MB'
                           }
                       }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'The company name field is required.'
                            },
                            stringLength: {
                                min: 3,
                                message: 'The company name must be minimum 3 characters.'
                            }
                        }
                    },
                    website: {
                        validators: {
                            notEmpty: {
                                message: 'The company website field is required.'
                            },
                            uri: {
                                allowLocal: true,
                                message: 'The input is not a valid URL'
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
                    mpostalcode: {
                        validators: {
                            notEmpty: {
                                message: 'The main postalcode is required.'
                            }

                        }
                    },
                    mstreet: {
                        validators: {
                            notEmpty: {
                                message: 'The main street is required.'
                            }

                        }
                    },
                    mbuilding: {
                        validators: {
                            notEmpty: {
                                message: 'The main building is required.'
                            }

                        }
                    },
                    'groupbranch[]postalcode': {
                       validators: {
                        notEmpty: {
                            message: 'The option required and cannot be empty'
                        }
                      }
                    },
                    munitnofrom: {
                        validators: {
                            notEmpty: {
                                message: 'The main unit from is required.'
                            }

                        }
                    }
                }
            });
            $(".fileinput").find('input').change(function () {
                button_disabled();
                $("input").on("keyup",function(){
                    button_disabled();
                });
            });
            /* $( "input[data-bv-field='postalcode']" ).blur(function() {
              console.log($(this).attr('name'));
              if($(this).val() != '')
              getgeocode($(this).val());
            }); */
            $(document).on('blur', '.form-control', function() {
              var j = $(this).attr('name');
              var k = $(this).val();
              var l = $(this).attr('name');
              console.log(j.includes("[postalcode]"));
              if(j.includes("[postalcode]")) {
                if($(this).val() != '')
                getgeocode(k,l.replace("[postalcode]", "[sitelocation]"));
              }
              if(j.includes("mpostalcode")) {
                if($(this).val() != '')
                getmaingeocode(k);
              }

            });


            @php $appkey = "AIzaSyDIhiJfDpWqZ-bVOJEtCcCNaYtONs2lUuk"; @endphp
            var lat = '';
            var lng = '';
            function getgeocode(id,nm){
                var addr = $('#name').val();
                addr = addr.replace('', '+');
                $.ajax({
                    type: "GET",
                    url: 'https://maps.googleapis.com/maps/api/geocode/json',
                    data: {'components': 'postal_code:'+id+'|country:SG', 'address': addr, 'key': '{{$appkey}}' },
                    success: function (data) {
                      console.log(nm);
                      if(data.status == 'OK') {
                        for(i=0;i<3;i++){
                          if(data.results[0].address_components[i].types[0] == 'subpremise') {

                            tmpval = data.results[0].address_components[i].long_name;
                            tmpval = tmpval.replace('#','');
                            console.log(tmpval);
                            if(tmpval.includes('-')) {
                              tmpArr = tmpval.split('-');
                              $( "input[name='"+nm.replace('[sitelocation]', '[unitnofrom]')+"']" ).val(tmpArr[0]);
                              $( "input[name='"+nm.replace('[sitelocation]', '[unitnoto]')+"']" ).val(tmpArr[1]);
                            } else {
                              $( "input[name='"+nm.replace('[sitelocation]', '[unitnofrom]')+"']" ).val(data.results[0].address_components[i].long_name);
                            }
                          }
                          if(data.results[0].address_components[i].types[0] == 'premise') {
                            $( "input[name='"+nm.replace('[sitelocation]', '[building]')+"']" ).val(data.results[0].address_components[i].long_name);
                          }
                          if(data.results[0].address_components[i].types[0] == 'route') {
                            $( "input[name='"+nm+"']" ).val(data.results[0].address_components[i].long_name);
                          }
                        }






                        lat=data.results[0].geometry.location.lat;
                        lng=data.results[0].geometry.location.lng;
                        useNextLoad(nm);
                        //$( "input[data-bv-field='sitelocation']" ).val(data.results[0].address_components[1].long_name);


                      }
                    }
                });
            }


            function getmaingeocode(id){

                $.ajax({
                    type: "GET",
                    url: 'https://maps.googleapis.com/maps/api/geocode/json',
                    data: {'components': 'postal_code:'+id+'|country:SG', 'key': '{{$appkey}}' },
                    success: function (data) {

                      if(data.status == 'OK') {
                        $( "#mstreet" ).val('searching - '+data.results[0].address_components[1].long_name);
                        lat=data.results[0].geometry.location.lat;
                        lng=data.results[0].geometry.location.lng;
                        usemainNextLoad();
                        //$( "input[data-bv-field='sitelocation']" ).val(data.results[0].address_components[1].long_name);


                      }
                    }
                });
            }

            function usemainNextLoad(){
              console.log(lat);
              console.log(lng);
              $.ajax({
                  type: "GET",
                  url: 'https://maps.googleapis.com/maps/api/geocode/json',
                  data: {'latlng': lat+','+lng, 'key': '{{$appkey}}' },
                  success: function (data) {

                    if(data.status == 'OK') {
                      if(data.results[0].address_components[1].types[0] == 'street_number') {
                        $( "#mstreet" ).val('');
                        $( "#munitnofrom" ).val('');
                        $( "#mbuilding" ).val('');
                        $( "#munitnofrom" ).val(data.results[0].address_components[1].long_name);
                        console.log(  $( "#munitnofrom" ).val());
                        $( "#mstreet"  ).val(data.results[0].address_components[2].long_name);
                        $( "#mbuilding" ).val(data.results[0].address_components[0].long_name);
                      } else {
                        console.log(  $( "#munitnofrom" ).val());
                        $( "#mstreet" ).val('');
                        $( "#munitnofrom" ).val('');
                        $( "#mbuilding" ).val('');
                        $( "#mstreet" ).val(data.results[0].address_components[1].long_name);
                        $( "#mbuilding" ).val(data.results[0].address_components[0].long_name);
                      }
                    }
                  }
              });
            }




            function useNextLoad(dm){
              console.log(lat);
              console.log(lng);
              $.ajax({
                  type: "GET",
                  url: 'https://maps.googleapis.com/maps/api/geocode/json',
                  data: {'latlng': lat+','+lng, 'key': '{{$appkey}}' },
                  success: function (data) {
                    console.log(dm);
                    if(data.status == 'OK') {

                      for(i=0;i<3;i++){
                        if(data.results[0].address_components[i].types[0] == 'street_number') {
                          $( "input[name='"+dm.replace('[sitelocation]', '[street]')+"']" ).val(data.results[0].address_components[i].long_name);
                          j = data.results[0].address_components[i].long_name;
                        }
                        if(data.results[0].address_components[i].types[0] == 'premise') {
                          $( "input[name='"+dm.replace('[sitelocation]', '[building]')+"']" ).val(data.results[0].address_components[i].long_name);
                        }
                        if(data.results[0].address_components[i].types[0] == 'route') {
                          $( "input[name='"+dm.replace('[sitelocation]', '[street]')+"']" ).val(j+' '+data.results[0].address_components[i].long_name);
                        }
                      }
                      /* if(data.results[0].address_components[1].types[0] == 'street_number') {
                        var st = dm.replace("[sitelocation]", "[street]");
                        $( "input[name='"+st+"']" ).val('');
                        $( "input[name='"+st+"']" ).val(data.results[0].address_components[1].long_name);
                        $( "input[name='"+dm+"']" ).val('');
                        $( "input[name='"+dm+"']" ).val(data.results[0].address_components[2].long_name);
                        var bt = dm.replace("[sitelocation]", "[building]");
                        $( "input[name='"+bt+"']" ).val('');
                        $( "input[name='"+bt+"']" ).val(data.results[0].address_components[0].long_name);
                      } else {
                        $( "input[name='"+dm+"']" ).val('');
                        $( "input[name='"+dm+"']" ).val(data.results[0].address_components[1].long_name);
                        var st = dm.replace("[sitelocation]", "[street]");
                        $( "input[name='"+st+"']" ).val('');
                        $( "input[name='"+st+"']" ).val(data.results[0].address_components[0].long_name);
                        var bt = dm.replace("[sitelocation]", "[building]");
                        $( "input[name='"+bt+"']" ).val('');
                      } */


                      //lat=data.results[0].geometry.location.lat;
                      //lng=data.results[0].geometry.location.lng;
                      //$( "input[data-bv-field='sitelocation']" ).val(data.results[0].address_components[1].long_name);
                      console.log('here');
                      //console.log(lng);

                    }
                  }
              });


            }



            $("button[type='submit']").mousedown(function () {

              //$("#company").find('.bc').prop('required', true)
              $("input[data-bv-field='sitelocation']").prop('required', true);
              $("input[data-bv-field='sitelocation']").attr("disabled",false);
              $("input[data-bv-field='sitelocation']").parent().addClass("has-error");
              $("input[data-bv-field='contact']").prop('required', true);
              $("input[data-bv-field='contact']").attr("disabled",false);
              $("input[data-bv-field='contact']").parent().addClass("has-error");
              $("select[data-bv-field='branchcategory']").prop('required', true);
              $("select[data-bv-field='branchcategory']").attr("disabled",false);
              $("select[data-bv-field='branchcategory']").parent().addClass("has-error");
              $("input[data-bv-field='postalcode']").prop('required', true);
              $("input[data-bv-field='postalcode']").attr("disabled",false);
              $("input[data-bv-field='postalcode']").parent().addClass("has-error");
              console.log('here');
              //$('#company').validator('update')
            });


            $( "body" ).on( "click", "#repeater-button", function() {
              var ctrls = $("div[data-repeater-item]");
              console.log(ctrls.length);
              //console.log(ctrls);
              for(i=0;i<ctrls.length;i++) {
                //console.log(ctrls[i]);
              }
              //console.log($("input[name='groupbranch["+(ctrls.length-1)+"][postalcode]']"));
              var refopt = $("input[name='groupbranch["+(ctrls.length-1)+"][postalcode]']");
              $('#company').bootstrapValidator('addField', refopt);
              refopt.prop('required', true);
              refopt.parent().addClass("has-error");

              var refopt1 = $("input[name='groupbranch["+(ctrls.length-1)+"][sitelocation]']");
              $('#company').bootstrapValidator('addField', refopt1);
              refopt1.prop('required', true);
              refopt1.parent().addClass("has-error");

              var refopt2 = $("select[name='groupbranch["+(ctrls.length-1)+"][branchcategory]']");
              console.log(refopt2.attr('name'));
              $('#company').bootstrapValidator('addField', refopt2);
              refopt2.prop('required', true);
              refopt2.parent().addClass("has-error");

              var refopt3 = $("input[name='groupbranch["+(ctrls.length-1)+"][contact]']");
              $('#company').bootstrapValidator('addField', refopt3);
              refopt3.prop('required', true);
              refopt3.parent().addClass("has-error");


            });

            $("#rrepeater-button").mouseup(function () {
              var ctrls = $("div[data-repeater-item]");
               setTimeout(console.log(ctrls.length),100);
               ctrls = $("div[data-repeater-item]");
              //var meForm = document.getElementById('company');
              //var bdoArray = document.getElementsByName('postalcode');
              console.log(ctrls.length);
              var tot =  ctrls.length;
              //$option   = $clone.find('[name="option[]"]');
              //$('#company').validator('update')


            });
            $("#repeater-button").mousedown(function () {

              //$("#company").find('.bc').prop('required', true)
              $("input[data-bv-field='sitelocation']").prop('required', true);
              $("input[data-bv-field='sitelocation']").attr("disabled",false);
              $("input[data-bv-field='sitelocation']").parent().addClass("has-error");
              $("input[data-bv-field='contact']").prop('required', true);
              $("input[data-bv-field='contact']").attr("disabled",false);
              $("input[data-bv-field='contact']").parent().addClass("has-error");
              $("select[data-bv-field='branchcategory']").prop('required', true);
              $("select[data-bv-field='branchcategory']").attr("disabled",false);
              $("select[data-bv-field='branchcategory']").parent().addClass("has-error");
              $("input[data-bv-field='postalcode']").prop('required', true);
              $("input[data-bv-field='postalcode']").attr("disabled",false);
              $("input[data-bv-field='postalcode']").parent().addClass("has-error");

              console.log('here');

            });
            function button_disabled(){
                if($(".form-group.required").hasClass("has-error")){
                    $("button[type='submit']").attr("disabled",true);
                    $("#company").submit(function(){
                                    return false;
                                });
                }else{
                    $("button[type='submit']").attr("disabled",false);
                }
            }

            @if(!empty($company))
            @endif
            //$('#repeater-button').trigger('click');
//document.getElementById("#repeater-button").click();
            //$("#repeater").createRepeater();


            /* $('#example').repeater(options, [

              {

                "demo[0][name]":"test",

                "demo[0][type]":"test"

              },{

                "demo[1][name]":"test2",

                "demo[1][type]":"test2"

              }]

            }); */


        });

//


    </script>
@endsection
