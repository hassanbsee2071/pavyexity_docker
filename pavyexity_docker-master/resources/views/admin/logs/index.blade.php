@extends('admin.layouts.admin')

@section('title', 'Logs')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    @parent
@endsection

@section('content')
    @if (isSuperAdmin())
    <div class="card shadow">
        <div class="PaymentTable_wrapper" style="background-color: #fff; border-radius: 12px; padding: 16px; border: 1px #a09d9d; box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .45)!important;">
            <table id="logs" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%; font-size: 11px !important;">
                <thead>
                    <tr>
                        <td>Sr.no</td>
                        <td>Customer Name</td>
                        <td>Category</td>
                        <td>Request Data</td>
                        <td>Response Data</td>
                        <td>Request at</td>
                    </tr>
                    <tr id="search_input">
                        <td>Sr.no</td>
                        <td>Customer Name</td>
                        <td>Category</td>
                        <td>Request Data</td>
                        <td>Response Data</td>
                        <td>Request at</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="log-request-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <pre lang="js" id="request-modal-data"></pre>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="log-response-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <pre lang="js" id="response-modal-data"></pre>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endif
@endsection
@section('scripts')
@parent
<script>
    var LogRoute = '{{ route('admin.logs') }}';
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
{{ Html::script('assets/admin/js/logs/index.js') }}
@endsection
