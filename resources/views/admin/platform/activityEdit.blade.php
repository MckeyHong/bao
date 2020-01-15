@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form id="operationForm" method="post" action="{{ $activeUrl }}/{{ $detail['id'] }}" autocomplete="off" class="form-horizontal">
            @csrf
            {{ method_field('PUT') }}
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('custom.admin.detail.edit.' . $activePage) }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ asset($activePath) }}" class="btn btn-sm btn-primary">{{ __('custom.button.goList') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="platform_id">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformActivity.platform_id') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="platform_id" id="platform_id" class="form-control" required aria-required="true">
                            <option value="">{{ __('custom.common.plzSelect') }}</option>
                            @foreach ($platform as $platformKey => $platformValue)
                            <option value="{{ $platformKey }}" @if( $detail['platform_id'] == $platformKey) selected @endif>{{ $platformValue }}</option>
                            @endforeach
                       </select>
                       @if ($errors->has('platform_id'))
                       <div class="error text-danger pl-3" for="platform_id">
                           <strong>{{ $errors->first('platform_id') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="start_at">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformActivity.start_at') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="start_at" id="start_at" type="text" placeholder="{{ __('custom.admin.placeholder.start_at') }}" value="{{ $detail['start_at'] }}" required aria-required="true">
                       @if ($errors->has('start_at'))
                       <div class="error text-danger pl-3" for="start_at">
                           <strong>{{ $errors->first('start_at') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="end_at">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformActivity.end_at') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="end_at" id="end_at" type="text" placeholder="{{ __('custom.admin.placeholder.end_at') }}" value="{{ $detail['end_at'] }}" required aria-required="true">
                       @if ($errors->has('end_at'))
                       <div class="error text-danger pl-3" for="end_at">
                           <strong>{{ $errors->first('end_at') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="rate">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformActivity.rate') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="rate" id="rate" type="text" placeholder="{{ __('custom.admin.placeholder.rateActivity') }}" value="{{ $detail['rate'] }}" required aria-required="true" minlength="1"  maxlength="1000">
                       @if ($errors->has('rate'))
                       <div class="error text-danger pl-3" for="rate">
                           <strong>{{ $errors->first('rate') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="active">
                    <span class="text-danger">*</span>{{ __('custom.admin.form.platformActivity.active') }}
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
@extends('layouts.edit.datepicker')
@endsection
