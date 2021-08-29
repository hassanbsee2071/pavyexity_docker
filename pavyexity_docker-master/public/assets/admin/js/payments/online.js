$(document).ready(function() {
  // Add input field for each table head
  $("#links #search_input td").each(function() {
    var title = $(this).text();
    $(this).html(
      '<div><input class="form-control comapny_invoice_search" type="text" placeholder="Search ' +
        title +
        '" /></div>'
    );
  });
  // Disable sort when click input field
  $("#links #search_input").on("click", function(event) {
    if ($(event.target).is("input")) {
      event.stopImmediatePropagation();
    }
  });
  // Comapnay invoice datatable initialization
  $("#links").DataTable({
    processing: true,
    serverSide: true,
    ajax: PaymentLink,
    order: [[0, "desc"]],
    columns: [
      { data: "id", name: "id" },
      { data: "name", name: "name" },
      {
        data: "link",
        name: "link",
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
          return '<a href="' + data + '">Visit Link</a>';
        },
      },
      { data: "is_enable", name: "is_enable", render: function(data,type,row,meta){
          if (data == "1") {
            return 'Enable';
          }if (data == "0") {
            return 'Disable';
          }
      } },
      { data: "created_at", name: "created_at" },
      { data: "actions", name: "actions", orderable: false, searchable: false },
    ],
    initComplete: function() {
      // Apply the search
      this.api()
        .columns()
        .every(function() {
          var that = this;
          // Search when onkeyup, onkeydown, change, clear
          $(".comapny_invoice_search", this.header()).on(
            "keyup keydown change clear",
            function() {
              console.log(that.search());
              console.log(this.value);
              if (that.search() !== this.value) {
                that.search(this.value).draw();
              }
            }
          );
        });
    },
  });
});
function check() {
  return confirm("Are you sure you want to delete");
}
