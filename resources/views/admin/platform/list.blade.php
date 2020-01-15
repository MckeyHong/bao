@extends('layouts.app')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ trans('custom.admin.table.platformList.name') }}</th>
                    <th>{{ trans('custom.admin.table.platformList.present') }}</th>
                    <th>{{ trans('custom.admin.table.platformList.future') }}</th>
                    <th>{{ trans('custom.admin.table.platformList.active') }}</th>
                    <th>{{ trans('custom.admin.table.platformList.updated_at') }}</th>
                    <th>{{ trans('custom.admin.text.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="6">{{ trans('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['name'] }}</td>
                    <td>{{ $value['present'] }}</td>
                    <td>{{ $value['future'] }}</td>
                    <td>
                        @if ($value['active'] == '1')
                        <span class="text-success">{{ trans('custom.admin.text.enable') }}</span>
                        @else
                        <span class="text-false">{{ trans('custom.admin.text.disable') }}</span>
                        @endif
                    </td>
                    <td>{{ $value['updated_at'] }}</td>
                    <td>
                        <i class="material-icons lists-icons" title="{{ __('custom.button.edit') }}" onclick="window.location.href='{{ $activeUrl }}/edit/{{ $value['id'] }}'">edit</i>
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
