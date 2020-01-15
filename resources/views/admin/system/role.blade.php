@extends('layouts.app')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        @extends('layouts.execute')
        <div class="card">
          <div class="card-body">
            <div class="search-bar">
                <div class="float-right">
                  <a href="{{ $activeUrl }}/create" class="btn btn-sm btn-primary">{{ __('custom.admin.text.add') }}<div class="ripple-container"></div></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ __('custom.admin.table.systemRole.name') }}</th>
                    <th>{{ __('custom.admin.table.systemRole.active') }}</th>
                    <th>{{ __('custom.admin.table.systemRole.created_at') }}</th>
                    <th>{{ __('custom.admin.text.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="4">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  @php
                    $value['editPath'] = $activeUrl . '/edit/' . $value['id'];
                    $value['deletePath'] = $activeUrl . '/' . $value['id'];
                    $value['deleteMsg'] = __('custom.admin.table.systemRole.name') . '：' . $value['name'];
                  @endphp
                  <tr>
                    <td>{{ $value['name'] }}</td>
                    <td style="width:80px">
                        @if ($value['active'] == '1')
                        <span class="text-success">{{ __('custom.admin.text.enable') }}</span>
                        @else
                        <span class="text-danger">{{ __('custom.admin.text.disable') }}</span>
                        @endif
                    </td>
                    <td style="width: 150px">{{ $value['created_at'] }}</td>
                    <td style="width: 150px">
                        @if ($value['is_operation'])
                        <i class="material-icons lists-icons" title="{{ __('custom.button.edit') }}" onclick="window.location.href='{{ $value['editPath'] }}'">edit</i>
                        <i class="material-icons lists-icons lists-icons-multi" title="{{ __('custom.button.delete') }}" onclick="deleteConfirm('{{ $value['deletePath'] }}', '{{ $value['deleteMsg'] }}')">delete</i>
                        <i class="material-icons lists-icons lists-icons-multi" title="{{ __('custom.button.log') }}">description</i>
                        @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="pagination-block">
                @if ($lists->count() > 0)
                  {{ $lists->links() }}
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@extends('layouts.modal.delete')
@endsection
