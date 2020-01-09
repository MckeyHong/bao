<nav class="navbar navbar-expand-lg navbar-dark header-nav container">
  <div class="float-left" style="width: 35%">
    <a class="navbar-brand" href="{{ asset('/') }}">{{ trans('custom.websiteName') }}</a>
  </div>
  <div class="text-right text-white float-right" style="width: 65%">
    <span>{{ $member['account'] }}</span>
    <span style="margin-left: 15px;">$ {{ amount_format($member['platform_credit'], 2) }}</span>
  </div>
  <div class="clearfix"></div>
</nav>