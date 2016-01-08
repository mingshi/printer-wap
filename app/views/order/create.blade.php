@extends('layouts.frame')

@section('content')
<input type="hidden" name="album_id" value="{{ $album_id }}" />
@if (!empty($user->real_name))
<input type="text" readonly name="real_name" class="order-input" placeholder="请填写姓名" data-role="none" value="{{ @$user->real_name }}" />
@else 
<input type="text" name="real_name" class="order-input" placeholder="请填写姓名" data-role="none" value="{{ @$user->real_name }}" />
@endif
@if (!empty($user->mobile))
<input type="tel" readonly name="mobile" class="order-input" placeholder="请填写联系电话" data-role="none" value="{{ $user->mobile }}" />
@else
<input type="tel" name="mobile" class="order-input" placeholder="请填写联系电话" data-role="none" value="" />
@endif
@if (!empty($user->address))
<input type="text" readonly name="address" class="order-input" placeholder="请填写详细地址" data-role="none" value="{{ @$user->address }}" />
@else
<input type="text" name="address" class="order-input" placeholder="请填写详细地址" data-role="none" value="{{ @$user->address }}" />
@endif
<label class="input-label" data-role="none">购买份数:</label><input style="float:left; width: 67%;" type="tel" name="quantity" class="order-input"  data-role="none" value="1" />

<div class="image-tools">
    <a id="submit-order">确认下单</a>
</div>
@stop

@section('js')
<script type="text/javascript">
$(function() {
    $('#submit-order').click(function() {
        var real_name = $("input[name='real_name']").val();
        var mobile = $("input[name='mobile']").val();
        var address = $("input[name='address']").val();
        var quantity = $("input[name='quantity']").val();
        var album_id = $("input[name='album_id']").val();

        $.ajax({
            url: "{{ URL::route('ajaxCreateOrder') }}",
            type: 'POST',
            dataType: 'json',
            data: {'album_id': album_id, 'real_name': real_name, 'mobile': mobile, 'address': address, 'quantity': quantity}
        }).done(function(result){
            if (result.status == 'success') {
                show_alert('创建成功');
                window.location.href = "{{ URL::route('orderList') }}/";
            } else {
                show_alert(result.msg);
                return false;
            }
        });
    });
});
</script>
@stop
