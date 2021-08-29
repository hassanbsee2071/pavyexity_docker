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
      },
      routing_number: {
        required: true,
        number: true,
        min: 1,
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

  $("#payment_method").on("change", function(e) {
    var html;
    if ($("#payment_method").val() == "bank_account") {
      var html = $("#bank_account").html();
      $("#payment_type_fields").html(html);
    } else if ($("#payment_method").val() == "credit_card") {
      var html = $("#credit_card").html();

      $("#payment_type_fields").html(html);
    } else {
      $("#payment_type_fields").html("");
    }
  });
});

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
