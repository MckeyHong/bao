@extends('web.layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('/css/vendor/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/web/record.css') }}">
@endsection

@section('content')
<div class="record-container">
    <div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">{{ __('custom.web.record.start') }}</span>
            </div>
            <input type="text" id="start" class="form-control text-center" value="{{ $date }}">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">{{ __('custom.web.record.end') }}</span>
            </div>
            <input type="text" id="end" class="form-control text-center" value="{{ $date }}">
        </div>
        <div class="row text-center" style="margin:0;">
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('yesterday')">{{ __('custom.web.record.yesterday') }}</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('today')">{{ __('custom.web.record.today') }}</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('lastWeek')">{{ __('custom.web.record.lastWeek') }}</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('thisWeek')">{{ __('custom.web.record.thisWeek') }}</button></div>
        </div>
        <hr>
    </div>
    <div>
        <div id="total-block" class="record-total text-center" @if ($record['list']->count() < 0) style="display:none" @endif>
            {{ __('custom.web.record.totalInterest') }}：$ <span id="totalInterest" class="font-weight-bolder">{{ $record['total'] }}</span>
        </div>
        <div>
            <div id="record-list">
                @if ($record['list']->count() == 0)
                <div class="record-info-block bg-light text-center">
                    {{ __('custom.common.noData') }}
                </div>
                @else
                    @foreach ($record['list'] as $value)
                    <div class="record-info-block bg-light">
                        <div>
                            <div class="float-left">{{ __('custom.web.record.table.created_at') }}</div>
                            <div class="float-right">{{ $value['created_at'] }}</div>
                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <div class="float-left">{{ __('custom.web.record.table.credit_before') }}</div>
                            <div class="float-right">$ {{ $value['credit_before'] }}</div>
                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <div class="float-left">{{ __('custom.web.record.table.credit') }}</div>
                            <div class="float-right {{ $value['class'] }}">[{{ $value['type'] }}] $ {{ $value['credit'] }}</div>
                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <div class="float-left">{{ __('custom.web.record.table.credit_after') }}</div>
                            <div class="float-right">$ {{ $value['credit_after'] }}</div>
                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <div class="float-left">{{ __('custom.web.record.table.interest') }}</div>
                            <div class="float-right">$ {{ $value['interest'] }}</div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                @endif
            </div>
            <div id="more-block" @if (!$record['list']->hasMorePages()) style="display:none" @endif>
                <button type="button" class="btn btn-block btn-submit" onclick="getRecord()">{{ __('custom.web.record.loadMore') }}</button>
                <input type="hidden" id="page" name="page" value="1" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/vendor/datepicker-zh-CN.js') }}"></script>
<script>
const languages = {
    'noData': '{{ __('custom.common.noData') }}',
    'error': '{{ __('custom.common.internalServer') }}',
    'table': {
        created_at: '{{ __('custom.web.record.table.created_at') }}',
        credit_before: '{{ __('custom.web.record.table.credit_before') }}',
        credit: '{{ __('custom.web.record.table.credit') }}',
        credit_after: '{{ __('custom.web.record.table.credit_after') }}',
        interest: '{{ __('custom.web.record.table.interest') }}',
    }
};
</script>
<script src="{{ mix('js/web/record.js') }}"></script>
@endsection