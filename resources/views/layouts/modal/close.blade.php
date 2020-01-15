<div class="modal fade" id="closeModal"  tabindex="-1" role="dialog" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="closeForm" method="POST">
        @csrf
        {{ method_field('PUT') }}
        <div class="modal-header">
          <h5 class="modal-title">{{ __('custom.admin.modal.title.close') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{ __('custom.admin.modal.body.close') }}</p>
          <p id="closeInfo"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('custom.button.close') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('custom.button.submit') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('js')
<script>
  var closeConfirm = (path, message) => {
    $('#closeForm').attr('action', path);
    $('#closeInfo').html(message);
    $('#closeModal').modal('show');
  }
</script>
@endpush
