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
              <form method="GET">
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.role') }}：</div>
                  <div class="float-left">
                    <select id="role" name="role" class="form-control-selector">
                      <option value="0">{{ __('custom.common.all') }}</option>
                      @foreach ($role as $roleKey => $roleValue)
                      <option value="{{ $roleKey }}" @if($get['role'] == $roleKey) selected @endif>{{ $roleValue }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.account') }}：</div>
                  <div class="float-left"><input id="account" name="account" class="form-control search-input" value="{{ $get['account'] }}" /></div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.active') }}：</div>
                  <div class="float-left">
                    <select id="active" name="active" class="form-control-selector">
                      @foreach (__('custom.admin.activeList') as $activeKey => $activeValue)
                      <option value="{{ $activeKey }}" @if($get['active'] == $activeKey) selected @endif>{{ $activeValue }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-button-block">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon btn-search" title="{{ __('custom.button.search') }}">
                    <i class="material-icons">search</i>
                  </button>
                </div>
                <div class="float-right">
                  @if (isset($actionPermission['is_post']) && $actionPermission['is_post'] == 1)
                    <a href="{{ $activeUrl }}/create" class="btn btn-sm btn-primary">{{ __('custom.admin.text.add') }}<div class="ripple-container"></div></a>
                  @endif
                </div>
                <div class="clearfix"></div>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ __('custom.admin.table.systemUser.role_id') }}</th>
                    <th>{{ __('custom.admin.table.systemUser.account') }}</th>
                    <th>{{ __('custom.admin.table.systemUser.name') }}</th>
                    <th>{{ __('custom.admin.table.systemUser.active') }}</th>
                    <th>{{ __('custom.admin.table.systemUser.created_at') }}</th>
                    <th>{{ __('custom.admin.text.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="6">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  @php
                    $value['deletePath'] = asset('ctl/system/user') . '/' . $value['id'];
                    $value['deleteMsg'] = trans('custom.admin.table.systemUser.account') . '：' . $value['account'];
                  @endphp
                  <tr>
                    <td>{{ $value['role_id'] }}</td>
                    <td>{{ $value['account'] }}</td>
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
                        @if (isset($actionPermission['is_put']) && $actionPermission['is_put'] == 1)
                         <i class="material-icons lists-icons" title="{{ __('custom.button.edit') }}" onclick="window.location.href='{{ $activeUrl . '/edit/' . $value['id'] }}'">edit</i>
                        @endif
                        @if (isset($actionPermission['is_delete']) && $actionPermission['is_delete'] == 1)
                          <i class="material-icons lists-icons lists-icons-multi" title="{{ __('custom.button.delete') }}" onclick="deleteConfirm('{{ $value['deletePath'] }}', '{{ $value['deleteMsg'] }}')">delete</i>
                        @endif
                        <i class="material-icons lists-icons lists-icons-multi" title="{{ __('custom.button.log') }}">description</i>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="pagination-block">
                @if ($lists->count() > 0)
                  {{ $lists->appends($get)->links() }}
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
