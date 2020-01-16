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
                  <div class="float-left search-label">{{ __('custom.admin.search.time') }}：</div>
                  <div class="float-left"><input id="start" name="start" class="form-control search-input" value="{{ $get['start'] }}" /></div>
                  <div class="float-left search-label"> ~ </div>
                  <div class="float-left"><input id="end" name="end" class="form-control search-input" value="{{ $get['end'] }}" /></div>
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
                  <div class="float-left search-label">{{ __('custom.admin.search.status') }}：</div>
                  <div class="float-left">
                    <select id="status" name="status" class="form-control-selector">
                      @foreach (__('custom.admin.loginList') as $statusKey => $statusValue)
                      <option value="{{ $statusKey }}" @if($get['status'] == $statusKey) selected @endif>{{ $statusValue }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon btn-search">
                    <i class="material-icons">search</i>
                  </button>
                </div>
                <div class="clearfix"></div>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th align="center">{{ __('custom.admin.table.systemLogin.created_at') }}</th>
                    <th>{{ __('custom.admin.table.systemLogin.user') }}</th>
                    <th>{{ __('custom.admin.table.systemLogin.login_ip') }}</th>
                    <th>{{ __('custom.admin.table.systemLogin.area') }}</th>
                    <th>{{ __('custom.admin.table.systemLogin.status') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="5">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['created_at'] }}</td>
                    <td>{{ $value['user_account'] }} ({{ $value['user_name'] }})</td>
                    <td>{{ $value['login_ip'] }}</td>
                    <td>{{ $value['area'] }}</td>
                    <td class="{{ $value['class'] }}">{{ __('custom.admin.loginList.' . $value['status']) }}</td>
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
@extends('layouts.search.datepickerInterval')
@endsection
