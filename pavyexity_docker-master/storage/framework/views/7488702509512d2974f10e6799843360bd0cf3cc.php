

<?php $__env->startSection('title', 'Virtual Card'); ?>

<?php $__env->startSection('content'); ?>

   <!-- <?php echo e(Html::style('assets/sk/styles/skeuocard.reset.css')); ?> -->
    <?php echo e(Html::style('assets/sk/styles/skeuocard.css')); ?>

    <!-- <?php echo e(Html::style('assets/sk/styles/demo.css')); ?> -->
<body>

<div class="wrapper text-center" >
      <section>
        <!-- START FORM -->
        <div class="row" style="  position: relative;
    text-align:center;">
        <div class="col-md-12  col-lg-12 col-sm-12 col-xs-12" >
        <h2 style="color: #00cfa7">Your Transaction is Successfull</h2>
        <h3>Amount: <span class="" style="color: #00cfa7"> </span>  </h3> 
        <h3>Zipcode: <span class="" style="color: #00cfa7"> </span>  </h3>
        </div>
       
    </div>        
<div class="row" style="  position: fixed;
    left: 54%;
    transform: translate(-50%, 0);">

<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 " style="text-align: center">
    <div class="credit-card-input no-js" id="skeuocard">
            <p class="no-support-warning">
              Either you have Javascript disabled, or you're using an unsupported browser, amigo! That's why you're seeing this old-school credit card input form instead of a fancy new Skeuocard. On the other hand, at least you know it gracefully degrades...
            </p>
            <label for="cc_type">Card Type</label>
            <select name="cc_type">
              <option value="">...</option>
              <option value="visa">Visa</option>
              <option value="discover">Discover</option>
              <option value="mastercard">MasterCard</option>
              <option value="maestro">Maestro</option>
              <option value="jcb">JCB</option>
              <option value="unionpay">China UnionPay</option>
              <option value="amex">American Express</option>
              <option value="dinersclubintl">Diners Club</option>
            </select>
            <label for="cc_number">Card Number</label>
            <input type="text" name="cc_number" id="cc_number" placeholder="XXXX XXXX XXXX XXXX" value="" maxlength="19" size="19">
            <label for="cc_exp_month">Expiration Month</label>
            <input type="text" name="cc_exp_month" value="" id="cc_exp_month" placeholder="00">
            <label for="cc_exp_year">Expiration Year</label>
            <input type="text" name="cc_exp_year" id="cc_exp_year" value="" placeholder="00">
            <label for="cc_name">Cardholder's Name</label>
            <input type="text" name="cc_name" id="cc_name" value="" placeholder="John Doe">
            <label for="cc_cvc">Card Validation Code</label>
            <input type="text" name="cc_cvc" id="cc_cvc" value=""    placeholder="123" maxlength="3" size="3">
          </div>
        <!-- END FORM -->
      </section>
    <br><br><br>
</div></div>
    
  
    </div>

</body>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
    <?php echo e(Html::script('assets/sk/javascripts/vendor/demo.fix.js')); ?>

    <?php echo e(Html::script('assets/sk/javascripts/vendor/jquery-2.0.3.min.js')); ?>

    <?php echo e(Html::script('assets/sk/javascripts/skeuocard.js')); ?>

    <?php echo e(Html::script('assets/sk/javascripts/vendor/cssua.min.js')); ?>




    
    <script>

      $(document).ready(function(){
        var isBrowserCompatible = 
          $('html').hasClass('ua-ie-10') ||
          $('html').hasClass('ua-webkit') ||
          $('html').hasClass('ua-firefox') ||
          $('html').hasClass('ua-opera') ||
          $('html').hasClass('ua-chrome');

        if(isBrowserCompatible){
          window.card = new Skeuocard($("#skeuocard"), {
            debug: false
          });
        }
      });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/payments/card2.blade.php ENDPATH**/ ?>