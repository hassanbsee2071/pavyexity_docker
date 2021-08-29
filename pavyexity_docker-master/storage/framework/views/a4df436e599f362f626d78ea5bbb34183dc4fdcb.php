

<?php $__env->startSection('title', 'Payments Links Edit'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        <?php echo e(Form::open(['route'=>['online.payment.links.update', ['id' => $paymentLink->id]],'method' => 'put','class'=>'form-horizontal form-label-left', 'name' => "payment_link"])); ?>

        <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="text-danger"><?php echo e($error); ?></span><br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Payment Link Name
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('name')): ?> parsley-error <?php endif; ?>" name="name" value="<?php echo e($paymentLink->name); ?>" >

            </div>
        </div>
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Enable Link
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="is_enable" type="checkbox" class="form-control <?php if($errors->has('is_enable')): ?> parsley-error <?php endif; ?>" name="is_enable" <?php echo e($paymentLink->is_enable ? 'checked' : ''); ?> >
            </div>
        </div> -->

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Enable Link
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                    <input id="is_enable" type="checkbox" class="<?php if($errors->has('is_enable')): ?> parsley-error <?php endif; ?>" style="height: 20px; width: 20px;" name="is_enable" <?php echo e($paymentLink->is_enable ? 'checked' : ''); ?> >
                        </ul>
                    </label>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-dark text-white" > Update </button>
            <a href="<?php echo e(URL::previous()); ?>"><button class="btn btn-dark text-white" type="button" > Cancel </button></a>
        </div>




        <?php echo e(Form::close()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var CompanySettingList = '<?php echo e(route('admin.company')); ?>';
</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<?php echo e(Html::script('assets/admin/js/company/add.js')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/payments/online/edit-link.blade.php ENDPATH**/ ?>