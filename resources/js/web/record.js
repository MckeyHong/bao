$.datepicker.setDefaults($.datepicker.regional["zh-CH"]);

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
        if ($('#page').val() == '1') {
            $('#total-block').css('display', 'block');
            $('#totalInterest').html(total);
        }

        if (more !== true) {
            $('#more-block').css('display', 'none');
        } else {
            $('#more-block').css('display', 'block');
            $('#page').val(parseInt($('#page').val()) + 1);
        }


        let html = '';
        if (list.data.length === 0) {
            html = '<div class="record-info-block bg-light text-center">' + languages.noData + '</div>';
            $('#total-block').css('display', 'none');
        } else {
            $('#total-block').css('display', 'block');
            list.data.forEach(function (item) {
                html += '<div class="record-info-block bg-light">'
                     +  '    <div>'
                     +  '        <div class="float-left">' + languages.table.created_at + '</div>'
                     +  '        <div class="float-right">' + item.created_at + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">' + languages.table.credit_before + '</div>'
                     +  '        <div class="float-right">$ ' + item.credit_before + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">' + languages.table.credit + '</div>'
                     +  '        <div class="float-right ' + item.class + '">[' + item.type + '] $ ' + item.credit + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">' + languages.table.credit_after + '</div>'
                     +  '        <div class="float-right">$ ' + item.credit_after + '</div>'
                     +  '        <div class="clearfix"></div>'
                     +  '    </div>'
                     +  '    <div>'
                     +  '        <div class="float-left">' + languages.table.interest + '</div>'
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
        alert(languages.error);
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