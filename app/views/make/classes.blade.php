@extends('layouts.frame')

@section('css')
<link rel="stylesheet" href="/css/swiper.css"/>
@stop

@section('content')
<div class="className">{{ @$lists[0]->name }}</div>
<nav id="nav" class="swiper-container gallery-thumbs">
    <ul id="tabs" class="swiper-wrapper nav-list clearfix">
        @foreach ($lists as $key => $t)
        <li class="swiper-slide" data="{{ $t->id }}" rel="{{ $key + 1 }}">
            <img src="{{ $t->front }}" />
        </li>
        @endforeach
    </ul>
</nav>

<div class="pagination-div">
    <ul class="pagination">
        @foreach ($lists as $k => $l)
        <li {{{ $k == 0 ? 'class=active' : '' }}}></li>
        @endforeach
    </ul>
</div>
@stop

@section('js')
<script src="/js/swiper.js"></script>
<script type="text/javascript">
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        slidesPerView: 2,
        centeredSlides: false,
        touchRatio: 1,
    });
</script>
@stop
