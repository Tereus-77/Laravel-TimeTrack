$(document).ready(function(){
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lfgitp',
        buttons: [
            
        ]

    });

    $('#file').on('change', function() {
        var _token = $('meta[name="csrf-token"]').attr('content');
        var fd = new FormData();
        fd.append('file', this.files[0]);
        fd.append('_token', _token);

        $.ajax({
            url: url_upload,
            method: 'POST',
            data: fd,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function(res) {
                if (res) {
                    location.reload();
                } else {

                }
            }
        });
    });

});