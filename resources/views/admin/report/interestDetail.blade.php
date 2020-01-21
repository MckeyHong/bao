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
                  <div class="float-left">{{ $get['start'] }}</div>
                  <div class="float-left search-label"> ~ </div>
                  <div class="float-left">{{ $get['end'] }}</div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.platform') }}：</div>
                  <div class="float-left">{{ $platform }}</div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-right">
                  <a href="{{ $goBack }}" class="btn btn-sm btn-primary">{{ __('custom.button.goBack') }}</a>
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
                    <td>$ {{ amount_format($lists['total']['interest'], 8) }}</td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ __('custom.admin.table.reportInterest.date') }}</th>
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
                    <td>{{ $value['bet_at'] }}</td>
                    <td>{{ amount_format($value['deposit_credit'], 2) }}</td>
                    <td>{{ amount_format($value['interest'], 8) }}</td>
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
@endpush
