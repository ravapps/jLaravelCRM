<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<style type="text/css">
<!--
span.cls_002{font-family:Arial,serif;font-size:20.5px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_002{font-family:Arial,serif;font-size:20.5px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_008{font-family:Arial,serif;font-size:11.6px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_008{font-family:Arial,serif;font-size:11.6px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_003{font-family:Arial,serif;font-size:11.6px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_003{font-family:Arial,serif;font-size:11.6px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_004{font-family:Arial,serif;font-size:8.7px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Arial,serif;font-size:8.7px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Arial,serif;font-size:8.7px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_005{font-family:Arial,serif;font-size:8.7px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_006{font-family:Arial,serif;font-size:9.3px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_006{font-family:Arial,serif;font-size:9.3px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_007{font-family:Arial,serif;font-size:7.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_007{font-family:Arial,serif;font-size:7.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_009{font-family:Arial,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_009{font-family:Arial,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_010{font-family:Arial,serif;font-size:10.6px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_010{font-family:Arial,serif;font-size:10.6px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_011{font-family:Arial,serif;font-size:18.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_011{font-family:Arial,serif;font-size:18.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_012{font-family:Arial,serif;font-size:7.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_012{font-family:Arial,serif;font-size:7.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_013{font-family:Arial,serif;font-size:14.4px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_013{font-family:Arial,serif;font-size:14.4px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_014{font-family:Arial,serif;font-size:10.9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_014{font-family:Arial,serif;font-size:10.9px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_015{font-family:Arial,serif;font-size:6.8px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_015{font-family:Arial,serif;font-size:6.8px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_016{font-family:Arial,serif;font-size:6.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_016{font-family:Arial,serif;font-size:6.8px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
-->
</style>
<style>
.page-break {
    page-break-after: always;
}
</style>
</head>
<body>
<div style="position:absolute;left:50%;margin-left:-297px;top:0px;width:595px;height:841px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:448.77px;top:101.20px" class="cls_002"><span class="cls_002">COMPANY</span></div>
<div style="position:absolute;left:450.72px;top:124.96px" class="cls_014"><span class="cls_014">LOGO</span></div>
<div style="position:absolute;left:33.74px;top:150.48px" class="cls_004"><span class="cls_004">Attention: </span><span class="cls_005">{{ is_null($quotation->customer)?"":$quotation->customer->user->full_name }}</span></div>
<div style="position:absolute;left:308.16px;top:150.24px" class="cls_004"><span class="cls_004">Our Quotation : </span><span class="cls_005">{{ is_null($quotation->quotations_number)?"":$quotation->quotations_number }}</span></div>
<div style="position:absolute;left:308.40px;top:160.80px" class="cls_004"><span class="cls_004">Date</span></div>
<div style="position:absolute;left:370.32px;top:160.56px" class="cls_004"><span class="cls_004">:  </span><span class="cls_005">{{ $quotation->start_date }}</span></div>
<div style="position:absolute;left:34.56px;top:171.36px" class="cls_005"><span class="cls_005">{{ is_null($quotation->company)?"":$quotation->company->name }}</span></div>
<div style="position:absolute;left:308.40px;top:171.36px" class="cls_004"><span class="cls_004">Quote Type  </span></div>
<div style="position:absolute;left:372.24px;top:171.12px" class="cls_004"><span class="cls_004"> </span><span class="cls_005">{{$quotation->quote_type}}</span></div>
<div style="position:absolute;left:35.28px;top:181.68px" class="cls_005"><span class="cls_005"> {{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->sitelocation }} {{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->street }}</span></div>
<div style="position:absolute;left:308.16px;top:181.68px" class="cls_004"><span class="cls_004">Valid Until</span></div>
<div style="position:absolute;left:371.76px;top:181.68px" class="cls_004"><span class="cls_004">: </span><span class="cls_005">{{ $quotation->expire_date }}</span></div>
<div style="position:absolute;left:34.56px;top:192.00px" class="cls_005"><span class="cls_005">#{{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->unitnofrom }}-{{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->unitnoto }} </span></div>
<div style="position:absolute;left:35.04px;top:202.56px" class="cls_005"><span class="cls_005">{{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->building }} Singapore {{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->postalcode }}</span></div>
<div style="position:absolute;left:32.40px;top:226.08px" class="cls_004"><span class="cls_004">Subject: {{$quotation->qsubject}} {{-- Propose Quotation for service/product at {{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->sitelocation }} {{ is_null($quotation->customercontact->contactSitelocation)?"":$quotation->customercontact->contactSitelocation->street }} --}}</span></div>
<div style="position:absolute;left:38.16px;top:249.84px" class="cls_004"><span class="cls_004">S.No</span></div>
<div style="position:absolute;left:192.00px;top:249.60px" class="cls_004"><span class="cls_004">Product Details</span></div>
<div style="position:absolute;left:404.40px;top:249.60px" class="cls_004"><span class="cls_004">Qty</span></div>
<div style="position:absolute;left:444.72px;top:249.84px" class="cls_004"><span class="cls_004">Unit Price</span></div>
<div style="position:absolute;left:501.60px;top:249.84px" class="cls_004"><span class="cls_004">Total (SGD$)</span></div>
@php $topunit = 278.16; @endphp
@if(isset($quotation)&& $quotation->quotationProducts->count()>0)
    @foreach($quotation->quotationProducts as $index => $variants)
<div style="position:absolute;left:45.12px;top:{{$topunit}}px" class="cls_005"><span class="cls_005">{{$index+1}}</span></div>
<div style="position:absolute;left:62.64px;top:{{$topunit}}px" class="cls_004"><span class="cls_004">{{$variants->product_name}}</span></div>
<div style="position:absolute;left:410.16px;top:{{$topunit}}px" class="cls_005"><span class="cls_005">{{$variants->pivot->quantity}}</span></div>
<div style="position:absolute;left:450.48px;top:{{$topunit}}px" class="cls_005"><span class="cls_005">@money($variants->pivot->price)</span></div>
<div style="position:absolute;left:511.92px;top:{{$topunit}}px" class="cls_005"><span class="cls_005">@money($variants->pivot->quantity*$variants->pivot->price)</span></div>
<div style="position:absolute;left:62.40px;top:{{$topunit+11}}px" class="cls_005"><span class="cls_005">{{$variants->pivot->description}}</span></div>
<div style="position:absolute;left:62.64px;top:{{$topunit+22}}px" class="cls_005"><span class="cls_005">{{$variants->pivot->description_for_quotations}}</span></div>
@php $topunit = $topunit+22+20; @endphp
@endforeach
@endif
<div style="position:absolute;left:406.28px;top:435.08px" ><span ><hr width="150px" color"black"></span></div>
<div style="position:absolute;left:406.28px;top:453.08px" class="cls_004"><span class="cls_004">Sub Total</span></div>
<div style="position:absolute;left:522.72px;top:453.08px" class="cls_004"><span class="cls_004"> </span><span class="cls_005">@money($quotation->grand_total)</span></div>
<div style="position:absolute;left:407.28px;top:472.08px" class="cls_004"><span class="cls_004">Discount @if($quotation->discount_is_fixed == 1) (fixed) @else % @endif </span></div>
<div style="position:absolute;left:522.72px;top:472.08px" class="cls_004"><span class="cls_004"> </span><span class="cls_005">@if($quotation->discount_is_fixed == 1)  @money($quotation->discount)  @else {{$quotation->discount}} % @endif     </span></div>
<div style="position:absolute;left:407.28px;top:490.08px" class="cls_004"><span class="cls_004">GST @ 7% </span></div>
<div style="position:absolute;left:522.72px;top:489.84px" class="cls_004"><span class="cls_004"> </span><span class="cls_005">@money($quotation->tax_amount)</span></div>
<div style="position:absolute;left:407.28px;top:508.08px" class="cls_004"><span class="cls_004">Grand Total</span></div>
<div style="position:absolute;left:522.72px;top:507.84px" class="cls_004"><span class="cls_004"> </span><span class="cls_005">@money($quotation->grand_total)</span></div>
<div style="position:absolute;left:34.32px;top:530.88px" class="cls_004"><span class="cls_004">Remarks {{ $quotation->remarks }}</span></div>
<div style="position:absolute;left:33.60px;top:559.44px" class="cls_004"><span class="cls_004">Terms and Conditions</span></div>
<div style="position:absolute;left:34.08px;top:579.60px" class="cls_015"><span class="cls_015">{{ $quotation->terms_and_conditions }}</span></div>
<div style="position:absolute;left:34.08px;top:587.76px" class="cls_015"><span class="cls_015"></span></div>
<div style="position:absolute;left:34.08px;top:596.16px" class="cls_015"><span class="cls_015"></span></div>
<div style="position:absolute;left:34.08px;top:604.80px" class="cls_015"><span class="cls_015"> </span></div>
<div style="position:absolute;left:33.84px;top:612.96px" class="cls_015"><span class="cls_015"> </span></div>
<div style="position:absolute;left:34.08px;top:621.36px" class="cls_015"><span class="cls_015"> </span></div>
<div style="position:absolute;left:33.60px;top:629.76px" class="cls_015"><span class="cls_015"> </span></div>
<div style="position:absolute;left:34.56px;top:645.60px" class="cls_015"><span class="cls_015"> </span></div>
<div style="position:absolute;left:36.24px;top:661.20px" class="cls_004"><span class="cls_004">For Company Services Pte Ltd</span></div>
<div style="position:absolute;left:309.12px;top:661.20px" class="cls_004"><span class="cls_004">Client&apos;s Approval and Endorsement</span></div>
<div style="position:absolute;left:48.24px;top:672.00px" class="cls_004"><span class="cls_004"></span></div>
<div style="position:absolute;left:60.72px;top:672.00px" class="cls_004"><span class="cls_004"></span></div>
<div style="position:absolute;left:48.72px;top:684.72px" class="cls_004"><span class="cls_004"></span></div>
<div style="position:absolute;left:35.76px;top:727.20px" class="cls_005"><span class="cls_005">Authorized Signature</span></div>
<div style="position:absolute;left:309.36px;top:727.44px" class="cls_005"><span class="cls_005">Namel \ Title \ Date</span></div>
<div style="position:absolute;left:27.12px;top:742.32px" class="cls_004"><span class="cls_004">Company Services Pte Ltd.</span></div>
<div style="position:absolute;left:27.36px;top:753.60px" class="cls_015"><span class="cls_015">License No. XXXXXX00</span></div>
<div style="position:absolute;left:27.12px;top:765.36px" class="cls_015"><span class="cls_015">0 Dummy Street 00, #00-00 DUM Building, Singapore 609601</span></div>
<div style="position:absolute;left:26.64px;top:776.64px" class="cls_016"><span class="cls_016">1</span><span class="cls_015">XXXX XXXX  I  </span><span class="cls_016">F </span><span class="cls_015">XXXX XXXX  I  <A HREF="http://www.companysite.com/">www.companysite.com</A> </span></div>
<div style="position:absolute;left:333.84px;top:815.60px" class="cls_009"><span class="cls_009">COMPANY SLOGAN HERE</span></div>
</div>

</body>
</html>
