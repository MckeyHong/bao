@extends('web.layouts.app')

@section('css')
<style type="text/css">
.withdrawal-func-block {
    border-bottom: 1px solid #cccccc;
    margin-bottom: 5px;
    padding: 0 15px;
    line-height: 50px;
}

.withdrawal-amount {
    text-align: right;
}

.withdrawal-button-block {
    padding: 0 15px;
    margin-top: 5vh;
}

.modal-content {
    margin-top: 20vh;
}

.interset-thead-td {
    background-color: #DD2F2F;
    color: #ffffff;
}

.table-block {
    margin: 20px 0;
    padding: 0 15px;
}
.table {
    font-size: 0.8rem;
}

.table th, .table td {
    padding: 0.5rem;
}
</style>
@endsection

@section('content')
<section>
    <div>
        <div class="withdrawal-func-block">
            <div class="float-left">余额宝余额</div>
            <div class="float-right">$1.00000012</div>
            <div class="clearfix"></div>
        </div>
        <div class="withdrawal-func-block">
            <div class="float-left">您的专属利率</div>
            <div class="float-right">100 %</div>
            <div class="clearfix"></div>
        </div>
        <div class="withdrawal-func-block">
            <div class="float-left">目前累计利息</div>
            <div class="float-right">$0.0001929</div>
            <div class="clearfix"></div>
        </div>
        <div class="withdrawal-func-block">
            <div class="float-left">转入金额</div>
            <div class="float-right"><input type="number" minlength="1" value="100" class="withdrawal-amount" />元</div>
            <div class="clearfix"></div>
        </div>
        <div>
            <div class="text-center text-muted">今日可存(昨日洗码量)：$ 100,000.00</div>
        </div>
        <div class="withdrawal-button-block">
            <button type="button" class="btn btn-block btn-submit" data-toggle="modal" data-target="#confirmModal">立即转入</button>
        </div>
    </div>
    <div class="table-block">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td align="center" class="interset-thead-td">转入金额</td>
                    <td align="center" class="interset-thead-td">每小时获得利息</td>
                    <td align="center" class="interset-thead-td">当日获得利息</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="right">$ 100.00</td>
                    <td align="right">$ 0.04155251</td>
                    <td align="right">$ 1.73972027</td>
                </tr>
                <tr>
                    <td align="right">$ 1,000.00</td>
                    <td align="right">$ 1.14155251</td>
                    <td align="right">$ 27.3972602</td>
                </tr>
                <tr>
                    <td align="right">$ 10,000.00</td>
                    <td align="right">$ 11.14155251</td>
                    <td align="right">$ 27.3972602</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModal">系统提示</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>确定要执行下面步骤?</p>
            <p>转入$ <span class="text-danger">100.00</span> 元</p>
            <p>余额宝钱包$ <span class="text-danger">100.00</span> 元</p>
            <p class="text-muted">* 注:利息将重新计算</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-submit" onclick="doWithdrawal()">确定</button>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script>
var doWithdrawal = () => {
    $('#confirmModal').modal('hide');
};
</script>
@endsection