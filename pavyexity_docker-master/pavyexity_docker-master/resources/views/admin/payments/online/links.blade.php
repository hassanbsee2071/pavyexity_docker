@extends('admin.layouts.admin')

@section('title', 'Online Payment Links')

@section('content')
    
<div class="container">
@if(!Auth::user()->hasRole('Super User'))
<a href="{{ url(route('online.payment.links.create')) }}" class="btn btn-success btn-primary" style="float: right;">Create</a>
    <!-- <a href="{{ url(route('online.payment.links.export')) }}" class="btn btn-info btn-primary" style="float: right;">Export Csv</a> -->
    <span data-href="/payvexitylive/online/payment/links/export/csv" id="export" class="btn btn-info btn-sm" onclick="exportTasks(event.target);">Export Csv</span>

   @endif
   
    </div>


    <div class="table-responsive">
        <!-- <div class="card-body"> -->
            <table id="links" class="table table-striped table-bordered" style=" font-weight: 100 !important; font-size:16px !important;">
                <thead>
                    <tr>
                        <td>Sr.no</td>
                        <td>Name</td>
                        <td>Link</td>
                        <td>Is Enable</td>
                        <td>Created at</td>
                        <td>Actions</td>
                    </tr>
                    <tr id="search_input">
                        <td>Sr.no</td>
                        <td>Name</td>
                        <td>Link</td>
                        <td>Is Enable</td>
                        <td>Created at</td>
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
    var PaymentLink = '{{ route('online.payment.links') }}';

    function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }

</script>
@parent

{{ Html::script('assets/admin/js/payments/online.js') }}

@endsection
