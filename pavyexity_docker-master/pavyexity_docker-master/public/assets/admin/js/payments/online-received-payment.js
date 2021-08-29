$(document).ready(function () {

    // Add input field for each table head
    $('#received #search_input td').each( function () {
        var title = $(this).text();
        $(this).html( '<div><input class="form-control comapny_invoice_search" type="text" placeholder="Search '+title+'" /></div>' );
    } );
    // Disable sort when click input field
    $('#received #search_input').on("click", function (event) {
        if($(event.target).is("input")) {
            event.stopImmediatePropagation();
        }
    });

    $('#received').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: OnlinePaymentReceivedRoute,
        // "order": [[ 0, "desc" ]],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'payment_amount', name: 'payment_amount'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions' , name: 'actions', orderable: false, searchable: false},
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
