$(document).ready(function() {
  $("#CompanyTable #search td").each(function() {
    var title = $(this).text();
    $(this).html(
      '<div class="CompanysearchBox"><input type="text" placeholder="' +
        title +
        '" /></div>'
    );
  });

  var table = $("#CompanyTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[6, "desc"]],
    ajax: CompanySettingList,
    columns: [
      { data: "email", name: "email" },
      { data: "phone", name: "phone" },
      { data: "company_admin", name: "company_admin", searchable: false },
      { data: "company_name", name: "company_name" },
      { data: "EIN", name: "EIN", visible: false },
      { data: "address", name: "address", visible: false },
      { data: "api_key", name: "api_key", visible: false },
      { data: "api_user", name: "api_user", visible: false },
      { data: "accept_payments", name: "accept_payments", visible: false },
      { data: "created_at", name: "created_at" },
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

  $("form[name='frmcompany']").validate({
    rules: {
      company_admin: "required",
      email: {
        required: true,
        email: true,
      },
      phone: {
        required: true,
        number: true,
        minlength: 10,
        maxlength: 12,
      },
      company_name: "required",
      first_name: "required",
      last_name: "required",
      address: "required",
      city: "required",
      state: "required",
      api_key: "required",
      api_user: "required",
      EIN: "required",
      zipcode: "required",
    },
    messages: {
      company_admin: "Company admin is required.",
      email: {
        required: "Email is require",
        email: "Enter valid email",
      },
      phone: {
        required: "Phone is required.",
      },
      company_name: "Company name is required.",
      first_name: "First name is required.",
      last_name: "Last name is required.",
      address: "Address is required.",
      city: "City is required.",
      state: "State is required.",
      api_key: "API Key is required.",
      api_user: "API User is required.",
      EIN: "Company EIN is required.",
      zipcode: "Zipcode is required.",
    },
  });
});

function validateFm() {}
function check() {
  return confirm("Are you sure you want to delete");
}
