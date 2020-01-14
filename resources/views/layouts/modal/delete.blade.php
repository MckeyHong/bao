<div class="modal fade" id="deleteModal"  tabindex="-1" role="dialog" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="deleteForm" method="POST">
        @csrf
        {{ method_field('DELETE') }}
        <div class="modal-header">
          <h5 class="modal-title">{{ trans('custom.admin.modal.title.delete') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{ trans('custom.admin.modal.body.delete') }}</p>
          <p id="deleteInfo"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('custom.button.close') }}</button>
          <button type="submit" class="btn btn-primary">{{ trans('custom.button.submit') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('js')
<script>
  var deleteConfirm = (path, message) => {
    $('#deleteForm').attr('action', path);
    $('#deleteInfo').html(message);
    $('#deleteModal').modal('show');
  }
</script>
@endpush
