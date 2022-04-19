$(document).ready(function(){        
    $('.pause').click(function() {
        var id = $(this).data('value');
        $.ajax({
            url: url_update,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: 'pause',
                job: id,
            },
            dataType: 'JSON',
            success: function(res) {
                location.reload();
            }
        });
    });

    $('.complete').click(function() {
        var id = $(this).data('value');
        var url = url_complete + "/" + id;
        location.href = url;
    });
});