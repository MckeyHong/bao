<div class="row menu-container">
    <div class="col menu-block">
        @if ($path == '/')
        <div class="text-center"><i data-eva="log-in-outline" data-eva-fill="#FF671A"></i></div>
        <div>{{ trans('custom.web.func.deposit') }}</div>
        @else
        <a href="{{ asset('/') }}">
            <div class="text-center"><i data-eva="log-in-outline"></i></div>
            <div>{{ trans('custom.web.func.deposit') }}</div>
        </a>
        @endif
    </div>
    <div class="col menu-block">
        @if ($path == 'withdrawal')
        <div class="text-center"><i data-eva="log-out-outline" data-eva-fill="#FF671A"></i></div>
        <div>{{ trans('custom.web.func.withdrawal') }}</div>
        @else
        <a href="{{ asset('/withdrawal') }}">
            <div class="text-center"><i data-eva="log-out-outline"></i></div>
            <div>{{ trans('custom.web.func.withdrawal') }}</div>
        </a>
        @endif
    </div>
    <div class="col menu-block">
        @if ($path == 'record')
        <div class="text-center"><i data-eva="list-outline" data-eva-fill="#FF671A"></i></div>
        <div>{{ trans('custom.web.func.record') }}</div>
        @else
        <a href="{{ asset('/record') }}">
            <div class="text-center"><i data-eva="list-outline"></i></div>
            <div>{{ trans('custom.web.func.record') }}</div>
        </a>
        @endif
    </div>
    <div class="col menu-block">
        @if ($path == 'rule')
        <div class="text-center"><i data-eva="info-outline" data-eva-fill="#FF671A"></i></div>
        <div>{{ trans('custom.web.func.rule') }}</div>
        @else
        <a href="{{ asset('/rule') }}">
            <div class="text-center"><i data-eva="info-outline"></i></div>
            <div>{{ trans('custom.web.func.rule') }}</div>
        </a>
        @endif
    </div>
</div>