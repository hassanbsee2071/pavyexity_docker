<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="site_title">
                <img src="<?php echo e(asset('/images/logo.png')); ?>" alt="Logo" title="Logo" class="img-fluid" />
            </a>
            <div class="sidebar-divider"></div>
        </div>

        <div class="clearfix"></div>

      
        <br />

        <?php if(auth()->user() != null): ?>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <!-- <h3><?php echo e(__('views.backend.section.navigation.sub_header_0')); ?></h3> -->
                <ul class="nav side-menu">
                    <li>
                        <a href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <?php echo e(__('views.backend.section.navigation.menu_0_1')); ?>

                        </a>
                    </li>
                </ul>
                <?php if(hasModulepermission('Online Payments')): ?>
                <ul class="nav side-menu">

                    <li class=""><a><i class="fa fa-credit-card"></i> Online Payment Service <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <li class="current-page">
                                
                            <a href="<?php echo e(route('online.payment.links')); ?>">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Payment Links
                                </a>
                            </li>
                            <li class="current-page">
                                <a href="<?php echo e(route('online.payment.received')); ?>">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Received Payment
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php endif; ?>
                <?php if(hasModulepermission('Settings')): ?>
                <ul class="nav side-menu">

                    <li class=""><a><i class="fa fa-cogs"></i> Settings <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <?php if(hasModulepermission('Users')): ?>
                            <li class="current-page">
                                <a href="<?php echo e(route('admin.users')); ?>">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Users
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(isSuperAdmin()): ?>
                            <li class="current-page">
                                <a href="<?php echo e(route('admin.company')); ?>">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Company Management
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(isSuperAdmin()): ?>
                            <li class="current-page">
                                <a href="<?php echo e(route('admin.email_template')); ?>">
                                    <!-- <i class="fa fa-envelope" aria-hidden="true"></i> -->
                                    Email Management
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(isSuperAdmin()): ?>
                            <li class="current-page">
                                <a href="<?php echo e(route('admin.smtp')); ?>">
                                    <!-- <i class="fa fa-envelope" aria-hidden="true"></i> -->
                                    SMTP Setting
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(isAdmin()): ?>
                            <li class="current-page">
                                <a href="<?php echo e(route('admin.company.edit', ['id' => Session::get('admin_company_id')])); ?>">
                                    <!-- <i class="fa fa-users" aria-hidden="true"></i> -->
                                    Edit Company</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
            <?php if(hasModulepermission('Payment Services')): ?>
            <div class="menu_section">
                <!-- <h3>Payment</h3> -->
                <ul class="nav side-menu">

                    <li class=""><a><i class="fa fa-money"></i> Payment Services <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <?php if(hasModulepermission('Invoices')): ?>
                            <li class="current-page"><a href="<?php echo e(route('admin.company.invoices.list')); ?>">Invoices</a></li>
                            <?php endif; ?>
                            <?php if(hasModulepermission('Payments')): ?>
                            <li class="current-page"><a href="<?php echo e(route('admin.payments')); ?>">Payments</a></li>
                            <?php endif; ?>
                            <?php if(hasModulepermission('Recurring Payments')): ?>
                            <li class="current-page"><a href="<?php echo e(route('admin.payments.schedule.view')); ?>">Recurring Payments</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php endif; ?>

            <?php if(hasModulepermission('Payment Details')): ?>
            <div class="menu_section">
                <h3>Payment Details</h3>
                <ul class="nav side-menu">
                    <?php if(hasModulepermission('Payment Services')): ?>
                    <li class=""><a><i class="fa fa-money"></i> Payment Services <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                            <?php if(hasModulepermission('Payment Method')): ?>
                            <li class="current-page"><a href="<?php echo e(route('payment-method')); ?>">Payment Method</a></li>
                            <?php endif; ?>
                            <?php if(hasModulepermission('Payments')): ?>
                            <li class="current-page"><a href="<?php echo e(route('admin.payments')); ?>">Payments</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if(auth()->user() != null): ?>

        <?php if(hasModulepermission('Logs')): ?>
        <div class="menu_section">
            <ul class="nav side-menu">
                <li class=""><a href="<?php echo e(url(route('admin.logs'))); ?>"><i class="fa fa-history"></i> Logs</a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <!-- /sidebar menu -->
    </div>
</div>
<?php /**PATH /var/www/resources/views/admin/sections/navigation.blade.php ENDPATH**/ ?>