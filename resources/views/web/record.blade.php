@extends('web.layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('/css/vendor/jquery-ui.min.css') }}">
<style type="text/css">
.record-container {
    padding: 0 15px;
}

.search-btn {
    padding: 0;
}

hr {
    margin: 0.5rem 0;
}

.record-info-block {
    border: 1px solid #cccccc;
    border-radius: 5px;
    padding: 8px;
    margin: 5px 0;
}

.record-total {
    padding: 5px 0;
    color: #ffffff;
    border-radius: 5px;
    background: #DD2F2F;
}

.btn-quick {
    color: #495057;
    background: #e9ecef;
    border: 1px solid #ced4da;

}
</style>
@endsection

@section('content')
<div class="record-container">
    <div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">从</span>
            </div>
            <input type="text" id="startAt" class="form-control text-center" value="{{ $date }}">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">自</span>
            </div>
            <input type="text" id="endAt" class="form-control text-center" value="{{ $date }}">
        </div>
        <div class="row text-center" style="margin:0;">
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('yesterday')">昨日</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('today')">今日</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('lastWeek')">上周</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick" onclick="quickSearch('thisWeek')">当周</button></div>
        </div>
        <hr>
    </div>
    <div>
        @if ($record['list']->count() > 0)
        <div class="record-total text-center">
            总利息：$ <span class="font-weight-bolder">{{ $record['total'] }}</span>
        </div>
        @endif
        <div>
            @if ($record['list']->count() == 0)
            <div class="record-info-block bg-light text-center">
                没有任何记录
            </div>
            @else
                @foreach ($record['list'] as $value)
                <div class="record-info-block bg-light">
                    <div>
                        <div class="float-left">异动时间</div>
                        <div class="float-right">{{ $value['created_at'] }}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="float-left">异动金额</div>
                        <div class="float-right {{ $value['class'] }}">$ {{ $value['credit'] }}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="float-left">余额宝钱包</div>
                        <div class="float-right">$ {{ $value['credit_after'] }}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <div class="float-left">生成利息</div>
                        <div class="float-right">$ {{ $value['interest'] }}</div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <hr>
                @endforeach
            @endif
            @if ($record['list']->hasMorePages())
            <div id="more-block">
                <button type="button" class="btn btn-block btn-submit" onclick="getRecord()">载入更多...</button>
                <input type="hidden" id="page" name="page" value="1" />
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/vendor/datepicker-zh-CN.js') }}"></script>
<script>
$.datepicker.setDefaults($.datepicker.regional[ "zh-CH" ]);

var getRecord = () => {
    $('#loadingModal').modal('show');
    axios.defaults.headers.common['Authorization'] = 'Bearer 6b55577df513fa3fdf497e95aec8e80758b8445670e7e09f82b90f9f825bffc7';
    axios.get('/api/record?page=' + $('#page').val()).then(function (response) {
        console.log(response)
    })
    .catch(function (response) {
        console.log(response);
    });
};

var quickSearch = (type) => {
    switch (type) {
        case 'yesterday':
            $('#startAt, #endAt').val(moment().subtract(1, 'day').format('YYYY-MM-DD'));
            break;
        case 'thisWeek':
            $('#startAt').val(moment().startOf('isoWeek').format('YYYY-MM-DD'));
            $('#endAt').val(moment().endOf('isoWeek').format('YYYY-MM-DD'));
            break;
        case 'lastWeek':
            $('#startAt').val(moment().subtract(1, 'weeks').startOf('isoWeek').format('YYYY-MM-DD'));
            $('#endAt').val(moment().subtract(1, 'weeks').endOf('isoWeek').format('YYYY-MM-DD'));
            break;
        default:
            $('#startAt, #endAt').val(moment().format('YYYY-MM-DD'));
    }
};

$(function () {
    $('#startAt, #endAt').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: "-2m",
        maxDate: 0,
        onSelect: function (changeDate) {
            if ((Date.parse($('#startAt').val())).valueOf() > (Date.parse($('#endAt').val())).valueOf()) {
                $('#startAt').val($('#endAt').val());
            }
        }
    });
});
</script>
@endsection