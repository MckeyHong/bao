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
            <div class="float-left">{{ __('custom.web.deposit.balance') }}</div>
            <div class="float-right">$ {{ amount_format($member['balance'], 2) }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="deposit-func-block">
            <div class="float-left">{{ __('custom.web.deposit.rate') }}</div>
            <div class="float-right">{{ amount_format($rate, 2) }} %</div>
            <div class="clearfix"></div>
        </div>
        <div class="deposit-func-block">
            <div class="float-left">{{ __('custom.web.deposit.interest') }}</div>
            <div class="float-right">$ {{ amount_format($member['interest'], 8) }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="deposit-func-block">
            <div class="float-left">{{ __('custom.web.deposit.deposit') }}</div>
            <div class="float-right">
                <input type="hidden" id="defaultMax" name="defaultMax" value="{{ $default_deposit }}" />
                <input type="text" id="inputCredit" name="inputCredit" value="{{ floor_format($default_deposit, 2) }}" class="deposit-amount" onClick="this.select();" onchange="checkEnterCredit(this)" />{{ __('custom.web.deposit.unit') }}
            </div>
            <div class="clearfix"></div>
        </div>
        <div>
            <div class="text-center text-muted">{{ __('custom.web.deposit.betTotal') }}：$ {{ amount_format($betTotal, 2) }}</div>
        </div>
        <div class="deposit-button-block">
            <button type="button" id="transferButton" class="btn btn-block btn-submit" onClick="transferConfirm()" @if ($default_deposit < 0.01) disabled @endif>{{ __('custom.web.deposit.save') }}</button>
        </div>
    </div>
    <div class="table-block">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td align="center" class="interset-thead-td">{{ __('custom.web.deposit.table.deposit') }}</td>
                    <td align="center" class="interset-thead-td">{{ __('custom.web.deposit.table.interestHour') }}</td>
                    <td align="center" class="interset-thead-td">{{ __('custom.web.deposit.table.interestDay') }}</td>
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
            <h5 class="modal-title" id="confirmModal">{{ __('custom.common.systemNotice') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ __('custom.web.deposit.modal.content') }}</p>
            <p>
                <input type="hidden" id="transferType" value="deposit" />
                <input type="hidden" id="transferUrl" value="{{ asset('/') }}" />
                {{ __('custom.web.deposit.modal.transfer') }}$ <span id="credit" class="text-danger"></span> {{ __('custom.web.deposit.unit') }}
            </p>
            <p class="text-muted">{{ __('custom.web.deposit.modal.remark') }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('custom.button.cancel') }}</button>
            <button type="button" class="btn btn-submit" onclick="doTransfer()">{{ __('custom.button.submit') }}</button>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('js/web/transfer.js') }}"></script>
@endsection