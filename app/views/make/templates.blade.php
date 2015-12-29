@extends('layouts.frame')

@section('content')
<ul class="templates-lists">
    @if (!empty($sources->result))
    @foreach (@$sources->result as $k => $s)
       <li class="{{{ $k % 2 == 0 ? 'left-image' : '' }}}"><img src="{{ $s }}"></li>
    @endforeach
    @endif
</ul>

<nav id="nav" class="swiper-container gallery-thumbs template-tab">
    <ul id="tabs" class="swiper-wrapper nav-list clearfix">
        @if (!empty($lists->result))
        @foreach (@$lists->result as $key => $t)
        <li class="swiper-slide" data="{{ $t->id }}" rel="{{ $key + 1 }}">{{ $t->name }}</li>
        @endforeach
        @endif
    </ul>
</nav>
@stop

@section('js')
<script src="/js/swiper-3.2.7.min.js"></script>
<script type="text/javascript">
var galleryThumbs = new Swiper('.gallery-thumbs', {
    slidesPerView: 4.5,
    centeredSlides: false,
    touchRatio: 1,
});
$(function() {
    var width = $('body').width();
    var liWidth = (width - 20 * 2 - 10) / 2;
    $("ul.templates-lists li").width(liWidth);
});
</script>
@stop
