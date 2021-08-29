$.fn.dataTable.render.moment = function(from, to, locale) {
  // Argument shifting
  if (arguments.length === 1) {
    locale = "en";
    to = from;
    from = "YYYY-MM-DD";
  } else if (arguments.length === 2) {
    locale = "en";
  }

  return function(d, type, row) {
    if (!d) {
      return type === "sort" || type === "type" ? 0 : d;
    }

    var m = window.moment(d, from, locale, true);

    // Order and type get a number value from Moment, everything else
    // sees the rendered value
    return m.format(type === "sort" || type === "type" ? "x" : to);
  };
};

$(document).ready(function() {
  var table = $("#recurringPaymentTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[5, "desc"]],
    ajax: {
      url: recurringPaymentList,
    },
    columns: [
      // {data: 'id', name: 'id'},
      { data: "email", name: "email" },
      { data: "payment_amount", name: "payment_amount" },
      { data: "intervals", name: "intervals" },
      { data: "start_date", name: "start_date" },
      { data: "end_date", name: "end_date" },

      {
        data: "created_at",
        name: "created_at",
        render: $.fn.dataTable.render.moment(
          "YYYY-MM-DDTHH:mm:ss.SSSSSSZ",
          "YYYY-MM-DD"
        ),
        // render: $.fn.dataTable.render.moment("Do MMM YYYYY"),
      },
      {
        data: "updated_at",
        name: "updated_at",
        render: $.fn.dataTable.render.moment(
          "YYYY-MM-DDTHH:mm:ss.SSSSSSZ",
          "YYYY-MM-DD"
        ),
      },
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
  // multi column search
  $("#recurringPaymentTable #search td").each(function() {
    var title = $(this).text();
    $(this).html(
      '<div class="RecurringsearchBox"><input type="text" placeholder="' +
        title +
        '" /></div>'
    );
  });

  // Dynamic table column display
  $('.list_view input[type="checkbox"]').on("change", function(e) {
    // Get the column API object
    var col = table.column($(this).attr("data-target"));
    // Toggle the visibility
    col.visible(!col.visible());
  });

  $("form[name='frmschedulepayment']").validate({
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
      payment_amount: {
        required: "Payment amount is required.",
        number: "Payment amount must be in number",
        min: "Payment amount must be greter than 1",
      },
    },
  });

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
      payment_amount: {
        required: "Payment amount is required.",
        number: "Payment amount must be in number",
        min: "Payment amount must be greter than 1",
      },
    },
  });
});

$(function() {
  var dateNow = new Date();
  $("#start_date").datetimepicker({
    format: "MM-DD-YYYY",
    defaultDate: dateNow,
    minDate: dateNow,
  });
  $("#end_date").datetimepicker({
    format: "MM-DD-YYYY",
    defaultDate: dateNow,
    minDate: dateNow,
  });
});
function check() {
  return confirm("Are you sure you want to delete");
}
