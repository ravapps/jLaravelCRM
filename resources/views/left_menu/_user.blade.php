<div class="nav_profile">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="{{url('/profile')}}">
            @if($user_data->user_avatar)
                <img src="{!! url('/').'/uploads/avatar/'.$user_data->user_avatar !!}" alt="img"
                     class="img-rounded"/>
            @else
                <img src="{{ url('uploads/avatar/user.png') }}" alt="img" class="img-rounded"/>
            @endif
        </a>
        <div class="content-profile">
            <h4 class="media-heading">{{ str_limit($user_data->full_name, 25) }}</h4>
            <ul class="icon-list">
                <li>
                    <a href="{{ url('mailbox') }}#/m/inbox" title="Email">
                        <i class="fa fa-fw fa-envelope"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('sales_order') }}" title="Sales Order" >
                        <i class="fa fa-fw fa-usd"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ url('invoice') }}" title="Invoices" >
                        <i class="fa fa-fw fa-file-text"></i>
                    </a>
                </li>
                @if(Sentinel::inRole('admin'))
                <li>
                    <a href="{{ url('setting') }}" title="Settings" >
                        <i class="fa fa-fw fa-cog"></i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@if(Sentinel::inRole('admin') || Sentinel::inRole('staff'))
    @include('left_menu._main')
@elseif(Sentinel::inRole('customer'))
    @include('left_menu._customer')
@endif
