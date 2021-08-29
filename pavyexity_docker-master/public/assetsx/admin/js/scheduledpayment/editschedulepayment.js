$("form[name='frm_edit_schedulepayment']").validate({
  rules: {
    email: {
      required: true,
      email: true,
    },
    schedule_interval: "required",
    start_date: "required",
    payment_amount: {
      required: true,
      number: true,
      min: 1,
    },
  },
  messages: {
    email: {
      required: "Email is required",
      email: "Please enter valid email",
    },
    schedule_interval: "Please select intervals.",
    start_date: "Start Date is required.",
    end_date: "End Date is required",
    payment_amount: {
      required: "Payment amount is required.",
      number: "Payment amount must be in number",
      min: "Payment amount must be greter than 1",
    },
  },
});
$(function() {
  var dateNow = new Date();
  $("#edit_start_date").datetimepicker({
    format: "MM-DD-YYYY",
  });
  $("#edit_end_date").datetimepicker({
    format: "MM-DD-YYYY",
  });
  $("#edit_end_date2").datetimepicker({
    format: "MM-DD-YYYY",
  });
});
