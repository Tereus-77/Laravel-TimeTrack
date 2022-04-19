$(document).ready(function(){
    $('.chosen-select').chosen({width: "100%"});
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $(".select2_demo_1").select2({
        theme: 'bootstrap4',
    });
})