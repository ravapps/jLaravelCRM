@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="page-header clearfix">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-send_by_email"
           onclick="create_pdf({{$invoice->id}})"><i class="fa fa-envelope-o"></i> {{trans('invoice.email_send')}}</a>
        <a href="{{url('invoice/'.$invoice->id.'/print_quot')}}" class="btn btn-primary" target=""><i
                    class="fa fa-print"></i> {{trans('invoice.print')}}</a>
        @if(strtotime(date("m/d/Y"))>strtotime("+".$invoice->payment_term."",strtotime($invoice->invoice_due_date)))
            <button type="button" class="btn btn-danger invoice-send">{{trans('invoice.invoice_expired')}}</button>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="details">
                @include('user/'.$type.'/_details')
            </div>
        </div>
    </div>
    <!-- START MODAL SEND BY EMAIL CONTENT -->
    <div class="modal fade" id="modal-send_by_email" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle-o"></i>
                    </button>
                    <h4 class="modal-title"><strong>{{trans('invoice.email_send')}}</strong></h4>
                </div>
                {!! Form::open(['url' => $type, 'method' => 'post', 'files'=> true, 'id'=>'send_invoice', 'name'=>"send_invoice"]) !!}
                {!! Form::hidden('invoice_id', $invoice->id, ['class' => 'form-control', 'id'=>"invoice_id"]) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('email_subject', trans('invoice.subject'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('email_subject', "Demo Company Invoice (Ref ".$invoice->invoice_number.')'
                            , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('recipients', trans('invoice.recipients'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::select('recipients[]', isset($email_recipients)?$email_recipients:null, null, ['id'=>'recipients','class' => 'form-control select2']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="control-label"></label>
                       <textarea name="message_body" id="message_body" cols="80" rows="10" class="cke-editor resize_vertical">
                       	<p>
                            Hello {{(isset($invoice->customer)?$invoice->customer->full_name:"")}}
                            ,</p>
                            <p>Here is your order confirmation from Demo Company: </p>
                            <p class="show-para-inv">
                                &nbsp;&nbsp;<strong>REFERENCES</strong><br>
                                &nbsp;&nbsp;Order number:
                                <strong>{{ $invoice->invoice_number}}</strong><br>
                                &nbsp;&nbsp;Order total: <strong>{{ $invoice->grand_total}}</strong><br>
                                &nbsp;&nbsp;Order date: {{ date('m/d/Y H:i', strtotime($invoice->date))}}
                                <br>
                            </p>
                       </textarea>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="control-label">{{trans('invoice.file')}}</label>
                        <a href="" id="pdf_url" target="_blank"></a>
                        <input type="hidden" name="invoice_pdf" id="invoice_pdf" value=""
                               class="form-control">
                    </div>
                </div>
                <div class="modal-footer text-right">
                        <button type="submit"
                                class="btn btn-primary sendmail">{{trans('invoice.send')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $("#recipients").select2({
                placeholder:"{{ trans('quotation.recipients') }}",
                theme: 'bootstrap'
            });
        });
        function create_pdf(quotation_id) {
            $.ajax({
                type: "GET",
                url: "{{url('invoice' )}}/" + quotation_id + "/ajax_create_pdf",
                data: {'_token': '{{csrf_token()}}'},
                success: function (msg) {
                    if (msg != '') {
                        $("#pdf_url").attr("href", msg)
                        var index = msg.lastIndexOf("/") + 1;
                        var filename = msg.substr(index);
                        $("#pdf_url").html(filename);
                        $("#quotation_pdf").val(filename);
                    }
                }
            });
        }
        $("#recipients").select2({
            placeholder:"{{ trans('quotation.recipients') }}",
            theme: 'bootstrap'
        });
        $("#send_invoice").bootstrapValidator({
            fields: {
                'recipients[]': {
                    validators: {
                        notEmpty: {
                            message: 'The recipients field is required'
                        }
                    }
                },
                message_body:{
                    validators: {
                        notEmpty: {
                            message: 'The message field is required'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            $.post( "{{url('invoice/send_invoice')}}", $('#send_invoice').serialize())
                .done(function( msg ) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#sendby_ajax").html(msg);
                    $("#modal-send_by_email").modal('hide');
                });
            setTimeout(function(){
                $("#sendby_ajax").hide();
            },5000);
        });

        $("#modal-send_by_email").on('hide.bs.modal', function () {
            $("#recipients").find("option").attr('selected',false);
            $("#recipients").select2({
                placeholder:"{{ trans('quotation.recipients') }}",
                theme: 'bootstrap'
            });
            $("#send_invoice").data('bootstrapValidator').resetForm();
        });
    </script>
@stop