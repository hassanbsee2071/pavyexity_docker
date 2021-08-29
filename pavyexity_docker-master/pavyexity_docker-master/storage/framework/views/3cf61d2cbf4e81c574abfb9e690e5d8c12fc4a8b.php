<div class="top_nav">
    <div class="nav_menu">
        <nav>
        <?php if(auth()->user() != null): ?>
         
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
<?php endif; ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
        <?php if(auth()->user() != null): ?>
           
                        <img src="<?php echo e(auth()->user()->avatar); ?>" alt=""><?php echo e(auth()->user()->first_name . " " . auth()->user()->last_name); ?>

           <?php endif; ?>

                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
        <?php if(auth()->user() != null): ?>

                            <a href="<?php echo e(route('logout')); ?>">
                                <i class="fa fa-sign-out pull-right"></i> <?php echo e(__('views.backend.section.header.menu_0')); ?>

                            </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php /**PATH /var/www/resources/views/admin/sections/header.blade.php ENDPATH**/ ?>