@extends('web.layouts.app')

@section('css')
<style type="text/css">
.deposit-func-block {
    border-bottom: 1px solid #cccccc;
    margin-bottom: 5px;
    padding: 0 15px;
    line-height: 50px;
}

.deposit-amount {
    text-align: right;
    border: 0;
}

.deposit-button-block {
    padding: 0 15px;
    margin-top: 5vh;
}

.modal-content {
    margin-top: 20vh;
}

.interset-thead-td {
    background-color: #EF5145;
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
        <div class="deposit-func-block">
            <div class="float-left">余额宝钱包</div>
            <div class="float-right">$ {{ amount_format($member['balance'], 2) }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="deposit-func-block">
            <div class="float-left">您的专属利率</div>
            <div class="float-right">{{ amount_format($rate, 2) }} %</div>
            <div class="clearfix"></div>
        </div>
        <div class="deposit-func-block">
            <div class="float-left">目前累计利息</div>
            <div class="float-right">$ {{ amount_format($member['interest'], 8) }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="deposit-func-block">
            <div class="float-left">转入金额</div>
            <div class="float-right">
                <input type="hidden" id="depositMax" name="depositMax" value="{{ $default_deposit }}" />
                <input type="text" id="depositCredit" value="{{ floor_format($default_deposit, 2) }}" class="deposit-amount" onClick="this.select();" onchange="checkEnterCredit(this)" />元
            </div>
            <div class="clearfix"></div>
        </div>
        <div>
            <div class="text-center text-muted">今日可存(昨日洗码量)：$ {{ amount_format($betTotal, 2) }}</div>
        </div>
        <div class="deposit-button-block">
            <button type="button" class="btn btn-block btn-submit" onClick="depositConfirm()" data-toggle="modal" data-target="#confirmModal">立即转入</button>
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
                @foreach ($example as $value)
                <tr>
                    <td align="right">$ {{ $value['amount'] }}</td>
                    <td align="right">$ {{ $value['hour'] }}</td>
                    <td align="right">$ {{ $value['day'] }}</td>
                </tr>
                @endforeach
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
            <p>转入$ <span id="credit" class="text-danger"></span> 元</p>
            <p class="text-muted">* 注:利息将重新计算</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-submit" onclick="doDeposit()">确定</button>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script>
var depositConfirm = () => {
    $('#credit').html($('#depositCredit').val());
    $('#confirmModal').modal('show');
};

var doDeposit = () => {
    $('#confirmModal').modal('hide');
};

var checkEnterCredit = (obj) => {
    const defaultDeposit = parseFloat($('#depositMax').val());
    obj.value = parseFloat((parseFloat(obj.value) > defaultDeposit) ? defaultDeposit : obj.value).toFixed(2);
};
</script>
@endsection