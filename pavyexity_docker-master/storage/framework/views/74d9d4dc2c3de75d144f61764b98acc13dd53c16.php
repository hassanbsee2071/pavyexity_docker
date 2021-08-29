<?php $__env->startComponent('mail::message'); ?>
Hello **<?php echo e($name); ?>**,  
Thank you for choosing Payvexity!

You have received payment from **<?php echo e($sender); ?>** 

Your Payment amount is **<?php echo e($amount); ?>** 

Sincerely,  
Payvexity team.
<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/resources/views/emails/payment-receive-2.blade.php ENDPATH**/ ?>