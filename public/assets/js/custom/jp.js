$(document).ready(function(){
    var interval = null;

    if (first_visit == 'true') {
        setTimeout(() => {            
            $('#modal').click();
            $.ajax({
                url: url_user,
                method: 'GET',
                dataType: 'JSON',
                success: function(res) {                        
                }
            })
        }, 500);
    }

    $('.chosen-select').chosen({width: "100%"});
    $(".select2_demo_1").select2({
        theme: 'bootstrap4',
    });
    $(".select2_demo_2").select2({
        theme: 'bootstrap4',
    });
    $(".select2_demo_3").select2({
        theme: 'bootstrap4',
        placeholder: "Select a state",
        allowClear: true
    });

    $('#save_btn').click(function() {
        $.ajax({
            url: url_userown,
            method: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val()
            },
            dataType: 'JSON',
            success: function(res) {
                // $('#cancel_btn').click();
                res ? $('#cancel_btn').click() : $('#modal_psw').removeClass('d-none');
            }
        });
    })

    if (cnt_active > 0) {
        $.ajax({
            url: url_update,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: 'start_job',
                job: $('select').val(),
            },
            dataType: 'JSON',
            success: function(res) {
                $('select').prop('disabled', 'disabled');
                $('#select_chosen').addClass('chosen-disabled');
                $('#select_chosen div.chosen-drop').css('display', 'none');
                $('.form-group').eq(4).removeClass('d-none');
                $('.form-group').eq(5).addClass('d-none');
                timer(res);
            }
        });
    }

    $('select').on('change', function (e) {
        if (this.value) {
            // $('.form-group').eq(3).addClass('d-none');
            $('.form-group').eq(5).removeClass('d-none');
            $('.form-group').eq(6).removeClass('d-none');

            $.ajax({
                url: url_update,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    action: 'select_item',
                    job: $('select').val(),
                },
                dataType: 'JSON',
                success: function(res) {
                    $('#total_time').text(res);
                }
            });
        } else {
            // $('.form-group').eq(3).removeClass('d-none');
            $('.form-group').eq(5).addClass('d-none');
            $('.form-group').eq(6).addClass('d-none');
            $('#total_time').text('0 hrs 0 m');
        }
    });

    $('.form-group').eq(4).click(function() {
        $.ajax({
            url: url_update,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: 'pause',
                job: $('select').val(),
            },
            dataType: 'JSON',
            success: function(res) {
                clearInterval(interval);
                $('#total_time').text(res);
                $('.form-group').eq(3).removeClass('d-none');
                $('.form-group').eq(4).addClass('d-none');
                $('.form-group').eq(5).removeClass('d-none');
                $('select').removeAttr('disabled');
                $('#select_chosen').removeClass('chosen-disabled');
                $('#select_chosen div.chosen-drop').css('display', 'block');
            }
        });
    });

    $('.form-group').eq(5).click(function() {
        $.ajax({
            url: url_update,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: 'continue',
                job: $('select').val(),
            },
            dataType: 'JSON',
            success: function(res) {
                $('select').prop('disabled', 'disabled');
                $('#select_chosen').addClass('chosen-disabled');
                $('#select_chosen div.chosen-drop').css('display', 'none');
                // $('.form-group').eq(3).addClass('d-none');
                $('.form-group').eq(4).removeClass('d-none');
                $('.form-group').eq(5).addClass('d-none');

                timer(res);
            }
        });
    });

    $('#complete_job').click(function() {
        var id = $('select').val();
        var url = url_complete + "/" + id;
        location.href = url;
    });

    function timer(data) {
        var hour = data.hrs;
        var min = data.m;
        var second = 0;
        var str_min;
        interval = setInterval(function() {
            second ++;
            if (second == 60) {
                min += 1;
                second = 0;
            }
            if (min == 60) {
                hour += 1;
                min = 0;
            }
            str_min = min;
            if (min < 10) {
                str_min = '0' + min;
            }
            $('#total_time').html(hour + ' hrs ' + str_min + ' m');
        }, 1000);
    }
})