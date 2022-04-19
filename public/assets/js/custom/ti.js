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

    var mem = $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    var yearsAgo = new Date();
    yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

    $('#selector').datepicker('setDate', yearsAgo );

    $('.chosen-select').chosen({width: "100%"});

    // filter datas
    $(document).on('change', function() {
        var flag = false;
        var to_date = $('#to_date').val();
        var from_date = $('#from_date').val();
        var employee = $('#employee').val();

        if (from_date && to_date && employee) flag = true;

        if (flag) {
            $.ajax({
                url: url_timesheet,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    from_date: from_date,
                    to_date: to_date,
                    employee: employee
                },
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);
                    var result = '';
                    for (var i = 0; i < res.length; i ++) {
                        result += '<tr class="gradeX">';
                        result += '<td>' + res[i]['employee'] + '</td>';
                        result += '<td>' + res[i]['date'] + '</td>';
                        result += '<td>' + res[i]['partnumber'] + '</td>';
                        result += '<td>' + res[i]['qty_good'] + '</td>';
                        result += '<td>' + res[i]['qty_bad'] + '</td>';
                        result += '<td>' + res[i]['time_to_complete'] + '</td>';
                        result += '<td>' + res[i]['part_hr'] + '</td>';
                        result += '</tr>';
                    }

                    if (!result) {
                        result += '<tr class="odd">';
                        result += '<td valign="top" colspan="7" class="dataTables_empty">';
                        result += 'No data available in table';
                        result += '</td>';
                        result += '</tr>';
                    }

                    $('#result').html(result);
                }
            });
        }
    });

    $('th').click(function() {
        $('tr').each(function() {
            var tr = $(this);
            if (tr.find('td')[1]) {
                var td = tr.find('td')[1];
                var name = td.textContent;
                if (name == 'Subtotal/Avg' || name == 'Total/Avg') {
                    tr.addClass('d-none');
                }
            }
        });
    });
});