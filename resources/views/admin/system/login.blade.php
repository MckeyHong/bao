@extends('layouts.app')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th align="center">{{ trans('custom.admin.table.systemLogin.created_at') }}</th>
                    <th>{{ trans('custom.admin.table.systemLogin.user') }}</th>
                    <th>{{ trans('custom.admin.table.systemLogin.login_ip') }}</th>
                    <th>{{ trans('custom.admin.table.systemLogin.area') }}</th>
                    <th>{{ trans('custom.admin.table.systemLogin.status') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2010-10-01 00:00:00</td>
                    <td>user001 (管理员)</td>
                    <td>127.0.0.1</td>
                    <td>xxx,dddd</td>
                    <td class="text-success">登入成功</td>
                  </tr>
                  <tr>
                    <td>2010-10-01 00:00:00</td>
                    <td>user001 (管理员)</td>
                    <td>127.0.0.1</td>
                    <td>xxx,dddd</td>
                    <td class="text-success">登入成功</td>
                  </tr>
                </tbody>
              </table>
              <div class="text-center">
                <nav aria-label="Page navigation example" style="display: inline-block;">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
