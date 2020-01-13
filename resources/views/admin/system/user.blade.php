@extends('layouts.app')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="search-bar">
              <form method="GET">
                <div class="float-left">
                  <div class="float-left search-label">{{ trans('custom.admin.search.role') }}：</div>
                  <div class="float-left">
                    <select id="role" name="role" class="form-control-selector">
                      <option value="0">{{ trans('custom.common.all') }}</option>
                      @foreach ($role as $roleKey => $roleValue)
                      <option value="{{ $roleKey }}" @if($get['role'] == $roleKey) selected @endif>{{ $roleValue }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ trans('custom.admin.search.account') }}：</div>
                  <div class="float-left"><input id="account" name="account" class="form-control search-input" value="{{ $get['account'] }}" /></div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ trans('custom.admin.search.active') }}：</div>
                  <div class="float-left">
                    <select id="active" name="active" class="form-control-selector">
                      @foreach (trans('custom.admin.activeList') as $activeKey => $activeValue)
                      <option value="{{ $activeKey }}" @if($get['active'] == $activeKey) selected @endif>{{ $activeValue }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon btn-search" title="{{ trans('custom.button.search') }}">
                    <i class="material-icons">search</i>
                  </button>
                </div>
                <div class="float-right">
                  <a href="#" class="btn btn-sm btn-primary">{{ trans('custom.admin.text.add') }}<div class="ripple-container"></div></a>
                </div>
                <div class="clearfix"></div>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ trans('custom.admin.table.systemUser.role_id') }}</th>
                    <th>{{ trans('custom.admin.table.systemUser.account') }}</th>
                    <th>{{ trans('custom.admin.table.systemUser.name') }}</th>
                    <th>{{ trans('custom.admin.table.systemUser.active') }}</th>
                    <th>{{ trans('custom.admin.table.systemUser.created_at') }}</th>
                    <th>{{ trans('custom.admin.text.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="6">{{ trans('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['role_id'] }}</td>
                    <td>{{ $value['account'] }}</td>
                    <td>{{ $value['name'] }}</td>
                    <td style="width:80px">
                        @if ($value['active'] == '1')
                        <span class="text-success">{{ trans('custom.admin.text.enable') }}</span>
                        @else
                        <span class="text-false">{{ trans('custom.admin.text.disable') }}</span>
                        @endif
                    </td>
                    <td style="width: 150px">{{ $value['created_at'] }}</td>
                    <td style="width: 150px">
                        <i class="material-icons lists-icons" title="{{ trans('custom.button.edit') }}">edit</i>
                        <i class="material-icons lists-icons lists-icons-multi" title="{{ trans('custom.button.delete') }}">delete</i>
                        <i class="material-icons lists-icons lists-icons-multi" title="{{ trans('custom.button.log') }}">description</i>
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
