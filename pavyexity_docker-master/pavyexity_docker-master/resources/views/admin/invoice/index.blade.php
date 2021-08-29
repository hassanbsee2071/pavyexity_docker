@extends('admin.layouts.admin')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    @parent
@endsection
@section('title', __('views.admin.company.invoice.index.title'))
@section('content')
<div class="col-md-12">
<div class="pull-right">
    @if(isAdmin())
    <a href="{{route('admin.company.invoice.add')}}"><button type="button" class="btn btn-success">Add Invoice</button></a>
    <span data-href="/payvexitylive/admin/invoice/export/csv" id="export" class="btn btn-info btn-sm" onclick="exportTasks(event.target);">Export Csv</span>

    @endif
</div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered dt-responsive nowrap" id="comapny_invoice" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td>{{ __('views.admin.company.invoice.index.table_header_0') }}</td>
                <td>Amount</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_6') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_1') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_2') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_3') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_4') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_5') }}</td>
                <td>Actions</td>
            </tr>
            <tr id="search_input">
                <td>{{ __('views.admin.company.invoice.index.table_header_0') }}</td>
                <td>Amount</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_6') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_1') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_2') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_3') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_4') }}</td>
                <td>{{ __('views.admin.company.invoice.index.table_header_5') }}</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="pull-right">

    </div>
</div>
@endsection
@section('scripts')
    @parent
    <script>
        var InvoiceUrl = '{{ route('admin.company.invoices.list') }}';
        function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    {{ Html::script('assets/admin/js/invoice/index.js') }}
@endsection
