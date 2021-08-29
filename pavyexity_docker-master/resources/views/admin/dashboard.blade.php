@extends('admin.layouts.admin')

@section('title', 'Reports')

@section('content')
    <!-- page content -->
    <!-- top tiles -->
    <div class="row tile_count">
        <form method="GET" class="mb-3">
            <div class="col-xl-5 col-md-5 col-sm-12 form-group">
                <label for="start">From Date:</label>
                <input type="date" name="start" class="form-control" value="{{ request()->start ?? '' }}" />
            </div>
            <div class="col-xl-5 col-md-5 col-sm-12 form-group">
                <label for="end">To Date:</label>
                <input type="date" name="end" class="form-control" value="{{ request()->end ?? '' }}" />
            </div>
            <div class="col-xl-2 col-md-2 col-sm-12 form-group">
                <input type="submit" class="btn btn-lg btn-success" style="margin-top: 20px;" value="Search" />
            </div>
        </form><br>
        
        <!-- company wise total user -->
         @if(Auth::user()->hasRole('Admin User'))
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-users"></i><br>
                    <span class="count_top"> Company Users</span>
                    <div class="count green">{{ $counts['users'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-shopping-cart "></i><br>
                    <span class="count_top"> Payments Amounts</span>
                    <div>
                        <span class="count green">{{  $counts['paymemts_amounts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-money"></i><br>
                    <span class="count_top"> Total Payments</span>
                    <div>
                        <span class="count green">{{  $counts['total_paymemts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-file"></i><br>
                    <span class="count_top"> Invoice Amounts</span>
                    <div>
                        <span class="count green">{{  $counts['invoice_amounts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-list"></i><br>
                    <span class="count_top"> Total Invoice Sent</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['users'] - $counts['users_inactive'] }}</span> -->
                        <span class="count green">{{  $counts['invoice_sent'] }}</span>
                        <!-- <span class="count">/</span> -->
                        <!-- <span class="count red">{{ $counts['users_inactive'] }}</span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-lock"></i><br>
                    <span class="count_top"> Total Invoice Paid</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['protected_pages'] }}</span> -->
                        <span class="count green">{{  $counts['invoice_paid'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @elseif(Auth::user()->hasRole('Super User'))
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-users"></i><br>
                    <span class="count_top"> Total Users</span>
                    <div class="count green">{{ $counts['users'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-address-card"></i><br>
                    <span class="count_top"> Total Company</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['users'] - $counts['users_unconfirmed'] }}</span> -->
                        <span class="count green">{{  $counts['total_company']  }}</span>
                        <!-- <span class="count">/</span>
                        <span class="count red">{{ $counts['users_unconfirmed'] }}</span> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-shopping-cart "></i><br>
                    <span class="count_top"> Payments Amounts</span>
                    <div>
                        <span class="count green">{{  $counts['paymemts_amounts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-money"></i><br>
                    <span class="count_top"> Total Payments</span>
                    <div>
                        <span class="count green">{{  $counts['total_paymemts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-file"></i><br>
                    <span class="count_top"> Invoice Amounts</span>
                    <div>
                        <span class="count green">{{  $counts['invoice_amounts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-list"></i><br>
                    <span class="count_top"> Total Invoice Sent</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['users'] - $counts['users_inactive'] }}</span> -->
                        <span class="count green">{{  $counts['invoice_sent'] }}</span>
                        <!-- <span class="count">/</span> -->
                        <!-- <span class="count red">{{ $counts['users_inactive'] }}</span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-lock"></i><br>
                    <span class="count_top"> Total Invoice Paid</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['protected_pages'] }}</span> -->
                        <span class="count green">{{  $counts['invoice_paid'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        @elseif(Auth::user()->hasRole('User'))
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-shopping-cart "></i><br>
                    <span class="count_top"> Payments Amounts</span>
                    <div>
                        <span class="count green">{{  $counts['paymemts_amounts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-money"></i><br>
                    <span class="count_top"> Total Payments</span>
                    <div>
                        <span class="count green">{{  $counts['total_paymemts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-file"></i><br>
                    <span class="count_top"> Invoice Amounts</span>
                    <div>
                        <span class="count green">{{  $counts['invoice_amounts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-list"></i><br>
                    <span class="count_top"> Total Invoice Sent</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['users'] - $counts['users_inactive'] }}</span> -->
                        <span class="count green">{{  $counts['invoice_sent'] }}</span>
                        <!-- <span class="count">/</span> -->
                        <!-- <span class="count red">{{ $counts['users_inactive'] }}</span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-lock"></i><br>
                    <span class="count_top"> Total Invoice Paid</span>
                    <div>
                        <!-- <span class="count green">{{  $counts['protected_pages'] }}</span> -->
                        <span class="count green">{{  $counts['invoice_paid'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- /top tiles -->

@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection
