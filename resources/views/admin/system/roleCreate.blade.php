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
                <h4 class="card-title">{{ trans('custom.admin.detail.create.' . $activePage) }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ $activeUrl }}" class="btn btn-sm btn-primary">{{ trans('custom.button.goList') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="name">
                    <span class="text-danger">*</span>{{ trans('custom.admin.form.systemRole.name') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                      <input class="form-control" name="name" id="name" type="text" placeholder="{{ trans('custom.admin.placeholder.roleName') }}" value="{{ old('name', '') }}" required aria-required="true" maxlength="20">
                       @if ($errors->has('name'))
                       <div class="error text-danger pl-3" for="name">
                           <strong>{{ $errors->first('name') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="active">
                    <span class="text-danger">*</span>{{ trans('custom.admin.form.systemRole.active') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       <select name="active" id="active" class="form-control">
                          <option value="1" @if( old('active', '') == 1) selected @endif>{{ trans('custom.admin.text.enable') }}</option>
                          <option value="2" @if( old('active', '') == 2) selected @endif>{{ trans('custom.admin.text.disable') }}</option>
                       </select>
                       @if ($errors->has('active'))
                       <div class="error text-danger pl-3" for="active">
                           <strong>{{ $errors->first('active') }}</strong>
                       </div>
                       @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="active">
                    <span class="text-danger">*</span>{{ trans('custom.admin.form.systemRole.permission') }}
                  </label>
                  <div class="col-sm-7">
                    <div class="form-group bmd-form-group">
                       @if ($errors->has('permission'))
                       <div class="error text-danger pl-3" for="permission">
                           <strong>{{ $errors->first('permission') }}</strong>
                       </div>
                       @endif
                       <div class="table-responsive">
                         <div class="form-check">
                          <input type="checkbox" id="allSelect" data-type="all-menu" value="1">
                          <label for="allSelect">
                            {{ __('custom.common.allSelect') }}
                          </label>
                         </div>
                         <table class="table table-hover table-bordered">
                           <thead>
                             <tr>
                               <th style="width:180px">{{ trans('custom.admin.form.systemRole.tableFunc') }}</th>
                               <th>{{ trans('custom.admin.text.action') }}</th>
                             </tr>
                           </thead>
                           <tbody>
                           @foreach(config('permission.func') as $cate)
                             <tr>
                               <td colspan="2" class="text-left">
                                <div class="form-check">
                                  <input type="checkbox" id="{{ $cate['key'] }}" data-type="cate" value="1" class="all-menu-allSelect cate">
                                  <label for="{{ $cate['key'] }}">
                                    {{ __('custom.admin.func.'. $cate['key']) }}
                                  </label>
                                </div>
                               </td>
                             </tr>
                             @foreach ($cate['menu'] as $menu)
                             <tr>
                              <td class="text-left">
                                <div class="form-check">
                                  <input type="checkbox" id="{{ $menu['key'] }}" data-type="menu" class="all-menu-allSelect menu cate-{{ $cate['key'] }}" value="1">
                                  <label for="{{ $menu['key'] }}">
                                    {{ __('custom.admin.func.'. $menu['key']) }}
                                  </label>
                                </div>
                              </td>
                              <td>
                                @foreach ($menu['permission'] as $permission)
                                <div class="form-check float-left" style="width:20%">
                                  <input type="checkbox" name="permission[]" id="{{ $menu['key'] . $permission }}" class="all-menu-allSelect cate-{{ $cate['key'] }} menu-{{ $menu['key'] }}"  value="{{ $menu['path'] . '-' . $permission }}">
                                  <label for="{{ $menu['key'] . $permission }}">
                                    {{ __('custom.admin.form.systemRole.' . $permission) }}
                                  </label>
                                </div>
                                @endforeach
                                <div class="clearfix"></div>
                              </td>
                             </tr>
                             @endforeach
                           @endforeach
                           </tbody>
                         </table>
                       </div>
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

@push('js')
<script>
$(function() {
  $('.cate, .menu, #allSelect').click(function() {
    $('.' + $(this).data('type') + '-' + $(this).attr('id')).attr('checked', ($(this).is(':checked')) ? true : false);
  });
});
</script>
@endpush
