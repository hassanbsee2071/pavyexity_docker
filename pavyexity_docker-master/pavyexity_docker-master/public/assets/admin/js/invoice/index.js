$(document).ready(function () {

    // Add input field for each table head
    $('#comapny_invoice #search_input td').each( function () {
        var title = $(this).text();
        $(this).html( '<div><input class="form-control comapny_invoice_search" type="text" placeholder="Search '+title+'" /></div>' );
    } );
    // Disable sort when click input field
    $('#comapny_invoice #search_input').on("click", function (event) {
        if($(event.target).is("input")) {
            event.stopImmediatePropagation();
        }
    });
    // Comapnay invoice datatable initialization
    $('#comapny_invoice').DataTable({
        processing: true,
        serverSide: true,
        ajax: InvoiceUrl,
        "order": [[ 0, "desc" ]],
        columns: [
            {data: 'invoice_number', name: 'invoice_number'},
            {data: 'amount', name: 'amount'},
            {data: 'client_name', name: 'client_name'},
            {data: 'invoice_title', name: 'invoice_title'},
            {data: 'due_date', name: 'due_date'},
            {data: 'invoice_date', name: 'invoice_date'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action' , name: 'action', orderable: false, searchable: false},
        ],
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                // Search when onkeyup, onkeydown, change, clear
                $( '.comapny_invoice_search', this.header() ).on( 'keyup keydown change clear', function () {
                    console.log(that.search())
                    console.log(this.value)
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
});
function check() {
    return confirm("Are you sure you want to delete");
  }