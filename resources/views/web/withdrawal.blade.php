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
    border: 0;
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
            <div class="float-left">余额宝钱包</div>
            <div class="float-right">$ {{ amount_format($member['balance'], 2) }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="withdrawal-func-block">
            <div class="float-left">提领金额</div>
            <div class="float-right">
              <input type="hidden" id="defaultMax" name="defaultMax" value="{{ $member['balance'] }}" />
              <input type="input" id="inputCredit" name="inputCredit" value="{{ floor_format($member['balance'], 2) }}" class="withdrawal-amount" onClick="this.select();" onchange="checkEnterCredit(this)" />元
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="withdrawal-button-block">
            <button type="button" id="transferButton" class="btn btn-block btn-submit" onClick="transferConfirm()" @if ($member['balance'] < 0.01) disabled @endif>确定提领</button>
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
            <p>
              确定是否要提领$ <span id="credit" class="text-danger"></span> 元
              <input type="hidden" id="transferType" value="withdrawal" />
              <input type="hidden" id="transferUrl" value="{{ asset('/withdrawal') }}" />
            </p>
            <p class="text-muted">* 注:其余额宝利息将重新计算配息</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-submit" onclick="doTransfer()">确定</button>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('js/web/transfer.js') }}"></script>
@endsection