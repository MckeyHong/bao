@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form id="operationForm" method="post" action="{{ $activeUrl }}" autocomplete="off" class="form-horizontal">
            @csrf
            {{ method_field('POST') }}
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('custom.admin.detail.create.' . $activePage) }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ $activeUrl }}" class="btn btn-sm btn-primary">{{ __('custom.button.goList') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="role_id">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemUser.role_id') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="role_id" id="role_id" class="form-control" required aria-required="true">
                            <option value="">{{ __('custom.common.plzSelect') }}</option>
                            @foreach ($role as $roleKey => $roleValue)
                            <option value="{{ $roleKey }}" @if( old('role_id', '') == $roleKey) selected @endif>{{ $roleValue }}</option>
                            @endforeach
                       </select>
                       @if ($errors->has('role_id'))
                       <div class="error text-danger pl-3" for="role_id">
                           <strong>{{ $errors->first('role_id') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="account">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemUser.account') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="account" id="account" type="text" placeholder="{{ __('custom.admin.placeholder.account') }}" value="{{ old('account', '') }}" required aria-required="true" minlength="4" maxlength="30">
                       @if ($errors->has('account'))
                       <div class="error text-danger pl-3" for="account">
                           <strong>{{ $errors->first('account') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="name">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemUser.name') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="name" id="name" type="text" placeholder="{{ __('custom.admin.placeholder.name') }}" value="{{ old('name', '') }}" required aria-required="true" maxlength="30">
                       @if ($errors->has('name'))
                       <div class="error text-danger pl-3" for="name">
                           <strong>{{ $errors->first('name') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="password">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemUser.password') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" type="password" name="password" id="password" placeholder="{{ __('custom.admin.placeholder.password') }}" value="" required minlength="6" maxlength="20">
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
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemUser.password_confirmation') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" placeholder="{{ __('custom.admin.placeholder.password_confirmation') }}" value="" required minlength="6" maxlength="20">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="active">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.systemUser.active') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="active" id="active" class="form-control">
                          <option value="1" @if( old('active', '') == 1) selected @endif>{{ __('custom.admin.text.enable') }}</option>
                          <option value="2" @if( old('active', '') == 2) selected @endif>{{ __('custom.admin.text.disable') }}</option>
                       </select>
                       @if ($errors->has('active'))
                       <div class="error text-danger pl-3" for="active">
                           <strong>{{ $errors->first('active') }}</strong>
                       </div>
                       @endif
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
