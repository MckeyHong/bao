@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @extends('layouts.execute')
          <form id="operationForm" method="post" action="{{ asset('ctl/system/profile') }}" autocomplete="off" class="form-horizontal">
            @csrf
            {{ method_field('PUT') }}
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('custom.admin.detail.edit.' . $activePage) }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="account">
                    {{ __('custom.admin.form.systemProfile.account') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      {{ $lists['account'] }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="name">
                    {{ __('custom.admin.form.systemProfile.name') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      {{ $lists['name'] }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="old_password">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemProfile.old_password') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" type="password" name="old_password" id="old_password" placeholder="{{ __('custom.admin.placeholder.old_password') }}" value="" minlength="6" maxlength="20">
                      @if ($errors->has('old_password'))
                      <div class="error text-danger pl-3" for="old_password">
                         <strong>{{ $errors->first('old_password') }}</strong>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="password">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemProfile.password') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" type="password" name="password" id="password" placeholder="{{ __('custom.admin.placeholder.password') }}" value="" minlength="6" maxlength="20">
                      @if ($errors->has('password'))
                      <div class="error text-danger pl-3" for="password">
                         <strong>{{ $errors->first('password') }}</strong>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="password_confirmation">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemProfile.password_confirmation') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" placeholder="{{ __('custom.admin.placeholder.password_confirmation') }}" value="" minlength="6" maxlength="20">
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="button" class="btn btn-default mr-4" onclick="document.getElementById('operationForm').reset();">{{ __('custom.button.reset') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('custom.button.submit') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
