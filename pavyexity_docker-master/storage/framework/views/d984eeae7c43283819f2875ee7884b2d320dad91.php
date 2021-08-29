
<?php $__env->startSection('title', 'Edit Company'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        <?php echo e(Form::open(['route'=>['admin.company.update', $company->id],'method' => 'post','class'=>'form-horizontal form-label-left','name' => "frmcompany"])); ?>

        <?php if(isSuperAdmin()): ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_admin" >Company Admin<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php $__currentLoopData = $decoded_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <select name="company_admin[]" id="company_admin" class="form-control <?php if($errors->has('company_admin')): ?> parsley-error <?php endif; ?>">
                    <option value="" <?php if(old('company_admin')==""): ?><?php echo e("selected"); ?><?php endif; ?>>-- Select Company Admin --</option>
                    <?php if(!empty($company_data)): ?>
                    <?php $__currentLoopData = $company_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($admin->id); ?>" <?php if(!empty($company->user_id) && $d==$admin->id): ?><?php echo e("selected"); ?><?php elseif(old('company_admin')==$admin->id): ?><?php echo e("selected"); ?><?php endif; ?>><?php echo e($admin->first_name . " " . $admin->last_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="button" name="add" id="add" class="btn btn-success" onclick="addMoreAdmins()"><i class="fa fa-plus"></i></button>
        </div>
        <div id="newAdmin">
            
        </div>
        <?php elseif(isAdmin()): ?>
        <input type="hidden" name="company_admin[]" id="company_admin" value="<?php echo e($user->id); ?>" />
        <?php endif; ?>

        <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Company Name
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="company_name" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('name')): ?> parsley-error <?php endif; ?>"
                name="company_name" value="<?php echo e($company->company_name); ?>" >
                <?php if($errors->has('name')): ?>
                <ul class="parsley-errors-list filled">
                    <?php $__currentLoopData = $errors->get('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="parsley-required"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EIN" >
                EIN
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="EIN" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('EIN')): ?> parsley-error <?php endif; ?>" name="EIN" value="<?php echo e($company->EIN); ?>" >

            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Email
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('name')): ?> parsley-error <?php endif; ?>"
                name="email" value="<?php echo e($company->email); ?>" >
                <?php if($errors->has('name')): ?>
                <ul class="parsley-errors-list filled">
                    <?php $__currentLoopData = $errors->get('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="parsley-required"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Phone
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('name')): ?> parsley-error <?php endif; ?>"
                name="phone" value="<?php echo e($company->phone); ?>" >
                <?php if($errors->has('phone')): ?>
                <ul class="parsley-errors-list filled">
                    <?php $__currentLoopData = $errors->get('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="parsley-required"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Address
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="address" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('name')): ?> parsley-error <?php endif; ?>"
                name="address" value="<?php echo e($company->address); ?>" >
                <?php if($errors->has('name')): ?>
                <ul class="parsley-errors-list filled">
                    <?php $__currentLoopData = $errors->get('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="parsley-required"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city" >
                City
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="city" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('city')): ?> parsley-error <?php endif; ?>"
                name="city" value="<?php echo e($company->city); ?>" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state" >
                State
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="state" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('state')): ?> parsley-error <?php endif; ?>"
                name="state" value="<?php echo e($company->state); ?>" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zipcode" >
                Zipcode
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="zipcode" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('zipcode')): ?> parsley-error <?php endif; ?>" name="zipcode" value="<?php echo e($company->zipcode); ?>" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="accept_payments" >
                Accept Payment
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="accept_payments" id="accept_payments" required class="form-control <?php if($errors->has('accept_payments')): ?> parsley-error <?php endif; ?>">
                    <option value="yes" <?php if($company->accept_payments=="yes"): ?><?php echo e("selected"); ?><?php endif; ?>>Yes</option>
                    <option value="no" <?php if($company->accept_payments=="no"): ?><?php echo e("selected"); ?><?php endif; ?>>No</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_key" >
                API Endpoint
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_endpoint" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('api_endpoint')): ?> parsley-error <?php endif; ?>" name="api_endpoint" value="<?php echo e($company->api_endpoint); ?>" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_key" >
                API Key
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_key" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('api_key')): ?> parsley-error <?php endif; ?>" name="api_key" value="<?php echo e($company->api_key); ?>" >

            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_user" >
                API User
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_user" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('api_user')): ?> parsley-error <?php endif; ?>" name="api_user" value="<?php echo e($company->api_user); ?>" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_password" >
                API Password
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_password" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('api_password')): ?> parsley-error <?php endif; ?>" name="api_password" value="<?php echo e($company->api_password); ?>" >

            </div>
        </div>
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_user" >
                Fix Payment Amount
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="global_link" type="text" class="form-control col-md-7 col-xs-12 <?php if($errors->has('global_link')): ?> parsley-error <?php endif; ?>" name="global_link" value="<?php echo e($company->global_link); ?>" >

            </div>
        </div> -->

        <div class="form-group hide">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Global Payment Link Fix Amount
                <span class="required">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12 " id="myInput" value="<?php echo e($global_link_fix); ?>" readonly="">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <button class="btn btn-dark text-white clickCopy" data-id="myInput" > Copy Link </button>
            </div>
        </div>

        <div class="form-group hide">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Global Payment Link 
                <span class="required">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12 " id="global_link_text" value="<?php echo e($global_link); ?>" readonly="">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <button class="btn btn-dark text-white clickCopy" data-id="global_link_text" > Copy Link </button>
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
    var count = 0;
    var CompanySettingList = '<?php echo e(route('admin.company')); ?>';
    function addMoreAdmins(){
        //alert('usama');
       
        const par = document.createElement('div');
        par.setAttribute("id", `child${count}`)
        par.innerHTML =  `<label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_admin" >Company Admin<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="company_admin[]" id="company_admin"  class="form-control <?php if($errors->has('company_admin')): ?> parsley-error <?php endif; ?>">
                    <option value="" <?php if(old('company_admin')==""): ?><?php echo e("selected"); ?><?php endif; ?>>-- Select Company Admin --</option>
                    <?php if(!empty($company_data)): ?>
                    <?php $__currentLoopData = $company_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option onchange="captureID()" value="<?php echo e($admin->id); ?>" <?php if(old('company_admin')==$admin->id): ?><?php echo e("selected"); ?><?php endif; ?>><?php echo e($admin->first_name . " " . $admin->last_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="button" name="add" id="add" class="btn btn-success" onclick="remove(child`+count +`)"><i class="fa fa-minus"></i></button>`
            var adminMore= document.getElementById('newAdmin').appendChild(par);
            count ++ 
    }
    function captureID(){
        alert('usama');

    }
    function remove(id){
        const asd = id.getAttribute('id')
        const nested_div = document.getElementById(asd) 
        var removeDrop =  document.getElementById('newAdmin')
        removeDrop.removeChild(nested_div);
        }
    var CompanySettingList = '<?php echo e(route('admin.company')); ?>';

    $(".clickCopy").click(function(event) {
      event.preventDefault();
      var  id = $(this).data('id')
      var copyText = document.getElementById(id);
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
  });
</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<?php echo e(Html::script('assets/admin/js/company/add.js')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/company/edit.blade.php ENDPATH**/ ?>