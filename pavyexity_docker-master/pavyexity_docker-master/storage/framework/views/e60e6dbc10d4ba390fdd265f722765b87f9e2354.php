

<?php $__env->startSection('title',__('views.admin.users.edit.title', ['name' => $user->first_name . " ". $user->last_name]) ); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        <?php echo e(Form::open(['route'=>['admin.users.update', $user->id],'method' => 'put','class'=>'form-horizontal form-label-left', 'name' => "frmuser"])); ?>

        <?php if(count($errors) > 0): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="text-danger"><?php echo e($error); ?></span><br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">First Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('first_name')): ?> parsley-error <?php endif; ?>" name="first_name" value="<?php if(!empty($user->first_name)): ?><?php echo e($user->first_name); ?><?php elseif(old('first_name')): ?><?php echo e(old('first_name')); ?><?php endif; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Last Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="last_name" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('last_name')): ?> parsley-error <?php endif; ?>" name="last_name" value="<?php if(!empty($user->last_name)): ?><?php echo e($user->last_name); ?><?php elseif(old('last_name')): ?><?php echo e(old('last_name')); ?><?php endif; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('email')): ?> parsley-error <?php endif; ?>" name="email" value="<?php if(!empty($user->email)): ?><?php echo e($user->email); ?><?php elseif(old('email')): ?><?php echo e(old('email')); ?><?php endif; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('phone')): ?> parsley-error <?php endif; ?>" name="phone" value="<?php if(!empty($user->phone)): ?><?php echo e($user->phone); ?><?php elseif(old('phone')): ?><?php echo e(old('phone')); ?><?php endif; ?>"  />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password" >
                Password
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="password" class="form-control col-md-7 col-xs-12 <?php if($errors->has('password')): ?> parsley-error <?php endif; ?>"
                       name="password" value="" />
            </div>
        </div>


        <?php if(!$user->hasRole('Super User')): ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="active" >
                <?php echo e(__('views.admin.users.edit.active')); ?>

            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input id="active" type="checkbox" class="<?php if($errors->has('active')): ?> parsley-error <?php endif; ?>"
                               name="active" <?php if($user->active): ?> checked="checked" <?php endif; ?> value="1">
                               <?php if($errors->has('active')): ?>
                               <ul class="parsley-errors-list filled">
                            <?php $__currentLoopData = $errors->get('active'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="parsley-required"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if(1==2): ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmed" >
                <?php echo e(__('views.admin.users.edit.confirmed')); ?>

            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input id="confirmed" type="checkbox" class="<?php if($errors->has('confirmed')): ?> parsley-error <?php endif; ?>"
                               name="confirmed" <?php if($user->confirmed): ?> checked="checked" <?php endif; ?> value="1">
                               <?php if($errors->has('confirmed')): ?>
                               <ul class="parsley-errors-list filled">
                            <?php $__currentLoopData = $errors->get('confirmed'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="parsley-required"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(isSuperAdmin()): ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmed" >
                Select roles
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="checkbox">
                    <label>
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="<?php echo e($role->id); ?>"
                            <?php if($user->hasRole($role->name)): ?> checked="checked" <?php endif; ?>>
                            <?php echo e($role->name); ?>

                    </label>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if(isSuperAdmin()): ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmed" >
                Select Access
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="checkbox">
                    <label>
                        <input
                            type="checkbox"
                            name="modules[]"
                            value="<?php echo e($module->id); ?>"
                            <?php if($user->hasPermissionToModule($module->name)): ?> checked="checked" <?php endif; ?>>
                            <?php echo e($module->name); ?>

                    </label>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

<!--        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a class="btn btn-primary" href="<?php echo e(URL::previous()); ?>"> <?php echo e(__('views.admin.users.edit.cancel')); ?></a>
                <button type="submit" class="btn btn-success"> <?php echo e(__('views.admin.users.edit.save')); ?></button>
            </div>
        </div>-->
        <div class="text-center">
            <button type="submit" class="btn btn-dark text-white">Update</button>
            <a href="<?php echo e(URL::previous()); ?>"><button class="btn btn-dark text-white" type="button" > <?php echo e(__('views.admin.users.edit.cancel')); ?> </button></a>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
##parent-placeholder-bf62280f159b1468fff0c96540f3989d41279669##
<?php echo e(Html::style(mix('assets/admin/css/users/edit.css'))); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<?php echo e(Html::script(mix('assets/admin/js/users/edit.js'))); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/users/edit.blade.php ENDPATH**/ ?>