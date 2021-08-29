

<?php $__env->startSection('title', 'Email Templates'); ?>

<?php $__env->startSection('content'); ?>

<div class="row pull-right">
    <a href="<?php echo e(route('admin.email_template.add')); ?>"><button type="button" class="btn btn-success">Add Email Template</button></a>
</div>
<div id="EmailFieldList">
    <div class="mb-4">
        <div class="">
            <h3>Fields to display</h3>
            
            <div class="list_view">
            <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="0" checked> Subject </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="1" checked> Slug </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="2" checked> Body </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="3" > Created At </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="4" > Updated At </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="5" > Deleted At </label>
                <label style="font-size: 16px; margin-right: 6px;"><input type="checkbox" name="list" data-target="6" checked> Action </label>
            </div><br>
            
        </div>
    </div>
</div>
<div class="md-2">

    <table class="table table-striped table-bordered dt-responsive nowrap" id="EmailTable" cellspacing="0"
           width="100%">
        <thead>
            <tr>
                <!-- <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('id', 'ID'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('email_subject', 'Subject'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('email_slug', 'Slug'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('email_body', 'Body'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('created_at', 'Created At'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('updated_at', 'Updated At'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('deleted_at', 'Deleted At'));?></th>
                <th>Actions</th> -->
                <!-- <th>ID</th> -->
                <th>Subject</th>
                <th>Slug</th>
                <th>Body</th>
                <th>Created At</th>
                <th>Update At</th>
                <th>Deleted At</th>
            </tr>
            <tr id="search">
                <td>Subject</td>
                <td>Slug</td>
                <td>Body</td>
                <td>Created At</td>
                <td>Update At</td>
                <td>Deleted At</td>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>


    </table>
    <div class="pull-right">
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>

$(document).ready(function () {
    var emailList = '<?php echo e(route('admin.email_template')); ?>' ;

    var table = $('#EmailTable').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 3, "desc" ]],
        ajax: emailList,
        columns: [
            // {data: 'id', name: 'ID'},
            {data: 'email_subject', name: 'email_subject'},
            {data: 'email_slug', name: 'email_slug'},
            {data: 'email_body', name: 'email_body',
                render:function(data){
                    if(data.length > 50){
                        return data.substring(0,50);
                    }else{
                        return data.substring(0,50);
                    }
                }
            },
            {data: 'created_at', name: 'created_at', visible: false },
            {data: 'updated_at', name: 'updated_at', visible: false},
            {data: 'deleted_at', name: 'deleted_at', visible: false},
            {data: 'action' , name: 'Action', orderable: false, searchable: false}
        ],
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;

                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }


    });

    $('#EmailTable #search td').each( function () {
        var title = $(this).text();
        $(this).html( '<div class="searchBox"><input type="text" placeholder="'+title+'" /></div>' );
    } );
    // Dynamic table column display
    $('.list_view input[type="checkbox"]').on('change', function(e) {
        // Get the column API object
        var col = table.column($(this).attr('data-target'));
        // Toggle the visibility
        col.visible(!col.visible());
    });


});
</script>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##
<?php echo e(Html::script('assets/admin/js/email_template/add.js')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin/email_template/index.blade.php ENDPATH**/ ?>