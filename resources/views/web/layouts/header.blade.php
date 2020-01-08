<nav class="navbar navbar-expand-lg navbar-dark header-nav">
  <a class="navbar-brand" href="{{ asset('/') }}">{{ trans('custom.websiteName') }}</a>
  <div class="form-inline my-2 my-lg-0 text-white">
    <div class="float-left mr-3">{{ $member['account'] }}</div>
    <div class="float-right">$ {{ $member['platform_credit'] }}</div>
    <div class="clearfix"></div>
  </div>
</nav>