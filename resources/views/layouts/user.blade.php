<!DOCTYPE html>
<html>
<head>
    @include('layouts._meta')
    @include('layouts._assets')

    @yield('styles')
</head>
<body>
<div id="app">
<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('uploads/site/'.Settings::get('site_logo')) }}"
                 alt="{{ Settings::get('site_name') }}" class="img-responsive img_logo">

        </a>

        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                        class="fa fa-fw fa-navicon"></i>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                @include("left_menu._header-right")
            </ul>
        </div>
    </nav>
</header>
  @if(Sentinel::inRole('admin') || Sentinel::inRole('staff'))
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                  @include('left_menu._main')
            </div> <!-- end .collapsed-->
        </nav>
    </div> <!-- end container-fluid -->
</div> <!-- end topnav-->
@endif

<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">

                <!-- / .navigation -->
                @if(Sentinel::inRole('admin') || Sentinel::inRole('staff'))
                    @include('left_menu._user')
                @elseif(Sentinel::inRole('customer'))
                    @include('left_menu._customer')
                @endif
            </div>
            <!-- menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <aside class="right-side right-padding">
      <div class="row breadcrumbs-row">

          <div class="col-sm-12">

            <div class="breadcrumb-wrapper">

              <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="{{url('/')}}">DASHBOARD</a>

                </li>

                @foreach($segments = request()->segments(2) as $index => $segment)
                    @php $urltxt = $segment; @endphp
                    @if(!is_numeric($segment))
                    @php
                    $urlval="";
                    if($segment == "company")
                      $urltxt = "Customers";
                      if($segment == "customer")
                        $urltxt = "Contacts";
                      if($segment == "lead")
                          $urltxt = "Leads";
                      if($segment == "sales_order")
                          $urltxt = "Sales Orders";
                      if($segment == "jobs_order")
                          $urltxt = "Jobs Orders";
                      if($segment == "draft_salesorders")
                          $urltxt = "Draft";
                      if($segment == "salesorder_invoice_list") {
                          echo '<li class="breadcrumb-item"><a href="'.url('/sales_order').'">'.strtoupper("Sales Orders").'</a></li>';
                          $urltxt = "Sales Order Invoice List";
                      }
                      if($segment == "salesorder_delete_list") {
                          echo '<li class="breadcrumb-item"><a href="'.url('/sales_order').'">'.strtoupper("Sales Orders").'</a></li>';
                          $urltxt = "Deleted List";
                      }
                      if($segment == "draft_jobsorders")
                          $urltxt = "Draft";
                      if($segment == "jobsorder_invoice_list") {
                          echo '<li class="breadcrumb-item"><a href="'.url('/jobs_order').'">'.strtoupper("Jobs Orders").'</a></li>';
                          $urltxt = "Jobs Order Invoice List";
                      }
                      if($segment == "jobsorder_delete_list") {
                          echo '<li class="breadcrumb-item"><a href="'.url('/jobs_order').'">'.strtoupper("Jobs Orders").'</a></li>';
                          $urltxt = "Deleted List";
                      }
                      if($segment == "quotation") {
                          if(isset($lead)) {
                            if($lead <> "") {
                            $urltxt = "Leads";
                            $urlval = url('/lead');
                          } else {
                            $urltxt = "Quotations";
                          }
                        }

                      }
                      if($segment ==  "quotation_delete_list") {
                        echo '<li class="breadcrumb-item"><a href="'.url('/quotation').'">'.strtoupper("quotation").'</a></li>';
                        $urltxt = "Deleted List";
                      }
                      if($segment ==  "quotation_converted_list") {
                        echo '<li class="breadcrumb-item"><a href="'.url('/quotation').'">'.strtoupper("quotation").'</a></li>';
                        $urltxt = "SO Converted";
                      }

                      if($segment ==  "quotation_invoice_list") {
                        echo '<li class="breadcrumb-item"><a href="'.url('/quotation').'">'.strtoupper("quotation").'</a></li>';
                        $urltxt = "Invoice Converted";
                      }
                      if($segment ==  "draft_quotations") {

                        $urltxt = "Draft";
                      }
                      if($segment == "leadcall") {

                            $urltxt = "Leads";
                            $urlval = url('/lead');

                      }
                      if($segment == "create") {
                          if(isset($lead)) {
                          if($lead <> "") {
                            $urltxt = "convert";
                          }
                          }
                      }

                    @endphp


                    <li class="breadcrumb-item">

                        @if($urlval == "")
                        <a href="{{url(implode('/',array_slice($segments,0,$index+1)))}}">{{strtoupper($urltxt)}}</a>
                        @else
                        <a href="{{$urlval}}">{{strtoupper($urltxt)}}</a>
                        @endif

                    </li>
                    @php
                    if($segment == "leadcall") {

echo '<li class="breadcrumb-item"><a href="#">'.strtoupper("Call Log").'</a></li>';

                    }
                    @endphp

                    @endif

                @endforeach

                <!-- @for($i = 2; $i <= count(Request::segments()); $i++)

                   <li class="breadcrumb-item">

                      <a href="{{ URL::to( implode( '/', array_slice(Request::segments(), 0 ,$i, true)))}}">

                         {{strtoupper(Request::segment($i))}}

                      </a>

                   </li>

                @endfor -->

              </ol>

            </div>

          </div>

        </div>
        <div class="right-content">
            <section class="box-shadow">
            <h1>{{ $title or 'Welcome to FMS' }}</h1>
            </section>

            <!-- Notifications -->

            <!-- Content -->
            <div class="right_cont">
            @yield('content')
            </div>
                    <!-- /.content -->
        </div>
    </aside>
    <!-- /.right-side -->
</div>
<!-- /.right-side -->
<!-- ./wrapper -->
</div>
<!-- global js -->
@include('layouts._assets_footer')
@include('layouts.pusherjs')


</body>
</html>
