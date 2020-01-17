var checkCheckbox = (checkClass, parentId) => {
  let allChild = 0;
  let childCheck = 0;

  $(checkClass).each(function () {
    if ($(this).is(':checked')) {
      childCheck++;
    }
    allChild++;
  });

  if (allChild === childCheck) {
    document.getElementById(parentId).indeterminate = false;
    $('#' + parentId).prop('checked', true);
  } else if (childCheck > 0) {
    document.getElementById(parentId).indeterminate = true;
    $('#' + parentId).prop('checked', false);
  } else {
    document.getElementById(parentId).indeterminate = false;
    $('#' + parentId).prop('checked', false);
  }
};

var allCheckOrCancelCheckbox = (obj) => {
  $('.' + $(obj).data('type') + '-' + $(obj).attr('id')).prop('checked', ($(obj).is(':checked')) ? true : false);
  $('.' + $(obj).data('type') + '-' + $(obj).attr('id')).prop('indeterminate', false);
}

$(function() {
  $('.cate, #allSelect').click(function () {
    allCheckOrCancelCheckbox(this);
    checkCheckbox('.all-menu-allSelect', 'allSelect');
  });

  $('.permission').click(function () {
    const parent = $(this).data('parent');
    const upperParent = $($('#' + parent)).data('parent');
    checkCheckbox('.menu-' + parent, parent);
    checkCheckbox('.cate-' + upperParent, upperParent);
    checkCheckbox('.all-menu-allSelect', 'allSelect');
  });

  $('.menu').click(function () {
    allCheckOrCancelCheckbox(this);
    const parent = $(this).data('parent');
    checkCheckbox('.cate-' + parent, parent);
    checkCheckbox('.all-menu-allSelect', 'allSelect');
  });
});