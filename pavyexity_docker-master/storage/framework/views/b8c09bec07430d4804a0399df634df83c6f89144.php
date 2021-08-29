<?php if(isSet(auth()->user()->id)): ?>


<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
<?php endif; ?>
<link rel="stylesheet"  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div  >
	<div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">Payment Successful</h2>
          <h3 class="text-center">Thank you for your payment</h3>
          

          <p class="text-center">You will receive an order confirmation email with details of your order and a link to track your process.</p>
            <center><div class="btn-group" style="margin-top:50px;">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-lg btn-warning">CONTINUE</a>
            </div></center>
        </div>
	</div>
</div>

<?php if(isSet(auth()->user()->id)): ?>
<?php $__env->stopSection(); ?>

<?php endif; ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/Response/success.blade.php ENDPATH**/ ?>