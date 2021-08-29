<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.dashboard') }}" class="site_title">
                <img src="{{asset('/images/logo.png')}}" alt="Logo" title="Logo" class="img-fluid" />
            </a>
            <div class="sidebar-divider"></div>
        </div>

        <div class="clearfix"></div>

      
        <br />

        @if(auth()->user() != null)

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <!-- <h3>{{ __('views.backend.section.navigation.sub_header_0') }}</h3> -->
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_0_1') }}
                        </a>
                    </li>
                </ul>
                @if (hasModulepermission('Online Payments'))
                <ul class="nav side-menu">

                    <li class=""><a><i class="fa fa-credit-card"></i> Online Payment Service <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <li class="current-page">
                                
                            <a href="{{ route('online.payment.links') }}">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Payment Links
                                </a>
                            </li>
                            <li class="current-page">
                                <a href="{{ route('online.payment.received') }}">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Received Payment
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endif
                @if (hasModulepermission('Settings'))
                <ul class="nav side-menu">

                    <li class=""><a><i class="fa fa-cogs"></i> Settings <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            @if (hasModulepermission('Users'))
                            <li class="current-page">
                                <a href="{{ route('admin.users') }}">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Users
                                </a>
                            </li>
                            @endif
                            @if(isSuperAdmin())
                            <li class="current-page">
                                <a href="{{ route('admin.company') }}">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Company Management
                                </a>
                            </li>
                            @endif
                            @if(isSuperAdmin())
                            <li class="current-page">
                                <a href="{{ route('admin.email_template') }}">
                                    <!-- <i class="fa fa-envelope" aria-hidden="true"></i> -->
                                    Email Management
                                </a>
                            </li>
                            @endif
                            @if (isSuperAdmin())
                            <li class="current-page">
                                <a href="{{ route('admin.smtp') }}">
                                    <!-- <i class="fa fa-envelope" aria-hidden="true"></i> -->
                                    SMTP Setting
                                </a>
                            </li>
                            @endif
                            @if(isAdmin())
                            <li class="current-page">
                                <a href="{{ route('admin.company.edit', ['id' => Session::get('admin_company_id')]) }}">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Edit Company</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                @endif
            </div>
            @if (hasModulepermission('Payment Services'))
            <div class="menu_section">
                <!-- <h3>Payment</h3> -->
                <ul class="nav side-menu">

                    <li class=""><a><i class="fa fa-money"></i> Payment Services <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            @if (hasModulepermission('Invoices'))
                            <li class="current-page"><a href="{{ route('admin.company.invoices.list') }}">Invoices</a></li>
                            @endif
                            @if (hasModulepermission('Payments'))
                            <li class="current-page"><a href="{{ route('admin.payments') }}">Payments</a></li>
                            @endif
                            @if (hasModulepermission('Recurring Payments'))
                            <li class="current-page"><a href="{{ route('admin.payments.schedule.view') }}">Recurring Payments</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
            @endif

            @if (hasModulepermission('Payment Details'))
            <div class="menu_section">
                <h3>Payment Details</h3>
                <ul class="nav side-menu">
                    @if (hasModulepermission('Payment Services'))
                    <li class=""><a><i class="fa fa-money"></i> Payment Services <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            @if (hasModulepermission('Payment Method'))
                            <li class="current-page"><a href="{{ route('payment-method') }}">Payment Method</a></li>
                            @endif
                            @if (hasModulepermission('Payments'))
                            <li class="current-page"><a href="{{ route('admin.payments') }}">Payments</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            @endif
        </div>
        @endif
        @if(auth()->user() != null)

        @if (hasModulepermission('Logs'))
        <div class="menu_section">
            <ul class="nav side-menu">
                <li class=""><a href="{{ url(route('admin.logs')) }}"><i class="fa fa-history"></i> Logs</a>
                </li>
            </ul>
        </div>
        @endif
        @endif
        <!-- /sidebar menu -->
    </div>
</div>
