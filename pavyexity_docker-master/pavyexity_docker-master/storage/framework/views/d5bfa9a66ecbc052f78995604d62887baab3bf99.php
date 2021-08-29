<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
    <!-- page content -->
    <!-- top tiles -->
    <div class="row tile_count">
        <form method="GET" class="mb-3">
            <div class="col-xl-5 col-md-5 col-sm-12 form-group">
                <label for="start">From Date:</label>
                <input type="date" name="start" class="form-control" value="<?php echo e(request()->start ?? ''); ?>" />
            </div>
            <div class="col-xl-5 col-md-5 col-sm-12 form-group">
                <label for="end">To Date:</label>
                <input type="date" name="end" class="form-control" value="<?php echo e(request()->end ?? ''); ?>" />
            </div>
            <div class="col-xl-2 col-md-2 col-sm-12 form-group">
                <input type="submit" class="btn btn-lg btn-success" style="margin-top: 20px;" value="Search" />
            </div>
        </form><br>
        
        <!-- company wise total user -->
         <?php if(Auth::user()->hasRole('Admin User')): ?>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-users"></i><br>
                    <span class="count_top"> Company Users</span>
                    <div class="count green"><?php echo e($counts['users']); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-shopping-cart "></i><br>
                    <span class="count_top"> Payments Amounts</span>
                    <div>
                        <span class="count green"><?php echo e($counts['paymemts_amounts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-money"></i><br>
                    <span class="count_top"> Total Payments</span>
                    <div>
                        <span class="count green"><?php echo e($counts['total_paymemts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-file"></i><br>
                    <span class="count_top"> Invoice Amounts</span>
                    <div>
                        <span class="count green"><?php echo e($counts['invoice_amounts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-list"></i><br>
                    <span class="count_top"> Total Invoice Sent</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['users'] - $counts['users_inactive']); ?></span> -->
                        <span class="count green"><?php echo e($counts['invoice_sent']); ?></span>
                        <!-- <span class="count">/</span> -->
                        <!-- <span class="count red"><?php echo e($counts['users_inactive']); ?></span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-lock"></i><br>
                    <span class="count_top"> Total Invoice Paid</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['protected_pages']); ?></span> -->
                        <span class="count green"><?php echo e($counts['invoice_paid']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php elseif(Auth::user()->hasRole('Super User')): ?>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-users"></i><br>
                    <span class="count_top"> Total Users</span>
                    <div class="count green"><?php echo e($counts['users']); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-address-card"></i><br>
                    <span class="count_top"> Total Company</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['users'] - $counts['users_unconfirmed']); ?></span> -->
                        <span class="count green"><?php echo e($counts['total_company']); ?></span>
                        <!-- <span class="count">/</span>
                        <span class="count red"><?php echo e($counts['users_unconfirmed']); ?></span> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-shopping-cart "></i><br>
                    <span class="count_top"> Payments Amounts</span>
                    <div>
                        <span class="count green"><?php echo e($counts['paymemts_amounts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-money"></i><br>
                    <span class="count_top"> Total Payments</span>
                    <div>
                        <span class="count green"><?php echo e($counts['total_paymemts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-file"></i><br>
                    <span class="count_top"> Invoice Amounts</span>
                    <div>
                        <span class="count green"><?php echo e($counts['invoice_amounts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-list"></i><br>
                    <span class="count_top"> Total Invoice Sent</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['users'] - $counts['users_inactive']); ?></span> -->
                        <span class="count green"><?php echo e($counts['invoice_sent']); ?></span>
                        <!-- <span class="count">/</span> -->
                        <!-- <span class="count red"><?php echo e($counts['users_inactive']); ?></span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-lock"></i><br>
                    <span class="count_top"> Total Invoice Paid</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['protected_pages']); ?></span> -->
                        <span class="count green"><?php echo e($counts['invoice_paid']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <?php elseif(Auth::user()->hasRole('User')): ?>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-shopping-cart "></i><br>
                    <span class="count_top"> Payments Amounts</span>
                    <div>
                        <span class="count green"><?php echo e($counts['paymemts_amounts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-money"></i><br>
                    <span class="count_top"> Total Payments</span>
                    <div>
                        <span class="count green"><?php echo e($counts['total_paymemts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-file"></i><br>
                    <span class="count_top"> Invoice Amounts</span>
                    <div>
                        <span class="count green"><?php echo e($counts['invoice_amounts']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-list"></i><br>
                    <span class="count_top"> Total Invoice Sent</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['users'] - $counts['users_inactive']); ?></span> -->
                        <span class="count green"><?php echo e($counts['invoice_sent']); ?></span>
                        <!-- <span class="count">/</span> -->
                        <!-- <span class="count red"><?php echo e($counts['users_inactive']); ?></span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4 col-sm-6 widget">
            <div class="card shadow border-left-default py-2">
                <div class="card-body text-center">
                    <i class="fa fa-lock"></i><br>
                    <span class="count_top"> Total Invoice Paid</span>
                    <div>
                        <!-- <span class="count green"><?php echo e($counts['protected_pages']); ?></span> -->
                        <span class="count green"><?php echo e($counts['invoice_paid']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- /top tiles -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
    <?php echo e(Html::script(mix('assets/admin/js/dashboard.js'))); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    ##parent-placeholder-bf62280f159b1468fff0c96540f3989d41279669##
    <?php echo e(Html::style(mix('assets/admin/css/dashboard.css'))); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>