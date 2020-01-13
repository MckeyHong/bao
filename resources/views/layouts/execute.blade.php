@if ($executeResult != '' && $executeMessage != '')
    <div id="execute-show" class="alert alert-{{ $executeResult }}" role="alert" style="z-index:9999;display:none;">{{ $executeMessage }}</div>
    @push('executejs')
        <script defer="defer">
        $('#execute-show').css('display', 'block');
        var closeExecute = () => {
          $('#execute-show').slideUp();
        };
        $(function(){
          setInterval("closeExecute()", "1500");
        });
        </script>
    @endpush
@endif