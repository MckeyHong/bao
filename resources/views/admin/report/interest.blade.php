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
                  <div class="float-left"><input id="start" name="start" class="form-control search-input"/></div>
                  <div class="float-left search-label"> ~ </div>
                  <div class="float-left"><input id="end" name="end" class="form-control search-input" /></div>
                  <div class="clearfix"></div>
                </div>
                <div class="float-left search-label">、</div>
                <div class="float-left">
                  <div class="float-left search-label">{{ __('custom.admin.search.platform') }}：</div>
                  <div class="float-left">
                    <select id="platform" name="platform" class="form-control-selector">
                      @foreach ($platform as $platformKey => $platformValue)
                      <option value="{{ $platformKey }}">{{ $platformValue }}</option>
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
                    <td>$ 888,000.98</td>
                    <td>$ 888,000.98</td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>{{ __('custom.admin.table.reportInterest.platform_id') }}</th>
                    <th>{{ __('custom.admin.table.reportInterest.date') }}</th>
                    <th>{{ __('custom.admin.table.reportInterest.deposit_credit') }}</th>
                    <th>{{ __('custom.admin.table.reportInterest.interest') }}</th>
                    <th>{{ __('custom.admin.text.log') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>350抢红包</td>
                    <td>2020-01-15</td>
                    <td>$ 31,000</td>
                    <td>$ 12.22</td>
                    <td style="width:70px"><i class="material-icons lists-icons lists-icons-multi" title="{{ __('custom.button.log') }}">description</i></td>
                  </tr>
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
