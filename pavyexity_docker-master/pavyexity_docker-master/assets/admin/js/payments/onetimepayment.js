$(document).ready(function() {
  $("form[name='frm_send_payment']").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      payment_amount: {
        required: true,
        number: true,
        min: 1,
      },
      description: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Email is required",
        email: "Please enter valid email",
      },
      payment_amount: {
        required: "Payment amount is required.",
        number: "Payment amount must be in number",
        min: "Payment amount must be greter than 1",
      },
      description: {
        required: "Description is required",
        email: "Please enter valid description",
      },
    },
  });
});
