var toCurrency = (num) => {
    var parts = num.toString().split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return parts.join('.');
}

var transferConfirm = () => {
  if ($('#inputCredit').val() > 0) {
    $('#credit').html(toCurrency($('#inputCredit').val()));
    $('#confirmModal').modal('show');
  }
};

var doTransfer = () => {
    toggleLoading('block');
    axios.post('/api/v1/' + $('#transferType').val(), {
        credit: $('#inputCredit').val()
    }).then(function (response) {
        console.log(response);
        toggleLoading('none');
        // window.location.reload();
    }).catch(function (response) {
        alert('系统忙录中，请稍后再试，谢谢。');
        console.log(response);
        toggleLoading('none');
    });
    $('#confirmModal').modal('hide');
};

var checkEnterCredit = (obj) => {
    const defaultValue = parseFloat($('#defaultMax').val());
    obj.value = parseFloat((parseFloat(obj.value) > defaultValue) ? defaultValue : obj.value).toFixed(2);
    if (obj.value < 0.01) {
        $('#transferButton').attr('disabled', true);
    } else {
        $('#transferButton').attr('disabled', false);
    }
};
