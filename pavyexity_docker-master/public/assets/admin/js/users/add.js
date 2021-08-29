$(document).ready(function() {
  $("#UserTable thead td").each(function() {
    var title = $(this).text();
    $(this).html(
      '<div class="UsersearchBox"><input type="text" placeholder="' +
        title +
        '" /></div>'
    );
  });

  var table = $("#UserTable").DataTable({
    processing: true,
    serverSide: true,
    order: [[5, "desc"]],
    ajax: {
      url: userList,
    },
    columns: [
      { data: "email", name: "email" },
      {
        data: "users.first_name",
        name: "users.first_name",
        render: function(data, type, row, meta) {
          return row.first_name + " " + row.last_name;
        },
      },
      {
        data: "roles",
        name: "roles.name",
        searchable: false,
        render: function(data, type, row, meta) {
          // console.log([data[0]]);
          var d = "";
          $(data).each(function(i, e) {
            d += e.name + ", ";
          });
          return d;
        },
      },
      { data: "phone", name: "phone", visible: false },
      {
        data: "active",
        name: "status",
        render: function(data, type) {
          if (data == 1) {
            return "Active";
          } else {
            return "Inactive";
          }
        },
      },
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
            console.log(that.search());
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

  $("form[name='frmuser']").validate({
    rules: {
      first_name: "required",
      last_name: "required",
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
      password: {
        required: true,
        minlength: 6,
      },
    },
    messages: {
      first_name: "First name is required.",
      last_name: "Last name is required.",
      email: {
        required: "Email is require",
        email: "Enter valid email",
      },
      phone: {
        required: "Phone is required.",
      },
      password: {
        required: "Passwort is required",
        minlength: "Password must be 6 character long",
      },
    },
  });
});

function validateFm() {}
function check() {
  return confirm("Are you sure you want to delete");
}
