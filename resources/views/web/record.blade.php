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

#more-block {
    margin-bottom: 20px;
}
</style>
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
                <input type="hidden" id="page" name="page" value="2" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/vendor/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/vendor/datepicker-zh-CN.js') }}"></script>
<script>
$.datepicker.setDefaults($.datepicker.regional[ "zh-CH" ]);

var searchRecord = () => {
    toggleLoading('block');
    $('#record-list').html('');
    $('#page').val(1);
    this.getRecord();
};

var getRecord = () => {
    axios.get('/api/v1/record', { params: {
        start: $('#start').val(),
        end: $('#end').val(),
        page: $('#page').val()
    }}).then(function (response) {
        const { more, total, list } = response.data.result;
        if (more !== true) {
            $('#more-block').css('display', 'none');
        } else {
            $('#more-block').css('display', 'block');
            $('#page').val(parseInt($('#page').val()) + 1);
        }

        if ($('#page').val() == '1') {
            $('#total-block').css('display', 'block');
            $('#totalInterest').html(total);
        }

        let html = '';
        if (list.data.length === 0) {
            html = '<div class="record-info-block bg-light text-center">{{ __('custom.common.noData') }}</div>';
            $('#total-block').css('display', 'none');
        } else {
            $('#total-block').css('display', 'block');
            list.data.forEach(function (item) {
                html += '<div class="record-info-block bg-light">'
                     +  '    <div>'
                     +  '        <div class="float-left">{{ __('custom.web.record.table.created_at') }}</div>'
                     +  '        <div class="float-right">' + item.created_at + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">{{ __('custom.web.record.table.credit_before') }}</div>'
                     +  '        <div class="float-right">$ ' + item.credit_before + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">{{ __('custom.web.record.table.credit') }}</div>'
                     +  '        <div class="float-right ' + item.class + '">[' + item.type + '] $ ' + item.credit + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">{{ __('custom.web.record.table.credit_after') }}</div>'
                     +  '        <div class="float-right">$ ' + item.credit_after + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">{{ __('custom.web.record.table.interest') }}</div>'
                     +  '        <div class="float-right">$ ' + item.interest + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '</div>'
                     +  '<hr>';
            });
        }
        $('#record-list').append(html);
        toggleLoading('none');
    }).catch(function (response) {
        alert('{{ __('custom.common.internalServer') }}');
        toggleLoading('none');
    });
};

var quickSearch = (type) => {
    switch (type) {
        case 'yesterday':
            $('#start, #end').val(moment().subtract(1, 'day').format('YYYY-MM-DD'));
            break;
        case 'thisWeek':
            $('#start').val(moment().startOf('isoWeek').format('YYYY-MM-DD'));
            $('#end').val(moment().endOf('isoWeek').format('YYYY-MM-DD'));
            break;
        case 'lastWeek':
            $('#start').val(moment().subtract(1, 'weeks').startOf('isoWeek').format('YYYY-MM-DD'));
            $('#end').val(moment().subtract(1, 'weeks').endOf('isoWeek').format('YYYY-MM-DD'));
            break;
        default:
            $('#start, #end').val(moment().format('YYYY-MM-DD'));
    }
    this.searchRecord();
};

$(function () {
    $('#start, #end').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: "-2m",
        maxDate: 0,
        onSelect: function (changeDate) {
            if ((Date.parse($('#start').val())).valueOf() > (Date.parse($('#end').val())).valueOf()) {
                $('#start').val($('#end').val());
            }
            searchRecord();
        }
    });
});
</script>
@endsection