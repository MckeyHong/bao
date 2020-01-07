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
            <div class="float-left">提领金额</div>
            <div class="float-right"><input type="number" minlength="1" value="100" class="withdrawal-amount" onClick="this.select();" />元</div>
            <div class="clearfix"></div>
        </div>
        <div class="withdrawal-button-block">
            <button type="button" class="btn btn-block btn-submit" data-toggle="modal" data-target="#confirmModal">确定提领</button>
        </div>
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
            <p>确定是否要提领$ <span class="text-danger">100.00</span> 元</p>
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