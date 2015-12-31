@extends('layouts.frame')

@section('css')
<style>
img {
    display: block;
    width: 100%;
}
</style>
@stop

@section('content')
<img src="/images/start_bg.png" />
<a class="startBtn" href="{{ URL::route('makeClasses') }}" rel="external" data-ajax="false">开始制作</a>
@stop

@section('js')
<script type="text/javascript">
$(function() {
    var screenHeight = $(document).height();
    $('img').height(screenHeight);
    $('img').width(1280 / 2016 * screenHeight);
});
</script>
@stop
