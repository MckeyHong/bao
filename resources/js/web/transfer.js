var transferConfirm = () => {
  if ($('#inputCredit').val() > 0) {
    $('#credit').html($('#inputCredit').val());
    $('#confirmModal').modal('show');
  }
};

var doTransfer = () => {
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
