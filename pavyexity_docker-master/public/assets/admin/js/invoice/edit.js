$(document).ready(function() {
  var count = 1;

  dynamic_field(count);

  function dynamic_field(number) {}
  $(document).on("click", "#add", function() {
    count++;
    dynamic_field(count);
  });

  $(document).on("click", ".remove", function() {
    count--;
    $(this)
      .closest("tr")
      .remove();
  });

  $("table").on("keyup", "input", function() {
    //use event delegation
    var tableRow = $(this).closest("tr"); //from input find row
    var quantity = Number(tableRow.find("#quantity").val()); //get first textbox
    var rate = Number(tableRow.find("#rate").val()); //get second textbox
    var total = quantity * rate; //calculate total
    tableRow.find("#amounts").val(total); //set value
  });

  $("form[name='frminvoice']").validate({
    rules: {
      user_id: "required",
      invoice_title: "required",
      due_date: "required",
      invoice_date: "required",
      amount: "required",
    },
    messages: {
      user_id: "Please select any client.",
      invoice_title: "Invoice title is required.",
      due_date: "Due date is required.",
      invoice_date: "Invoice date is required.",
      amount: "Amount is required.",
    },
  });
});

$(function() {
  $(
    "#due_date_new, #invoice_date_new,#recurrring_end_date_new,#recurrring_end_date_new_2"
  ).datetimepicker({
    format: "MM/DD/YYYY",
  });

  $(".js-example-tags").select2({
    tags: true,
  });
});

$("#is_recurring").on("click", function() {
  if ($(this).is(":checked")) {
    $(".is_recurring_area").show();
  } else {
    $(".is_recurring_area").hide();
  }
});
function check() {
  return confirm("Are you sure you want to delete");
}