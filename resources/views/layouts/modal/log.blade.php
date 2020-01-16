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
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>{{ __('custom.admin.table.modalLog.created_at') }}</th>
                  <th>{{ __('custom.admin.table.modalLog.user') }}</th>
                  <th>{{ __('custom.admin.table.modalLog.type') }}</th>
                  <th>{{ __('custom.admin.table.modalLog.content') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>xxxx</td>
                  <td>xxxx</td>
                  <td>xxxx</td>
                  <td>xxxx</td>
                </tr>
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
<script>
  var logConfirm = (funcKey, funcId, message) => {
    $('#logInfo').html(message);
    $('#logModal').modal('show');
  }
</script>
@endpush