@extends('admin.layouts.admin')

@section('title', __('views.admin.company.index.title'))

@section('content')

<div class="row pull-right">
    <a href="{{route('admin.company.add')}}"><button type="button" class="btn btn-success">Add Company</button></a>
</div>
<div id="companyFieldList">
        <div class="mb-4">
            <div class="">
                <h3>Fields to display</h3>
                {{-- dynamic table design code starts here --}}
                <div class="list_view">
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="0" checked> Email </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="1" checked> Phone </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="2" checked> Company admin </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="3" checked> Company name </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="4" > EIN </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="5" > Address </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="6" > API Key </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="7" > API user </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="8" > Accept Payment </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="9" checked> Created at </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="10" checked> Action </label>
                </div><br>
                {{-- dynamic table design code ends here --}}
            </div>
        </div>
    </div>
<div class="" >

    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" id="CompanyTable"
           width="100%">
        <thead>
            <tr>
                <th>Email</th>
                <th>Phone</th>
                <th>Company admin</th>
                <th>Company name</th>
                <th>EIN</th>
                <th>Address</th>
                <th>API Key</th>
                <th>API user</th>
                <th>Accept Payment</th>
                <th>Created at</th>
                <!-- <th>Actions</th> -->
            </tr>
            <tr id="search">
                <td>Email</td>
                <td>Phone</td>
                <td>Company admin</td>
                <td>Company name</td>
                <td>EIN</td>
                <td>Address</td>
                <td>API Key</td>
                <td>API user</td>
                <td>Accept Payment</td>
                <td>Created at</td>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <!-- <tfoot>
            <tr>
                <td>Email</td>
                <td>Phone</td>
                <td>Company admin</td>
                <td>Company name</td>
                <td>Address</td>
                <td>Created at</td>
                <td>Accept Payment</td>
            </tr>
        </tfoot> -->
    </table>
    <script>
    </script>
    <div class="pull-right">
    </div>
    
</div>
@endsection
@section('scripts')
<script>
var CompanySettingList = '{{ route('admin.company') }}';

</script>
@parent

{{ Html::script('assets/admin/js/company/add.js') }}

@endsection

