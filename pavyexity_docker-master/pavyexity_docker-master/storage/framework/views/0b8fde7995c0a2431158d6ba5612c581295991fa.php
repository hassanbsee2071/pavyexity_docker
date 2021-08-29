

<?php $__env->startSection('title', __('views.admin.users.index.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="row pull-right">
    <a href="<?php echo e(route('admin.users.add')); ?>"><button type="button" class="btn btn-success">Add User</button></a>
    <span data-href="/admin/users/export/csv" id="export" class="btn btn-info btn-sm" onclick="exportTasks(event.target);">Export Csv</span>

</div>
<div id="userFieldList">
        <div class="mb-4">
            <div class="">
                <h3>Fields to display</h3>
                
                <div class="list_view">
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="0" checked>Email</label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="1" checked> Username</label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="2" checked> Roles </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="3" > Phone </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="4" checked> Status </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="5" checked> Created </label>
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="6" checked> Action </label>
                </div><br>
                
            </div>
        </div>
    </div>

<div class="">
    <!-- <input type="text" name="email" class="form-control searchEmail" placeholder="Search for Email Only...">
    <br> -->
    <table class="table UserTable table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" id="UserTable">
        <thead>
            <tr>
                <th><?php echo e(__('views.admin.users.index.table_header_0')); ?></th>
                <th><?php echo e(__('views.admin.users.index.table_header_1')); ?></th>
                <th><?php echo e(__('views.admin.users.index.table_header_2')); ?></th>
                <th><?php echo e(__('views.admin.company.index.table_header_11')); ?></th>
                <th><?php echo e(__('views.admin.users.index.table_header_3')); ?></th>
                <th><?php echo e(__('views.admin.users.index.table_header_5')); ?></th>
                <!-- <th>Action</th> -->
            </tr>
            <tr id="search">
                <td><?php echo e(__('views.admin.users.index.table_header_0')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_1')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_2')); ?></td>
                <td><?php echo e(__('views.admin.company.index.table_header_11')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_3')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_5')); ?></td>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>

        </tbody>
        <!-- <tfoot>
            <tr>
                <td><?php echo e(__('views.admin.users.index.table_header_0')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_1')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_2')); ?></td>
                <td><?php echo e(__('views.admin.company.index.table_header_11')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_3')); ?></td>
                <td><?php echo e(__('views.admin.users.index.table_header_5')); ?></td>
            </tr>
        </tfoot> -->
    </table>
    <div class="pull-right">

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
var userList = '<?php echo e(route('admin.users')); ?>';
// alert(userList);
function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

<?php echo e(Html::script('assets/admin/js/users/add.js')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/users/index.blade.php ENDPATH**/ ?>