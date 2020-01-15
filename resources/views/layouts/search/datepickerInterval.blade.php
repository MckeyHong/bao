@push('css')
<link rel="stylesheet" href="{{ asset('/css/vendor/jquery-ui.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/vendor/datepicker-zh-CN.js') }}"></script>
<script>
$(function () {
    $('#start, #end').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: '-2M',
        maxDate: "+0D",
        onSelect: function (changeDate) {
            if ((Date.parse($('#start').val())).valueOf() > (Date.parse($('#end').val())).valueOf()) {
                $('#start').val($('#end').val());
            }
        },
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 99999999999999);
            }, 0);
        }
    });
});
</script>
@endpush
