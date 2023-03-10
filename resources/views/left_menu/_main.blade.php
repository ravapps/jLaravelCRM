<ul class="navigation">
    <li {!! (Request::is( '/') ? 'class="active"' : '') !!}>
        <a href="{{url('/')}}">
            <span class="nav-icon">
         <i class="material-icons">dashboard</i>
        </span>
            <span class="nav-text"> {{trans('left_menu.dashboard')}}</span>
        </a>
    </li>
    @if(isset($user_data) && ($user_data->hasAccess(['contacts.read']) || $user_data->inRole('admin')))
    <li {!! (Request::is( 'company/*') || Request::is( 'company') ? 'class="active"' : '') !!}>
        <a href="{{url('company')}}">
           <i class="material-icons">flag</i>
            <span class="nav-text">{{trans('left_menu.companies')}}</span>
        </a>
    </li>
    <li {!! (Request::is( 'customer/*') || Request::is( 'customer')  ? 'class="active"' : '') !!}>
          <a href="{{url('customer')}}">
              <i class="material-icons ">person</i>
              <span class="nav-text">{{trans('left_menu.agent')}}</span></a>
    </li>

    @endif
    @if(isset($user_data) && ($user_data->hasAccess(['leads.read']) || $user_data->inRole('admin')))
    <li {!! (Request::is( 'lead*') || Request::is( 'leadcall/*') || Request::is( 'lead') ? 'class="active"' : '') !!}>
      <a>
        <span class="nav-caret pull-right">
          <i class="fa fa-angle-right"></i>
        </span>
        <span class="nav-icon">
          <i class="material-icons ">thumb_up</i>
        </span>
        <span class="nav-text">{{trans('left_menu.leads')}}</span>
      </a>
      <ul class="nav-sub">
        <li {!! (Request::is( 'lead') || Request::is( 'leadcall/*') ? 'class="active"' : '') !!}>
            <a href="{{url('lead')}}">
                <i class="material-icons ">thumb_up</i>
                <span class="nav-text">{{trans('left_menu.leads')}}</span>
            </a>
        </li>
        @if(isset($user_data) && ($user_data->hasAccess(['leads.read']) && $user_data->hasAccess(['leads.write']) || $user_data->inRole('admin')))
         <li {!! (Request::is('lead/import') ? 'class="active"' : '') !!}>
              <a href="{{url('lead/import')}}">
                  <i class="material-icons">backup</i>
                  <span class="nav-text">{{trans('left_menu.leadsimport')}}</span>
              </a>
          </li>
        @endif

        @if(isset($user_data) && ($user_data->hasAccess(['logged_calls.read']) || $user_data->inRole('admin')))
        <li {!! (Request::is( 'call/*') || Request::is( 'call') ? 'class="active"' : '') !!}>
            <a href="{{url('call')}}">
                <span class="nav-icon">
             <i class="material-icons ">phone</i>
            </span>
                <span class="nav-text">{{trans('left_menu.calls')}}</span>
            </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    @if(isset($user_data) && ($user_data->hasAccess(['quotations.read']) || $user_data->inRole('admin')))
    <li {!! (Request::is( 'quotation/*') || Request::is( 'quotation')|| Request::is( 'quotation*') ? 'class="active"' : '') !!}>
        <a href="{{url('quotation')}}">
            <i class="material-icons ">receipt</i>
            <span class="nav-text">{{trans('left_menu.quotations')}}</span></a>
    </li>
    @endif
    @if(isset($user_data) && ($user_data->hasAccess(['sales_orders.read']) || $user_data->inRole('admin')))
    <li>
      <a href="javascript:;">
         <span class="nav-caret pull-right"><i class="fa fa-angle-right"></i></span>
          <span class="nav-icon">
            <i class="material-icons">event_note</i>
          </span>
          <span class="nav-text">Orders</span>
      </a>
      <ul class="nav-sub">
       <li {!! (Request::is( 'sales_order/*') || Request::is( 'sales_order') || Request::is('salesorder_delete_list') || Request::is('salesorder_invoice_list') ? 'class="active"' : '') !!}>
         <a href="{{url('sales_order')}}">
             <span class="nav-icon">
          <i class="material-icons ">attach_money</i>
         </span>
             <span class="nav-text">{{trans('left_menu.sales_order')}}</span>
         </a>
       </li>
       <li {!! (Request::is( 'jobs_order/*') || Request::is( 'jobs_order') || Request::is('jobsorder_delete_list') || Request::is('jobsorder_invoice_list') ? 'class="active"' : '') !!}>
         <a href="{{url('jobs_order')}}">
             <span class="nav-icon">
          <i class="material-icons ">attach_money</i>
         </span>
             <span class="nav-text">{{trans('left_menu.jobs_order')}}</span>
         </a>
       </li>
       <li {!! (Request::is( 'delivery/*') || Request::is( 'delivery') || Request::is('jobsorder_delete_list') || Request::is('jobsorder_invoice_list') ? 'class="active"' : '') !!}>
         <a href="{{url('delivery')}}">
             <span class="nav-text">{{trans('left_menu.delivery')}}</span>
         </a>
       </li>
       @if(isset($user_data) && ($user_data->hasAccess(['invoices.read']) || $user_data->inRole('admin')))
       <li {!! (Request::is( 'invoice/*') || Request::is( 'invoice') || Request::is( 'invoices_payment_log/*') || Request::is( 'invoices_payment_log')
           || Request::is( 'invoice_delete_list') || Request::is('paid_invoice') ? 'class="active"' : '') !!}>
           <a>
               <span class="nav-caret pull-right">
             <i class="fa fa-angle-right"></i>
           </span>
               <span class="nav-icon">
              <i class="material-icons ">web</i>
           </span>
               <span class="nav-text">{{trans('left_menu.invoices')}}</span>
           </a>
           <ul class="nav-sub">
               <li {!! (Request::is( 'invoice/*') || Request::is( 'invoice') || Request::is( 'invoice_delete_list') || Request::is('paid_invoice') ? 'class="active"' : '') !!}>
                   <a href="{{url('invoice')}}">
                       <i class="material-icons ">receipt</i>
                       <span class="nav-text">{{trans('left_menu.invoices')}}</span></a>
               </li>
               <li {!! (Request::is( 'invoices_payment_log/*') || Request::is( 'invoices_payment_log') ? 'class="active"' : '') !!}>
                   <a href="{{url('invoices_payment_log')}}">
                       <i class="material-icons ">archive</i>
                       <span class="nav-text">{{trans('left_menu.payment_log')}}</span></a>
               </li>
           </ul>
       </li>
       @endif
       @if(isset($user_data) && ($user_data->hasAccess(['products.read']) || $user_data->inRole('admin')))
       <li {!! (Request::is( 'product/*') || Request::is( 'product') || Request::is( 'category/*') || Request::is( 'category') ? 'class="active"' : '') !!}>
          <a>
              <span class="nav-caret pull-right">
            <i class="fa fa-angle-right"></i>
          </span>
              <span class="nav-icon">
             <i class="material-icons ">shopping_basket</i>
          </span>
              <span class="nav-text">{{trans('left_menu.products')}}</span>
          </a>
          <ul class="nav-sub">
              <li {!! (Request::is( 'product/*') || Request::is( 'product') ? 'class="active"' : '') !!}>
                  <a href="{{url('product')}}">
                      <i class="material-icons">layers</i>
                      <span class="nav-text">{{trans('left_menu.products')}}</span></a>
              </li>
              <li {!! (Request::is( 'category/*') || Request::is( 'category') ? 'class="active"' : '') !!}>
                  <a href="{{url('category')}}">
                      <i class="material-icons">gamepad</i>
                      <span class="nav-text">{{trans('left_menu.category')}}</span></a>
              </li>
          </ul>
      </li>
      @endif
    </ul>



    </li>
    @endif




   <li {!! (Request::is( 'calendar/*') || Request::is( 'calendar') ? 'class="active"' : '') !!}>
       <a href="{{url('calendar')}}">
           <span class="nav-icon">
       <i class="material-icons">event_note</i>
       </span>
           <span class="nav-text">{{trans('left_menu.calendar')}}</span>
       </a>
   </li>
   <li>
     <a href="javascript:;">
        <span class="nav-caret pull-right"><i class="fa fa-angle-right"></i></span>
         <span class="nav-icon">
           <i class="material-icons">event_note</i>
         </span>
         <span class="nav-text">Others</span>
     </a>
     <ul class="nav-sub">
       @if(isset($user_data) && ($user_data->hasAccess(['opportunities.read']) || $user_data->inRole('admin')))
       <li {!! (Request::is( 'opportunity*') || Request::is( 'opportunity') ? 'class="active"' : '') !!}>
           <a href="{{url('opportunity')}}">
               <span class="nav-icon">
                 <i class="material-icons ">event_seat</i>
               </span>
               <span class="nav-text">{{trans('left_menu.opportunities')}}</span>
           </a>
       </li>
       @endif

       @if(isset($user_data) && ($user_data->hasAccess(['sales_team.read']) || $user_data->inRole('admin')))
       <li {!! (Request::is( 'salesteam/*') || Request::is( 'salesteam') ? 'class="active"' : '') !!}>
           <a href="{{url('salesteam')}}">
               <span class="nav-icon">
            <i class="material-icons ">groups</i>
           </span>
               <span class="nav-text"> {{trans('left_menu.salesteam')}}</span>
           </a>
       </li>
       @endif
       @if(isset($user_data) && ($user_data->hasAccess(['meetings.read']) || $user_data->inRole('admin')))
       <li {!! (Request::is( 'meeting/*') || Request::is( 'meeting') ? 'class="active"' : '') !!}>
           <a href="{{url('meeting')}}">
               <span class="nav-icon">
            <i class="material-icons">radio</i>
           </span>
               <span class="nav-text">{{trans('left_menu.meetings')}}</span>
           </a>
       </li>
       @endif
       <li {!! (Request::is( '/task/*') || Request::is( 'task') ? 'class="active"' : '') !!}>
           <a href="{{url('/task')}}">
               <span class="nav-icon">
            <i class="material-icons">event_task</i>
           </span>
               <span class="nav-text"> {{trans('left_menu.tasks')}}</span>
           </a>
       </li>
       <li {!! (Request::is( '/todo/*') || Request::is( 'todo') ? 'class="active"' : '') !!}>
           <a href="{{url('/todo')}}">
               <span class="nav-icon">
            <i class="material-icons">layers</i>
           </span>
               <span class="nav-text"> {{trans('left_menu.todo')}}</span>
           </a>
       </li>
     </ul>



   </li>
   <li>
       <a href="javascript:;">
          <span class="nav-caret pull-right"><i class="fa fa-angle-right"></i></span>
           <span class="nav-icon">
             <i class="material-icons">event_note</i>
           </span>
           <span class="nav-text">Configuration</span>
       </a>
       <ul class="nav-sub">
         @if(isset($user_data) && $user_data->hasAccess(['staff.read']) || $user_data->inRole('admin'))
         <li {!! (Request::is( 'staff/*') || Request::is( 'staff') ? 'class="active"' : '') !!}>
             <a href="{{url('staff')}}">
                 <span class="nav-icon">
                  <i class="material-icons">people_outline</i>
                 </span>
                 <span class="nav-text">{{trans('left_menu.staff')}}</span>
             </a>
         </li>
         @endif
         @if(isset($user_data) && $user_data->inRole('admin'))
         <li {!! (Request::is( 'option/*') || Request::is( 'option') ? 'class="active"' : '') !!}>
             <a href="{{url('option')}}">
                 <span class="nav-icon">
                    <i class="material-icons">dashboard</i>
                   </span>
                 <span class="nav-text">{{trans('left_menu.options')}}</span>
             </a>
         </li>
         <li {!! (Request::is( 'email_template/*') || Request::is( 'email_template') ? 'class="active"' : '') !!}>
             <a href="{{url('email_template')}}">
                 <span class="nav-icon">
                  <i class="material-icons">email</i>
                 </span>
                 <span class="nav-text">{{trans('left_menu.email_template')}}</span>
             </a>
         </li>
         <li {!! (Request::is( 'qtemplate/*') || Request::is( 'qtemplate') ? 'class="active"' : '') !!}>
             <a href="{{url('qtemplate')}}">
                 <i class="material-icons ">image</i>
                 <span class="nav-text">{{trans('left_menu.quotation_template')}}</span>
             </a>
         </li>
         <li {!! (Request::is( 'setting/*') || Request::is( 'setting') ? 'class="active"' : '') !!}>
             <a href="{{url('setting')}}">
                 <span class="nav-icon">
                  <i class="material-icons">settings</i>
                 </span>
                 <span class="nav-text">{{trans('left_menu.settings')}}</span>
             </a>
         </li>
         <li {!! (Request::is( 'backup/*') || Request::is( 'backup') ? 'class="active"' : '') !!}>
             <a href="{{url('backup')}}">
         				<span class="nav-icon">
         					<i class="material-icons text-primary">backup</i>
         				</span>
                 <span class="nav-text">{{trans('left_menu.backup')}}</span>
             </a>
         </li>
         @endif
       </ul>
   </li>







</ul>
