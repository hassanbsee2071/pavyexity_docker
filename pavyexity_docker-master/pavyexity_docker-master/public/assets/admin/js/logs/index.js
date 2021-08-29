$(document).ready(function () {

    // Add input field for each table head
    $('#logs #search_input td').each( function () {
        var title = $(this).text();
        $(this).html( '<div><input class="form-control comapny_invoice_search" type="text" placeholder="Search '+title+'" /></div>' );
    } );
    // Disable sort when click input field
    $('#logs #search_input').on("click", function (event) {
        if($(event.target).is("input")) {
            event.stopImmediatePropagation();
        }
    });
    // Comapnay invoice datatable initialization
    $('#logs').DataTable({
        processing: true,
        serverSide: true,
        ajax: LogRoute,
        // "order": [[ 0, "desc" ]],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'api_name', name: 'api_name'},
            {data: 'request_data', name: 'request_data'},
            {data: 'response_data', name: 'response_data'},
            {data: 'request_at', name: 'request_at'}
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

    // Display log request data
    $(document).on('click', '.log-request', function(){
        console.log($(this).data('request'));
        $('#request-modal-data').text(JSON.stringify($(this).data('request'), null, '\t'));
    });
    // Display log response data
    $(document).on('click', '.log-response', function(){
        $('#response-modal-data').text(JSON.stringify($(this).data('response'), null, '\t'));
    });
});
