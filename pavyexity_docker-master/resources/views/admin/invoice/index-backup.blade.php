@extends('admin.layouts.admin')
@section('title', __('views.admin.company.invoice.index.title'))
@section('content')
<div class="row pull-right">
    @if(isAdmin())
    <a href="{{route('admin.company.invoice.add')}}"><button type="button" class="btn btn-success">Add Invoice</button></a>
    @endif
</div>
<div class="row">
    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>@sortablelink('invoice_number', __('views.admin.company.invoice.index.table_header_0'),['page' => $all_invoice->currentPage()])</th>
                <th>Amount</th>
                <th>{{ __('views.admin.company.invoice.index.table_header_6') }}</th>
                <th>@sortablelink('invoice_title',  __('views.admin.company.invoice.index.table_header_1'),['page' => $all_invoice->currentPage()])</th>
                <th>{{ __('views.admin.company.invoice.index.table_header_2') }}</th>
                <th>{{ __('views.admin.company.invoice.index.table_header_3') }}</th>
                <th>{{ __('views.admin.company.invoice.index.table_header_4') }}</th>
                <th>@sortablelink('created_at', __('views.admin.company.invoice.index.table_header_5'),['page' => $all_invoice->currentPage()])</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_invoice as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->amount }}</td>
                <td>
                    @if(is_numeric($invoice->user_id) )
                        {{ getUserInfoById($invoice->user_id) }}
                    @else
                        {{ $invoice->user_id }}
                    @endif
                </td>
                <td>{{ $invoice->invoice_title }}</td>
                <td>{{ date("Y-m-d", strtotime($invoice->due_date)) }}</td>
                <td>{{ date("Y-m-d", strtotime($invoice->invoice_date)) }}</td>
                <td>{{ $invoice->status }}</td>
                <td>{{ $invoice->created_at }}</td>
                <td>
                    <a class="btn btn-xs btn-info" href="{{ route('admin.company.invoice.edit', [$invoice->id]) }}" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.company.invoice.index.edit') }}">
                        <i class="fa fa-pencil"></i>
                    </a>

                    <a href="{{ route('admin.company.invoice.destroy', [$invoice->id]) }}" class="btn btn-xs btn-danger user_destroy" data-toggle="tooltip" data-placement="top" data-title="{{ __('views.admin.company.invoice.index.delete') }}">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">No record found.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    <div class="pull-right">
        {!! $all_invoice->links() !!}
    </div>
</div>
@endsection
