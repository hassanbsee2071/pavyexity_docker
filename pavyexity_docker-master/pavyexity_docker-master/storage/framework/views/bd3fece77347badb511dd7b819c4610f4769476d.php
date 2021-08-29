

<?php $__env->startSection('title', 'Online Payment Links'); ?>

<?php $__env->startSection('content'); ?>
    
<div class="container">
<?php if(!Auth::user()->hasRole('Super User')): ?>
<a href="<?php echo e(url(route('online.payment.links.create'))); ?>" class="btn btn-success btn-primary" style="float: right;">Create</a>
    <!-- <a href="<?php echo e(url(route('online.payment.links.export'))); ?>" class="btn btn-info btn-primary" style="float: right;">Export Csv</a> -->
    <span data-href="/payvexitylive/online/payment/links/export/csv" id="export" class="btn btn-info btn-sm" onclick="exportTasks(event.target);">Export Csv</span>

   <?php endif; ?>
   
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    var PaymentLink = '<?php echo e(route('online.payment.links')); ?>';

    function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }

</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

<?php echo e(Html::script('assets/admin/js/payments/online.js')); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/payments/online/links.blade.php ENDPATH**/ ?>