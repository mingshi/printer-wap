@extends('layouts.frame')

@section('content')
<table class="order-list">
@foreach ($data as $d)
<tbody>
    <tr>
        <td>订单编号：</td>
        <td>{{ $d->id }}</td>
    </tr>
    <tr>
        <td>下单时间：</td>
        <td>{{ $d->created_at }}</td>
    </tr>
    <tr>
        <td>相册风格：</td>
        <td>{{ $d->name }}</td>
    </tr>
    <tr>
        <td>数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;量：</td>
        <td>{{ $d->quantity }}册</td>
    </tr>
    <tr>
        <td>总&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价：</td>
        <td>{{ $d->total_amount }}元</td>
    </tr>
    <tr>
        <td>顾客姓名：</td>
        <td>{{ $d->real_name }}</td>
    </tr>
    <tr>
        <td>顾客电话：</td>
        <td>{{ $d->mobile }}</td>
    </tr>
    <tr>
        <td>邮寄地址：</td>
        <td>{{ $d->address }}</td>
    </tr>
    <tr>
        <td>订单状态：</td>
        <td>{{ $d->status }}</td>
    </tr>
    <tr>
        <td>支付状态：</td>
        <td>@if ($d->pay_status == 1){{ $d->pay_status_info }}@else<a class="payBtn" data="{{ $d->id }}">立即支付</a> @endif</td>
    </tr>
</tbody>
@endforeach
</table>
@stop

@section('js')
<script type="text/javascript">
$(function(){
    $('a.payBtn').each(function() {
        $(this).click(function() {
            var id = $(this).attr('data');
            $.ajax({ 
                url: "{{ URL::route('ajaxCreatePay') }}",
                type: 'POST',
                dataType: 'json',
                data: {'id': id}
            }).done(function(result){
                if (result.status == 'success') {
    				callpay(result.result);           
                } else {
                    show_alert(result.msg);
                    return false;
                } 
            });
        });
    });

	function jsApiCall(data)
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            data,
			function(res){
                WeixinJSBridge.log(res.err_msg);
                alert(res.err_code+res.err_desc+res.err_msg);
            }
        );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall(data);
        }
    }
});
</script>
@stop
