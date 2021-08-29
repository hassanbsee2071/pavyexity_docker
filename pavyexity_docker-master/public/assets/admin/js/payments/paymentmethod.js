var flag = 0;
$(document).ready(function() {
  $("form[name='frm_payment_method']").validate({
    rules: {
      payment_method: "required",
      email: {
        required: true,
        email: true,
      },
      name: {
        required: true,
      },
      payment_amount: {
        required: true,
        number: true,
        min: 1,
      },
      account_number: {
        required: true,
        maxlength: 17,
        digits: true,

      },
      routing_number: {
        required: true,
        number: true,
        maxlength: 9,
        minlength: 9,
      },
      account_type: {
        required: true,
      },
      bank_account_name: {
        required: true,
      },
      card_holder_name: {
        required: true,
      },
      card_number: {
        required: true,
        digits: true,
        minlength: 12,
        maxlength: 19,
      },
      card_address1: {
        required: true,
      },
      card_city: {
        required: true,
      },
      card_state: {
        required: true,
      },
      card_country: {
        required: true,
      },
      card_zipcode: {
        required: true,
        digits: true,
        minlength: 5,
        maxlength: 6,
      },
      card_cvv: {
        required: true,
        digits: true,
        minlength: 3,
        maxlength: 4,
      },
      card_expiry_month: {
        required: true,
      },
      card_expiry_year: {
        required: true,
      },
    },
    messages: {
      payment_method: "Payment Method is required.",
      email: {
        required: "Email is required",
        email: "Please enter valid email",
      },
      name: {
        required: "Payee name is required.",
      },
      payment_amount: {
        required: "Payment amount is required.",
        number: "Payment amount must be in number",
        min: "Payment amount must be greter than 1",
      },
      account_number: {
        required: "Account number is required",
      },
      routing_number: {
        required: "Routing number is required.",
        number: "Routing number must be in number",
        min: "Routing number must be greter than 1",
      },
      account_type: {
        required: "Please select Account type",
      },
      bank_account_name: {
        required: "Bank account name is required",
      },
      card_holder_name: {
        required: "Credit Card holder name is required",
      },
      card_number: {
        required: "Credit Card number is required",
        digits: "Credit Card number must be a number",
        minlength: "Credit Card number must be greater than equals to 16",
        maxlength: "Credit Card number must be less than or equal to 19",
      },
      card_address1: {
        required: "Address line 1 required.",
      },
      card_city: {
        required: "City is required",
      },
      card_state: {
        required: "State is required",
      },
      card_country: {
        required: "Country is required",
      },
      card_zipcode: {
        required: "Zipcode is required",
        digits: "Zipcode must be a number",
        minlength: "Zipcode must be greater than equals to 5",
        maxlength: "Zipcode must be less than equal to 6",
      },
      card_cvv: {
        required: "CVV is required",
        digits: "CVV must be a number",
        minlength: "CVV must be greater than or equal to 3.",
        maxlength: "CVV must be greater than or equal to 4.",
      },
      card_expiry_month: {
        required: "Expiry month is required",
      },
      card_expiry_year: {
        required: "Expiry year is required",
      },
    },
  });
  // $(document).ready(function(){
    // $('#cc-input').on('keyup', function(){
    //   console.log('Hello');
    //   $("#visa-img").hide();    
    // });
  // });
  // function myFunctionCheck() {
  //   var x = document.getElementById("cc-input");
  //   $("#visa-img").hide();
  // }
  $("#payment_method").on("change", function(e) {
    var html;
    if ($("#payment_method").val() == "bank_account") {
      var html = $("#bank_account").html();
      $("#payment_type_fields").html(html);
    } else if ($("#payment_method").val() == "credit_card") {
      var html = $("#credit_card").html();
      $("#payment_type_fields").html(html);
      if (flag == 0) {
        loadCardV();
        flag = 1
        var payment_form = $("#payment-form").paymentForm();
      }
    } else {
      $("#payment_type_fields").html("");
    }
  });
});
function changePaymentMethod(value) {
  $('#bank_account_btn').removeClass('active');
  $('#credit_card_btn').removeClass('active');
  $("#"+value+'_btn').toggleClass('active');
  $("#payment_method").val(value);
  if (value == "bank_account") {
    var html = $("#bank_account").html();
    console.log(html);
    $("#payment_type_fields").html(html);
  } else if (value == "credit_card") {
    var html = $("#credit_card").html();
    $("#payment_type_fields").html(html);
    if (flag == 0) {
      loadCardV();
      flag = 1
      var payment_form = $("#payment-form").paymentForm();
    }
  } else {
    $("#payment_type_fields").html("");
  }
}
function routing(routing) {
  var x = document.getElementById("routingError");
  var b = document.getElementById("btnPay");

  if (routing.value.length !== 9) {
    if (x.style.display === "none") {
      x.style.display = "block";
    }
    b.disabled = true;
  }

  // http://en.wikipedia.org/wiki/Routing_transit_number#MICR_Routing_number_format
  var checksumTotal =
    7 *
      (parseInt(routing.value.charAt(0), 10) +
        parseInt(routing.value.charAt(3), 10) +
        parseInt(routing.value.charAt(6), 10)) +
    3 *
      (parseInt(routing.value.charAt(1), 10) +
        parseInt(routing.value.charAt(4), 10) +
        parseInt(routing.value.charAt(7), 10)) +
    9 *
      (parseInt(routing.value.charAt(2), 10) +
        parseInt(routing.value.charAt(5), 10) +
        parseInt(routing.value.charAt(8), 10));

  var checksumMod = checksumTotal % 10;
  if (checksumMod !== 0) {
    if (x.style.display === "none") {
      x.style.display = "block";
    }
    b.disabled = true;
  } else {
    if (x.style.display === "block") {
      x.style.display = "none";
    }
    b.disabled = false;
  }

  //   alert("sdsds");
}
function account(numb) {
  var x = document.getElementById("accountError");
  var b = document.getElementById("btnPay");
  var valid = /^[0-9]{7,14}$/.test(numb.value);
  if (valid) {
    if (x.style.display === "block") {
      x.style.display = "none";
    }
    b.disabled = false;
  } else {
    if (x.style.display === "none") {
      x.style.display = "block";
    }
    b.disabled = true;
  }

  // http://en.wikipedia.org/wiki/Routing_transit_number#MICR_Routing_number_format

  //   alert("sdsds");
}

/**
 * paymentForm
 *
 * A plugin that validates a group of payment fields.  See jquery.payment.js
 * Adapted from https://gist.github.com/Air-Craft/1300890
 */

// if (!window.L) { window.L = function () { console.log(arguments);} } // optional EZ quick logging for debugging

function loadCardV() {
(function ($) {
  /**
   * The plugin namespace, ie for $('.selector').paymentForm(options)
   *
   * Also the id for storing the object state via $('.selector').data()
   */
  var PLUGIN_NS = "paymentForm";

  var Plugin = function (target, options) {
    this.$T = $(target);
    this._init(target, options);

    /** #### OPTIONS #### */
    this.options = $.extend(
      true, // deep extend
      {
        DEBUG: false
      },
      options
    );

    this._cardIcons = {
      visa: "visa icon",
      mastercard: "mastercard icon",
      amex: "american express icon",
      dinersclub: "diners club icon",
      discover: "discover icon",
      jcb: "japan credit bureau icon",
      default: "credit card alternative icon"
    };

    return this;
  };

  /** #### INITIALISER #### */
  Plugin.prototype._init = function (target, options) {
    var base = this;

    base.number = this.$T.find("[data-payment='cc-number']");
    base.exp = this.$T.find("[data-payment='cc-exp']");
    base.cvc = this.$T.find("[data-payment='cc-cvc']");
    base.brand = this.$T.find("[data-payment='cc-brand']");
    base.onlyNum = this.$T.find("[data-numeric]");

    // Set up all payment fields inside the payment form
    base.number
      .payment("formatCardNumber")
      .data(
        "payment-error-message",
        "Please enter a valid credit card number."
      );
    base.exp
      .payment("formatCardExpiry")
      .data("payment-error-message", "Please enter a valid expiration date.");
    base.cvc
      .payment("formatCardCVC")
      .data("payment-error-message", "Please enter a valid CVC.");
    base.onlyNum.payment("restrictNumeric");

    // Update card type on input
    base.number.on("input", function () {
      base.cardType = $.payment.cardType(base.number.val());
      var fg = base.number.closest(".ui.icon.input");
      if (base.cardType) {
        base.brand.text(base.cardType);
        // Also set an icon
        var icon = base._cardIcons[base.cardType]
          ? base._cardIcons[base.cardType]
          : base._cardIcons["default"];
        fg.children("i").attr("class", icon);
        //("<i class='" + icon + "'></i>");
      } else {
        $("[data-payment='cc-brand']").text("");
      }
    });

    // Validate card number on change
    base.number.on("change", function () {
      base._setValidationState(
        $(this),
        !$.payment.validateCardNumber($(this).val())
      );
    });

    // Validate card expiry on change
    base.exp.on("change", function () {
      base._setValidationState(
        $(this),
        !$.payment.validateCardExpiry($(this).payment("cardExpiryVal"))
      );
    });

    // Validate card cvc on change
    base.cvc.on("change", function () {
      base._setValidationState(
        $(this),
        !$.payment.validateCardCVC($(this).val(), base.cardType)
      );
    });
  };

  /** #### PUBLIC API (see notes) #### */
  Plugin.prototype.valid = function () {
    var base = this;

    var num_valid = $.payment.validateCardNumber(base.number.val());
    var exp_valid = $.payment.validateCardExpiry(
      base.exp.payment("cardExpiryVal")
    );
    var cvc_valid = $.payment.validateCardCVC(base.cvc.val(), base.cardType);

    base._setValidationState(base.number, !num_valid);
    base._setValidationState(base.exp, !exp_valid);
    base._setValidationState(base.cvc, !cvc_valid);

    return num_valid && exp_valid && cvc_valid;
  };

  /** #### PRIVATE METHODS #### */
  Plugin.prototype._setValidationState = function (el, erred) {
    var fg = el.closest(".field");
    fg.toggleClass("error", erred).toggleClass("", !erred);
    fg.find(".payment-error-message").remove();
    if (erred) {
      fg.append(
        "<span class='ui pointing red basic label payment-error-message'>" +
          el.data("payment-error-message") +
          "</span>"
      );
    }
    return this;
  };

  /**
   * EZ Logging/Warning (technically private but saving an '_' is worth it imo)
   */
  Plugin.prototype.DLOG = function () {
    if (!this.DEBUG) return;
    for (var i in arguments) {
      console.log(PLUGIN_NS + ": ", arguments[i]);
    }
  };
  Plugin.prototype.DWARN = function () {
    this.DEBUG && console.warn(arguments);
  };

  /*###################################################################################
 * JQUERY HOOK
 ###################################################################################*/

  /**
   * Generic jQuery plugin instantiation method call logic
   *
   * Method options are stored via jQuery's data() method in the relevant element(s)
   * Notice, myActionMethod mustn't start with an underscore (_) as this is used to
   * indicate private methods on the PLUGIN class.
   */
  $.fn[PLUGIN_NS] = function (methodOrOptions) {
    if (!$(this).length) {
      return $(this);
    }
    var instance = $(this).data(PLUGIN_NS);

    // CASE: action method (public method on PLUGIN class)
    if (
      instance &&
      methodOrOptions.indexOf("_") != 0 &&
      instance[methodOrOptions] &&
      typeof instance[methodOrOptions] == "function"
    ) {
      return instance[methodOrOptions](
        Array.prototype.slice.call(arguments, 1)
      );

      // CASE: argument is options object or empty = initialise
    } else if (typeof methodOrOptions === "object" || !methodOrOptions) {
      instance = new Plugin($(this), methodOrOptions); // ok to overwrite if this is a re-init
      $(this).data(PLUGIN_NS, instance);
      return $(this);

      // CASE: method called before init
    } else if (!instance) {
      $.error(
        "Plugin must be initialised before using method: " + methodOrOptions
      );

      // CASE: invalid method
    } else if (methodOrOptions.indexOf("_") == 0) {
      $.error("Method " + methodOrOptions + " is private!");
    } else {
      $.error("Method " + methodOrOptions + " does not exist.");
    }
  };
})(jQuery);
}

/* Initialize validation */


// $("#payment-form").on("submit", function () {
//   event.preventDefault();
//   var valid = $(this).paymentForm("valid");
//   if (valid) {
//     console.log("CC info is good!");
//     stripe();
//   } else {
//     console.log("Badman Cardfaker");
//   }
// });
