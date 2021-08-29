$(document).ready(function() {
  $("#PaymentTable #search td").each(function() {
    var title = $(this).text();
    $(this).html(
      '<div class="PaymentSearchbox"><input type="text" placeholder="' +
        title +
        '" /></div>'
    );
  });
  var table = $("#PaymentTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: PaymentList,
    order: [[4, "desc"]],
    columns: [
      { data: "email", name: "email" },
      { data: "transaction_id", name: "transaction_id" },
      { data: "payment_type", name: "payment_type" },
      { data: "payment_status", name: "payment_status" },
      { data: "created_at", name: "created_at", visible: false },
      { data: "updated_at", name: "updated_at", visible: false },
      { data: "action", name: "action", orderable: false, searchable: false },
    ],
    initComplete: function() {
      // Apply the search
      this.api()
        .columns()
        .every(function() {
          var that = this;

          $("input", this.header()).on("keyup change clear", function() {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
    },
  });
  // Dynamic table column display
  $('.list_view input[type="checkbox"]').on("change", function(e) {
    // Get the column API object
    var col = table.column($(this).attr("data-target"));
    // Toggle the visibility
    col.visible(!col.visible());
  });

  $("form[name='frm_make_payment']").validate({
    rules: {
      payment_method: "required",
      email: {
        required: true,
        email: true,
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
function check() {
  return confirm("Are you sure you want to delete");
}
