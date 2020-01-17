$(function () {
    $('#start, #end').datetimepicker({
        format: 'Y-m-d H:i',
        lang: 'zh',
        minDate: minDate,
        maxDate: 0,
        maxTime: 0,
        onSelectDate: function (ct) {
          $('#start').val(($('#start').val() <= $('#end').val()) ? $('#start').val() : $('#end').val());
        }
    });
});
