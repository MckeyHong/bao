@extends('web.layouts.app')


@section('css')
<style type="text/css">
.record-container {
    padding: 0 15px;
}

.search-btn {
    padding: 0;
}

hr {
    margin: 0.5rem 0;
}

.record-info-block {
    border: 1px solid #cccccc;
    border-radius: 5px;
    padding: 8px;
    margin: 5px 0;
}

.record-total {
    padding: 5px 0;
    color: #ffffff;
    border-radius: 5px;
    background: #DD2F2F;
}

.btn-quick {
    color: #495057;
    background: #e9ecef;
    border: 1px solid #ced4da;

}
</style>
@endsection

@section('content')
<div class="record-container">
    <div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">从</span>
            </div>
            <input type="text" class="form-control text-center" value="2019-01-06">
            <div class="input-group-append">
                <span class="input-group-text"><i data-eva="arrow-ios-downward-outline" width="12px" height="12px;"></i></span>
            </div>
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text">自</span>
            </div>
            <input type="text" class="form-control text-center" value="2019-01-06">
            <div class="input-group-append">
                <span class="input-group-text"><i data-eva="arrow-ios-downward-outline" width="12px" height="12px;"></i></span>
            </div>
        </div>
        <div class="row text-center" style="margin:0;">
            <div class="col search-btn"><button type="button" class="btn btn-quick">昨日</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick">今日</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick">上周</button></div>
            <div class="col search-btn"><button type="button" class="btn btn-quick">当周</button></div>
        </div>
        <hr>
    </div>
    <div>
        <div class="record-total text-center">
            总利息：$ <span class="font-weight-bolder">1.00</span>
        </div>
        <div>
            @for ($no = 1; $no <= 10; $no++)
            <div class="record-info-block bg-light">
                <div>
                    <div class="float-left">异动时间</div>
                    <div class="float-right">2019-01-06 11:10:00</div>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <div class="float-left">异动金额</div>
                    <div class="float-right text-success">$ 100.00</div>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <div class="float-left">余额宝钱包</div>
                    <div class="float-right">$ 1,101.00</div>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <div class="float-left">生成利息</div>
                    <div class="float-right">$ 1.00</div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <hr>
            @endfor
            <div class="record-info-block bg-light text-center">
                没有任何记录
            </div>
            <hr>
            <div>
                <button type="button" class="btn btn-block btn-submit" data-toggle="modal" data-target="#loadingModal">载入更多...</button>
            </div>
        </div>
    </div>
</div>
@endsection