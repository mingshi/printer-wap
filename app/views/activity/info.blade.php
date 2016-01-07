@extends('layouts.frame')

@section('css')
<style>
.ui-overlay-a, .ui-page-theme-a, .ui-page-theme-a .ui-panel-wrapper {background-color:#fff !important;}
</style>
@stop

@section('content')
<div class="about-us">
    <span class="title">{{ @$data->subject }}</span>
    <span class="date">{{ @date('Y-m-d', strtotime($data->start_time)) }}</span>
    {{ @$data->content }}
</div>
@stop

@section('js')
@stop
