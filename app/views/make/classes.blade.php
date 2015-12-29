@extends('layouts.frame')

@section('css')
<link rel="stylesheet" href="/css/swiper-3.2.7.min.css"/>
@stop

@section('content')
<div class="className">{{ @$lists[0]->name }}</div>
<nav id="nav" class="swiper-container gallery-thumbs">
    <ul id="tabs" class="swiper-wrapper nav-list clearfix">
        @foreach ($lists as $key => $t)
        <li class="swiper-slide" data="{{ $t->id }}" rel="{{ $key + 1 }}">
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
        slidesPerView: 1.5,
        centeredSlides: true,
        //touchRatio: 1,
        paginationClickable: true,
        pagination: '.pagination-div',
        watchActiveIndex: true
    });
</script>
@stop
