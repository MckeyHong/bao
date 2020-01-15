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
                  <div class="float-left search-label">{{ trans('custom.admin.search.platform') }}：</div>
                  <div class="float-left">
                    <select id="platform" name="platform" class="form-control-selector">
                      <option value="0">{{ trans('custom.common.all') }}</option>
                      @foreach ($platform as $platformKey => $platformValue)
                      <option value="{{ $platformKey }}" @if($get['platform'] == $platformKey) selected @endif>{{ $platformValue }}</option>
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
                  <div class="float-left search-label">{{ trans('custom.admin.search.status') }}：</div>
                  <div class="float-left">
                    <select id="status" name="status" class="form-control-selector">
                      @foreach (trans('custom.admin.statusList') as $statusKey => $statusValue)
                      <option value="{{ $statusKey }}" @if($get['status'] == $statusKey) selected @endif>{{ $statusValue }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-right">
                  <button type="submit" class="btn btn-white btn-round btn-just-icon">
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
                    <th align="center">{{ trans('custom.admin.table.memberList.platform_id') }}</th>
                    <th>{{ trans('custom.admin.table.memberList.account') }}</th>
                    <th>{{ trans('custom.admin.table.memberList.balance') }}</th>
                    <th>{{ trans('custom.admin.table.memberList.active') }}</th>
                    <th>{{ trans('custom.admin.text.record') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="5">{{ trans('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['platform_id'] }}</td>
                    <td>{{ $value['account'] }} ({{ $value['name'] }})</td>
                    <td>{{ $value['balance'] }}</td>
                    <td style="width:60px">
                        @if ($value['active'] == '1')
                        <span class="text-success">{{ trans('custom.admin.text.enable') }}</span>
                        @else
                        <span class="text-danger">{{ trans('custom.admin.text.disable') }}</span>
                        @endif
                    </td>
                    <td style="width:80px">&nbsp;</td>
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
@endsection
