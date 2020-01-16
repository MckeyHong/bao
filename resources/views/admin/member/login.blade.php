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
                  <div class="float-left search-label">{{ __('custom.admin.search.platform') }}：</div>
                  <div class="float-left">
                    <select id="platform" name="platform" class="form-control-selector">
                      <option value="0">{{ __('custom.common.all') }}</option>
                      @foreach ($platform as $platformKey => $platformValue)
                      <option value="{{ $platformKey }}" @if($get['platform'] == $platformKey) selected @endif>{{ $platformValue }}</option>
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
                    <th align="center">{{ __('custom.admin.table.memberLogin.created_at') }}</th>
                    <th>{{ __('custom.admin.table.memberLogin.platform_id') }}</th>
                    <th>{{ __('custom.admin.table.memberLogin.member') }}</th>
                    <th>{{ __('custom.admin.table.memberLogin.login_ip') }}</th>
                    <th>{{ __('custom.admin.table.memberLogin.area') }}</th>
                    <th>{{ __('custom.admin.table.memberLogin.device') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="6">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['created_at'] }}</td>
                    <td>{{ $value['platform_id'] }}</td>
                    <td>{{ $value['member_account'] }} ({{ $value['member_name'] }})</td>
                    <td>{{ $value['login_ip'] }}</td>
                    <td>{{ $value['area'] }}</td>
                    <td>{{ $value['device_info'] }}</td>
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
