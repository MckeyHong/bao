@extends('layouts.app')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/vendor/jquery.datetimepicker.min.css') }}" />
@endpush

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
                      <option value="">{{ __('custom.common.all') }}</option>
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
                    <th align="center">{{ __('custom.admin.table.memberTransfer.created_at') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.platform') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.member') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.type') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.credit_before') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.credit') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.credit_after') }}</th>
                    <th>{{ __('custom.admin.table.memberTransfer.interest') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($lists) == 0)
                  <tr><td colspan="8">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['created_at'] }}</td>
                    <td>{{ $value['platform_id'] }}</td>
                    <td>{{ $value['account'] }}</td>
                    <td>{{ __('custom.transferList.' . $value['type']) }}</td>
                    <td>{{ amount_format($value['credit_before'], 8) }}</td>
                    <td>{{ amount_format($value['credit'], 8) }}</td>
                    <td>{{ amount_format($value['credit_after'], 8) }}</td>
                    <td>{{ amount_format($value['interest'], 8) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="pagination-block">
                @if (count($lists) > 0)
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

@push('js')
<script>
  const minDate = '{{ $firstDay }}';
</script>
<script src="{{ asset('js/vendor/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('js/admin/datetimepicker.js') }}"></script>
@endpush
