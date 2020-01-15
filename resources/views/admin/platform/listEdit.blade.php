@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form id="operationForm" method="post" action="{{ $activeUrl . '/' . $detail['id'] }}" autocomplete="off" class="form-horizontal">
            @csrf
            {{ method_field('PUT') }}
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('custom.admin.detail.edit.' . $activePage) }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ asset($activePath) }}" class="btn btn-sm btn-primary">{{ __('custom.button.goList') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="name">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformList.name') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="name" id="name" type="text" placeholder="{{ __('custom.admin.placeholder.name') }}" value="{{ $detail['name'] }}" required aria-required="true" maxlength="30">
                       @if ($errors->has('name'))
                       <div class="error text-danger pl-3" for="name">
                           <strong>{{ $errors->first('name') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="name">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformList.future') }}
                  </label>
                  <div class="col-sm-4">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="future" id="future" type="text" placeholder="{{ __('custom.admin.placeholder.future') }}" value="{{ $detail['future'] }}" required aria-required="true" minlength="1"  maxlength="100">
                       <div class="error text-danger pl-3" for="future">
                           <strong>{{ __('custom.admin.form.platformList.futureRemark') }}</strong>
                       </div>
                       @if ($errors->has('future'))
                       <div class="error text-danger pl-3" for="future">
                           <strong>{{ $errors->first('future') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                  <div class="col-sm-3 text-left" style="line-height: 50px">
                    <label>
                      {{ __('custom.admin.form.platformList.present') }}
                    </label>
                    {{ $detail['present'] }} %
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="active">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformList.active') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="active" id="active" class="form-control">
                          <option value="1" @if( $detail['active'] == 1) selected @endif>{{ __('custom.admin.text.enable') }}</option>
                          <option value="2" @if( $detail['active'] == 2) selected @endif>{{ __('custom.admin.text.disable') }}</option>
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
