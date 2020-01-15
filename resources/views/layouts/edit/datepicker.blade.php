@push('css')
<link rel="stylesheet" href="{{ asset('/css/vendor/jquery-ui.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/vendor/datepicker-zh-CN.js') }}"></script>
<script>
$(function () {
    $('#start_at, #end_at').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: '+1D',
        maxDate: "+12M",
        onSelect: function (changeDate) {
            if ((Date.parse($('#start_at').val())).valueOf() > (Date.parse($('#end_at').val())).valueOf()) {
                $('#start_at').val($('#end_at').val());
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
