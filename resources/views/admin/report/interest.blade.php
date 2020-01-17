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
                  <div class="float-left"><input id="end" name="end" class="form-control search-input"value="{{ $get['end'] }}" /></div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.platform') }}：</div>
                  <div class="float-left">
                    <select id="platform" name="platform" class="form-control-selector">
                      <option value="">{{ __('custom.common.all') }}</option>
                      @foreach ($platform as $platformKey => $platformValue)
                      <option value="{{ $platformKey }}" @if ($platformKey == $get['platform']) selected @endif>{{ $platformValue }}</option>
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
                    <th>{{ __('custom.admin.table.reportInterest.total_deposit_credit') }}</th>
                    <th>{{ __('custom.admin.table.reportInterest.total_interest') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="width:50%">$ {{ amount_format($lists['total']['deposit_credit'], 2) }}</td>
                    <td>$ {{ amount_format($lists['total']['transfer_interest'], 2) }}</td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ __('custom.admin.table.reportInterest.platform_id') }}</th>
                    <th>{{ __('custom.admin.table.reportInterest.deposit_credit') }}</th>
                    <th>{{ __('custom.admin.table.reportInterest.interest') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($lists['lists']->count() == 0)
                  <tr><td colspan="3">{{ __('custom.common.noData') }}</td></tr>
                  @endif
                  @foreach ($lists['lists'] as $value)
                  <tr>
                    <td>{{ $value['platform_id'] }}</td>
                    <td>{{ amount_format($value['deposit_credit'], 2) }}</td>
                    <td>{{ amount_format($value['transfer_interest'], 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/vendor/jquery.datetimepicker.full.min.js') }}"></script>
<script>
$(function () {
    $('#start, #end').datetimepicker({
        format: 'Y-m-d',
        lang: 'zh',
        minDate: '{{ $firstDay }}',
        maxDate: 0,
        timepicker: false,
        onSelectDate: function (ct) {
          $('#start').val(($('#start').val() <= $('#end').val()) ? $('#start').val() : $('#end').val());
        }
    });
});
</script>
@endpush
