

<?php $__env->startSection('title', 'Online Received Payments'); ?>

<?php $__env->startSection('content'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
var OnlinePaymentReceivedRoute = '<?php echo e(route('online.payment.received')); ?>';
</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

<?php echo e(Html::script('assets/admin/js/payments/online-received-payment.js')); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/payments/online/received.blade.php ENDPATH**/ ?>