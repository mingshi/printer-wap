@extends('layouts.frame')

@section('css')
<style>
.ui-overlay-a, .ui-page-theme-a, .ui-page-theme-a .ui-panel-wrapper {background-color:#fff !important;}
</style>
@stop

@section('content')
@if (isset($lists['active']))
@foreach($lists['active'] as $a)
<div class="about-us" data="{{ $a->id }}">
    <span class="title">{{ $a->subject }}</span>
    <span class="date">{{ date('Y-m-d', strtotime($a->start_time)) }}</span>
    <img src="{{ $a->list_image }}" style="margin-top: 25px;" />
    <p>这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容...</p>
    <div class="more">查看详情></div>
</div>
<div style="margin-top: 10px"></div>
@endforeach
@endif
<div style="margin-top: 15px"></div>
<img src="/img/history.png" style="width: 110px;" />
@if(isset($lists['stop']))
@foreach($lists['stop'] as $a)
<div class="about-us" data="{{ $a->id }}">
    <span class="title">{{ $a->subject }}</span>
    <span class="date">{{ date('Y-m-d', strtotime($a->start_time)) }}</span>
    <img src="{{ $a->list_image }}" style="margin-top: 25px;" />
    <p>这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容...</p>
    <div class="more">查看详情></div>
</div>
<div style="margin-top: 10px"></div>
@endforeach
@endif
@stop

@section('js')
<script type="text/javascript">
$(function() {
    $('div.about-us').each(function() {
        $(this).click(function() {
            var id = $(this).attr('data');
            window.location.href = "{{ URL::route('activityInfo') }}" + '?id=' + id;
        });
    });
});
</script>
@stop
