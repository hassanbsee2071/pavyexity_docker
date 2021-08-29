

<?php $__env->startSection('body_class','nav-md'); ?>
<?php $__env->startSection('page'); ?>
    <div class="container body">
        <div class="main_container">
            <?php $__env->startSection('header'); ?>
                <?php echo $__env->make('admin.sections.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('admin.sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldSection(); ?>

            <?php echo $__env->yieldContent('left-sidebar'); ?>

            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h1 class="h3"><?php echo $__env->yieldContent('title'); ?></h1>
                    </div>
                    <?php if(Breadcrumbs::exists()): ?>
                        <div class="title_right">
                            <div class="pull-right">
                                <?php echo Breadcrumbs::render(); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <footer>
                <?php echo $__env->make('admin.sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </footer>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <?php echo e(Html::style(mix('assets/admin/css/admin.css'))); ?>

    <?php echo e(Html::style('assets/admin/css/bootstrap-datetimepicker.css')); ?>

    <?php echo e(Html::style('assets/admin/css/select2.min.css')); ?>


    <!-- <?php echo e(Html::style('assets/admin/css/jquery.dataTables1.10.16.min.css')); ?> -->
    <?php echo e(Html::style('assets/admin/css/dataTables.bootstrap4-1.10.19.min.css')); ?> 
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo e(Html::script(mix('assets/admin/js/admin.js'))); ?>

    <?php echo e(Html::script('https://code.jquery.com/jquery-3.5.1.js')); ?>


    <?php echo e(Html::script('assets/admin/js/jquery.validate.min.js')); ?>

    <?php echo e(Html::script('assets/admin/js/moment.js')); ?>

    <?php echo e(Html::script('assets/admin/js/bootstrap-datetimepicker.min.js')); ?>

    <?php echo e(Html::script('assets/admin/js/select2.min.js')); ?>



    <?php echo e(Html::script('assets/admin/js/jquery.dataTables-1.10.16.min.js')); ?>

    <?php echo e(Html::script('assets/admin/js/bootstrap-4.1.3.min.js')); ?>

    <?php echo e(Html::script('assets/admin/js/dataTables.bootstrap4-1.10.19.min.js')); ?>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/layouts/errors-layout.blade.php ENDPATH**/ ?>