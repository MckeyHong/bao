@extends('web.layouts.app')

@section('css')
<style type="text/css">
.rule-block {
    padding: 0 15px;
}

.rule-title {
    font-weight: 600;
    margin-bottom: 5px;
}

.rule-content-block {
    margin-top: 3vh;
}

.rule-border {
    border-bottom: 1px solid #cccccc;
    padding-bottom: 10px;
}

.rule-bottom {
    margin-bottom: 20px;
}
</style>
@endsection

@section('content')
<section class="rule-block">
    <div>
        <div class="rule-title">余额宝</div>
        <div class="rule-content rule-border">
            亚洲首创，高利率配息回馈，提供本平台玩家更有效的运用滞留额度。
        </div>
    </div>
    <div class="rule-bottom">
        <div class="rule-content-block rule-border">
            <div class="rule-title">立即充值：</div>
            <div class="rule-content">
                每日最多可充值与「昨日洗码量」等量的金额，昨日洗码量越高，则今日可充值额度越高，相对利息分配越多。
            </div>
        </div>
        <div class="rule-content-block rule-border">
            <div class="rule-title">昨日洗码量：</div>
            <div class="rule-content">
                昨日平台有效投注之总和。
            </div>
        </div>
        <div class="rule-content-block rule-border">
            <div class="rule-title">一键提领：</div>
            <div class="rule-content">
                您于余额宝的额度皆可随时提出，若资金转出余额宝，则停止计息。
            </div>
        </div>
        <div class="rule-content-block">
            <div class="rule-title">利息计算：</div>
            <div class="rule-content">
                余额宝于每日24:00进行结算，结算作业10分钟，期间不计息，
                系统会将您今日所产生之利息结算后，连同剩馀本金(整数)转回您的主钱包。
            </div>
        </div>
    </div>
</section>
@endsection