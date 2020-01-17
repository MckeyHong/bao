@extends('layouts.app')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        @extends('layouts.execute')
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ __('custom.admin.table.platformList.name') }}</th>
                    <th>{{ __('custom.admin.table.platformList.present') }}</th>
                    <th>{{ __('custom.admin.table.platformList.future') }}</th>
                    <th>{{ __('custom.admin.table.platformList.active') }}</th>
                    <th>{{ __('custom.admin.table.platformList.updated_at') }}</th>
                    <th>{{ __('custom.admin.text.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="6">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['name'] }}</td>
                    <td>{{ $value['present'] }}</td>
                    <td>{{ $value['future'] }}</td>
                    <td>
                        @if ($value['active'] == '1')
                        <span class="text-success">{{ __('custom.admin.text.enable') }}</span>
                        @else
                        <span class="text-false">{{ __('custom.admin.text.disable') }}</span>
                        @endif
                    </td>
                    <td>{{ $value['updated_at'] }}</td>
                    <td>
                      @if (isset($actionPermission['is_put']) && $actionPermission['is_put'] == 1)
                        <i class="material-icons lists-icons" title="{{ __('custom.button.edit') }}" onclick="window.location.href='{{ $activeUrl }}/edit/{{ $value['id'] }}'">edit</i>
                      @endif
                      <i class="material-icons lists-icons lists-icons-multi" title="{{ __('custom.button.log') }}">description</i>
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
@endsection
