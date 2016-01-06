@extends('layouts.frame')

@section('css')
<link rel="stylesheet" href="/css/swiper-3.2.7.min.css"/>
@stop

@section('content')
<nav id="nav" class="swiper-container gallery-thumbs">
    <ul id="tabs" class="swiper-wrapper nav-list clearfix">
        @foreach ($lists as $key => $t)
        <li class="swiper-slide" data="{{ $t->id }}" rel="{{ $key + 1 }}">
            <div class="className">{{ $t->name }}</div>
            <a href="{{ URL::route('makeTemplates', ['id' => $t->id]) }}" rel="external" data-ajax="false"><img src="{{ $t->front }}" /></a>
        </li>
        @endforeach
    </ul>
</nav>

<div class="pagination-div">
    <ul class="pagination">
</div>
@stop

@section('js')
<script src="/js/swiper-3.2.7.min.js"></script>
<script type="text/javascript">
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        slidesPerView: 2.2,
        centeredSlides: false,
        //touchRatio: 1,
        paginationClickable: true,
        pagination: '.pagination-div',
        watchActiveIndex: true
    });
</script>
@stop
