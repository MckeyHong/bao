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
                  <div class="float-left search-label">{{ __('custom.admin.search.operation') }}：</div>
                  <div class="float-left">
                    <select id="func" name="func" class="form-control-selector">
                      <option value="">{{ __('custom.common.all') }}</option>
                      @foreach (config('permission.operation') as $funcKey)
                      <option value="{{ $funcKey }}" @if ($get['func'] == $funcKey) selected @endif>{{ __('custom.admin.operation.funcKey.' . $funcKey) }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.user') }}：</div>
                  <div class="float-left">
                    <select id="user" name="user" class="form-control-selector">
                      <option value="">{{ __('custom.common.all') }}</option>
                      @foreach ($user as $userId => $userName)
                      <option value="{{ $userId }}" @if ($get['user'] == $userId) selected @endif>{{ $userName }}</option>
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
                    <th>{{ __('custom.admin.table.systemOperation.created_at') }}</th>
                    <th>{{ __('custom.admin.table.systemOperation.user') }}</th>
                    <th>{{ __('custom.admin.table.systemOperation.func') }}</th>
                    <th>{{ __('custom.admin.table.systemOperation.targets') }}</th>
                    <th>{{ __('custom.admin.table.systemOperation.content') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists->count() == 0)
                  <tr><td colspan="5">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists as $value)
                  <tr>
                    <td>{{ $value['created_at'] }}<br />{{ $value['ip'] }}</td>
                    <td>{{ $value['user_account'] }}<br />{{ $value['user_name'] }}</td>
                    <td>{{ __('custom.admin.operation.funcKey.' . $value['func_key']) }}<br />{{ __('custom.admin.operation.type.' . $value['type']) }}</td>
                    <td>{{ $value['targets'] }}</td>
                    <td class="text-left">{!! $value['content'] !!}</td>
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

@push('js')
<script>
  const minDate = '{{ $firstDay }}';
</script>
<script src="{{ asset('js/vendor/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('js/admin/datetimepicker.js') }}"></script>
@endpush
