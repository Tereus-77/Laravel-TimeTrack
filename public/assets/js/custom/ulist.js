$(document).ready(function(){
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'}
        ]

    });
    $('.delete').click(function () {
        var id = $(this).data('value');
        swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false 
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: url_del,
                        method: 'delete',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id,
                        },
                        dataType: 'JSON',
                        success: function(res) {
                            swal({
                                title: "Deleted",
                                text: "This user has been deleted.",
                                type: "success"
                            }, function () {
                                location.reload();
                            });
                        }
                    });
                } else {
                    swal("Cancelled", "This user is safe :)", "error", function (){ console.log('cancel')});
                }
        });
    });
});