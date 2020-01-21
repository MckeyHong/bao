<div class="modal fade bd-example-modal-lg" id="logModal"  tabindex="-1" role="dialog" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('custom.admin.modal.title.log') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <div id="logInfo"></div>
            <table id="logTable" class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>{{ __('custom.admin.table.modalLog.created_at') }}</th>
                  <th>{{ __('custom.admin.table.modalLog.user') }}</th>
                  <th>{{ __('custom.admin.table.modalLog.type') }}</th>
                  <th>{{ __('custom.admin.table.modalLog.content') }}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('custom.button.close') }}</button>
        </div>
    </div>
  </div>
</div>

@push('js')
<script src="{{ asset('js/admin.js') }}"></script>
<script>
  var logConfirm = (funcKey, funcId, message) => {
    $('#logTable > tbody').html('');
    $('#logInfo').html(message);
    // 取得資料
    axios.get('/ctl/system/operation/detail/' + funcKey + '/' + funcId)
      .then(function (response) {
          let layout = '';
          response.data.result.forEach(function (item) {
            layout += '<tr>';
            layout += '<td style="width:230px">' + item.created_at + ' (' + item.ip + ')</td>';
            layout += '<td style="width:150px">' + item.user_account + '(' + item.user_name + ')</td>';
            layout += '<td style="width:70px">' + item.type + '</td>';
            layout += '<td>' + item.content + '</td>';
            layout += '</tr>';
          });
          if (layout === '') {
            layout = '<tr><td colspan="4">{{ __('custom.common.noData') }}</td></tr>';
          }
          $('#logTable > tbody').append(layout);
      })
      .catch(function (error) {
        // handle error
        console.log('error ' + error);
      });
    $('#logModal').modal('show');
  }
</script>
@endpush