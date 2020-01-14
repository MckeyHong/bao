@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form id="operationForm" method="post" action="{{ asset('ctl/system/user/'. $detail['id']) }}" autocomplete="off" class="form-horizontal">
            @csrf
            {{ method_field('PUT') }}
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ trans('custom.admin.detail.edit.' . $activePage) }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ asset($activePath) }}" class="btn btn-sm btn-primary">{{ trans('custom.button.goList') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="role_id">
                    <span class="text-danger">*</span>{{ trans('custom.admin.form.systemUser.role_id') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="role_id" id="role_id" class="form-control" required aria-required="true">
                            <option value="">{{ trans('custom.common.plzSelect') }}</option>
                            @foreach ($role as $roleKey => $roleValue)
                            <option value="{{ $roleKey }}" @if( $detail['role_id'] == $roleKey) selected @endif>{{ $roleValue }}</option>
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
                  <label class="col-sm-2 col-form-label" for="account">{{ trans('custom.admin.form.systemUser.account') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">{{ $detail['account'] }}</div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="name">
                    <span class="text-danger">*</span>{{ trans('custom.admin.form.systemUser.name') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="name" id="name" type="text" placeholder="{{ trans('custom.admin.placeholder.name') }}" value="{{ $detail['name'] }}" required aria-required="true" maxlength="30">
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
                    {{ trans('custom.admin.form.systemUser.password') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" type="password" name="password" id="password" placeholder="{{ trans('custom.admin.placeholder.password') }}" value="" minlength="6" maxlength="20">
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
                    {{ trans('custom.admin.form.systemUser.password_confirmation') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" placeholder="{{ trans('custom.admin.placeholder.password_confirmation') }}" value="" minlength="6" maxlength="20">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="active">
                    <span class="text-danger">*</span>{{ trans('custom.admin.form.systemUser.active') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="active" id="active" class="form-control">
                          <option value="1" @if( $detail['active'] == 1) selected @endif>{{ trans('custom.admin.text.enable') }}</option>
                          <option value="2" @if( $detail['active'] == 2) selected @endif>{{ trans('custom.admin.text.disable') }}</option>
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
                <button type="button" class="btn btn-default mr-4" onclick="document.getElementById('operationForm').reset();">{{ trans('custom.button.reset') }}</button>
                <button type="submit" class="btn btn-primary">{{ trans('custom.button.submit') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection