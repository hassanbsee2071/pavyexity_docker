<div class="top_nav">
    <div class="nav_menu">
        <nav>
        @if(auth()->user() != null)
         
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
@endif
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
        @if(auth()->user() != null)
           
                        <img src="{{ auth()->user()->avatar }}" alt="">{{ auth()->user()->first_name . " " . auth()->user()->last_name }}
           @endif

                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
        @if(auth()->user() != null)

                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out pull-right"></i> {{ __('views.backend.section.header.menu_0') }}
                            </a>
                            @endif
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
