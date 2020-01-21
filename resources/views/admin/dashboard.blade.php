@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('custom.admin.func.dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">save</i>
              </div>
              <p class="card-category">{{ __('custom.admin.table.dashboard.total.depositAmount') }}</p>
              <h3 class="card-title">{{ amount_format($lists['total']['depositAmount'], 0) }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> {{ __('custom.admin.table.dashboard.total.last') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">monetization_on</i>
              </div>
              <p class="card-category">{{ __('custom.admin.table.dashboard.total.interest') }}</p>
              <h3 class="card-title">{{ amount_format($lists['total']['interest'], 2) }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> {{ __('custom.admin.table.dashboard.total.last') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">add_circle</i>
              </div>
              <p class="card-category">{{ __('custom.admin.table.dashboard.total.depositCount') }}</p>
              <h3 class="card-title">{{ amount_format($lists['total']['depositCount'], 0) }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> {{ __('custom.admin.table.dashboard.total.last') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">remove_circle_outline</i>
              </div>
              <p class="card-category">{{ __('custom.admin.table.dashboard.total.withdrawalCount') }}</p>
              <h3 class="card-title">{{ amount_format($lists['total']['withdrawalCount'], 0) }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> {{ __('custom.admin.table.dashboard.total.last') }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div style="font-size: 1.1rem;margin-bottom: 10px">{{ __('custom.admin.table.dashboard.title') }}</div>
              <div class="table-responsive">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th align="center">{{ __('custom.admin.table.dashboard.platform') }}</th>
                      <th>{{ __('custom.admin.table.dashboard.activity') }}</th>
                      <th>{{ __('custom.admin.table.dashboard.rate') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lists['lists'] as $value)
                    <tr>
                      <td>{{ $value['name'] }}</td>
                      <td>@if ($value['activity']) <i class="material-icons">done</i> @endif</td>
                      <td>{{ $value['present'] }}</td>
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
