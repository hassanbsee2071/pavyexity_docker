@extends('admin.layouts.admin')

@section('title', __('views.admin.users.index.title'))

@section('content')
<div class="row pull-right">
    <a href="{{route('admin.users.add')}}"><button type="button" class="btn btn-success">Add User</button></a>
    <span data-href="/admin/users/export/csv" id="export" class="btn btn-info btn-sm" onclick="exportTasks(event.target);">Export Csv</span>

</div>
<div id="userFieldList">
        <div class="mb-4">
            <div class="">
                <h3>Fields to display</h3>
                {{-- dynamic table design code starts here --}}
                <div class="list_view">
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="0" checked>Email</label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="1" checked> Username</label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="2" checked> Roles </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="3" > Phone </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="4" checked> Status </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="5" checked> Created </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="6" checked> Action </label>
                </div><br>
                {{-- dynamic table design code ends here --}}
            </div>
        </div>
    </div>

<div class="">
    <!-- <input type="text" name="email" class="form-control searchEmail" placeholder="Search for Email Only...">
    <br> -->
    <table class="table UserTable table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" id="UserTable">
        <thead>
            <tr>
                <th>{{ __('views.admin.users.index.table_header_0') }}</th>
                <th>{{ __('views.admin.users.index.table_header_1') }}</th>
                <th>{{ __('views.admin.users.index.table_header_2') }}</th>
                <th>{{ __('views.admin.company.index.table_header_11') }}</th>
                <th>{{__('views.admin.users.index.table_header_3')}}</th>
                <th>{{__('views.admin.users.index.table_header_5')}}</th>
                <!-- <th>Action</th> -->
            </tr>
            <tr id="search">
                <td>{{ __('views.admin.users.index.table_header_0') }}</td>
                <td>{{ __('views.admin.users.index.table_header_1') }}</td>
                <td>{{ __('views.admin.users.index.table_header_2') }}</td>
                <td>{{ __('views.admin.company.index.table_header_11') }}</td>
                <td>{{__('views.admin.users.index.table_header_3')}}</td>
                <td>{{__('views.admin.users.index.table_header_5')}}</td>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>

        </tbody>
        <!-- <tfoot>
            <tr>
                <td>{{ __('views.admin.users.index.table_header_0') }}</td>
                <td>{{ __('views.admin.users.index.table_header_1') }}</td>
                <td>{{ __('views.admin.users.index.table_header_2') }}</td>
                <td>{{ __('views.admin.company.index.table_header_11') }}</td>
                <td>{{__('views.admin.users.index.table_header_3')}}</td>
                <td>{{__('views.admin.users.index.table_header_5')}}</td>
            </tr>
        </tfoot> -->
    </table>
    <div class="pull-right">

    </div>
</div>
@endsection
@section('scripts')
<script>
var userList = '{{ route('admin.users') }}';
// alert(userList);
function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
@parent

{{ Html::script('assets/admin/js/users/add.js') }}
@endsection
