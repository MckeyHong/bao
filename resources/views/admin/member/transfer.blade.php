@extends('layouts.app')

@section('content')

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('css/vendor/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('js')
<script type="text/javascript" src="{{ asset('js/vendor/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/bootstrap-datetimepicker.zh-CN.js') }}"></script>
<script>
// $(function() {
//     $('#mydate').datetimepicker({
//         language: 'zh-CN',//顯示中文
//         format: 'yyyy-mm-dd HH:ii:ss',//顯示格式
//         // minView: "month",//設定只顯示到月份
//         // initialDate: new Date(),//初始化當前日期
//         autoclose: true //選中自動關閉
//         // todayBtn: true//顯示今日按鈕
//     });
// });
</script>
@endpush