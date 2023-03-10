@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div id="sendby_ajax"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="page-header clearfix">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-send_by_email"
                   onclick="return false; create_pdf({{ $saleorder->id}})"><i
                            class="fa fa-envelope-o"></i> {{trans('quotation.send_email')}}
                </a>
                <a href="{{url('sales_order/'.$saleorder->id.'/print_quot')}}" class="btn btn-primary"><i
                            class="fa fa-print" onclick="return false;"></i> {{trans('quotation.print')}}</a>

            </div>
            <div class="details">
                @include('user/'.$type.'/_details')
            </div>
        </div>
    </div>
@stop
