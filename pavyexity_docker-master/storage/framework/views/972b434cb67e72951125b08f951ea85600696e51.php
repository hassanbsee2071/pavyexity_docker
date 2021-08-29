<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
    <div class="">
        <div class="pull-right">
            <?php if(!isSuperAdmin()): ?>
            <a class="btn btn-success" href="<?php echo e(route('admin.payments.one-time-payment')); ?>">One time Payment</a>
            <a class="btn btn-success" href="<?php echo e(route('admin.payments.importcsv')); ?>">Bulk Payment</a>
    <span data-href="/payvexitylive/admin/payment/export/csv" id="export" class="btn btn-info btn-sm" onclick="exportTasks(event.target);">Export Csv</span>

           
            <!-- <button class="btn btn-success" data-target="#bulk_upload_modal" data-toggle="modal">Bulk Payment</button> -->
            <?php endif; ?>
        </div>
        <div id="paymentFieldList">
            <div class="mb-4">
                <div class="">
                    <h3>Fields to display</h3>
                    
                    <div class="list_view">
                    <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="0" checked> Email </label>
                        <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="1" checked> Transaction id </label>
                        <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="2" checked> Payment method </label>
                        <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="3" checked> status </label>
                        <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="4" > Created Date </label>
                        <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="5" > Updated Date </label>
                        <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="6" checked> Action </label>
                    </div><br>
                    
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" id="PaymentTable">
            <thead>
                <tr>
                    <td>Email</td>
                    <td>Transaction id</td>
                    <td>Payment method</td>
                    <td>status</td>
                    <td>Created Date</td>
                    <td>Updated Date</td>
                </tr>
                <tr id="search">
                    <td>Email</td>
                    <td>Transaction id</td>
                    <td>Payment method</td>
                    <td>status</td>
                    <td>Created Date</td>
                    <td>Updated Date</td>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
        <div class="pull-right">

        </div>
    </div>


    <div id="bulk_upload_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bulk Payment Upload</h4>
                </div>
                <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="<?php echo e(route('admin.bulk_payment_import')); ?>" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group<?php echo e($errors->has('csv_file') ? ' has-error' : ''); ?>">
                                <label for="csv_file" class="col-md-4 control-label">Please upload csv file</label>

                                <div class="col-md-6">
                                    <input id="csv_file" type="file" class="form-control" name="csv_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>

                                    <?php if($errors->has('csv_file')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('csv_file')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="header" hidden checked> 
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
var PaymentList = '<?php echo e(route('admin.payments')); ?>';
function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

<?php echo e(Html::script('assets/admin/js/payments/payment.js')); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/payments/show.blade.php ENDPATH**/ ?>