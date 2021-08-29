@extends('admin.layouts.admin')

@section('title', 'Online Received Payments')

@section('content')
<div class="table-responsive">
        <!-- <div class="card-body"> -->
            <table id="received" class="table table-striped table-bordered" style="width:100%; font-weight: 100 !important; font-size:16px !important;">
                <thead>
                    <tr>
                        <td>Sr.no</td>
                        <td>Payment Method</td>
                        <td>Payment Amount</td>
                        <td>Email</td>
                        <td>Received at</td>
                        <td>Actions</td>
                    </tr>
                    <tr id="search_input">
                        <td>Sr.no</td>
                        <td>Payment Method</td>
                        <td>Payment Amount</td>
                        <td>Email</td>
                        <td>Received at</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        <!-- </div> -->
    </div>
@endsection
@section('scripts')
<script>
var OnlinePaymentReceivedRoute = '{{ route('online.payment.received') }}';
</script>
@parent

{{ Html::script('assets/admin/js/payments/online-received-payment.js') }}

@endsection
