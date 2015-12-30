@extends('layouts.frame')

@section('content')
<ul class="templates-lists">
    @if (!empty($sources->result))
    @foreach (@$sources->result as $k => $s)
       <li class="{{{ $k % 2 == 0 ? 'left-image' : '' }}}" data="{{ $s->id }}"><img src="{{ $s->source }}"></li>
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
    onTap: function(swiper) {
        var index = swiper.clickedIndex;
        var template_id = $('ul#tabs li').eq(index).attr('data');
        $.ajax({
            url: "{{ URL::route('getImages') }}",
            type: 'POST',
            data: {'template_id': template_id}
        }).done(function(result){
            var data = eval("(" + result + ")");
            if (data.status == 'success') {
                var html = '';
                $.each(data.result, function(index, item) {
                    var remainder = eval(index % 2);
                    if (remainder == 0) {
                        html += '<li data="' + item.id + '" class="left-image" style="width:' + get_width() + 'px"><img src="' + item.source + '" /></li>';
                    } else {
                        html += '<li data="' + item.id + '" style="width:' + get_width() + 'px"><img src="' + item.source + '" /></li>';
                    }
                });
                $('ul.templates-lists').html(html);
                each_click();
            } else {
                show_alert(data.msg);
            }
        });
    }
});
$(function() {
    $("ul.templates-lists li").width(get_width());
});

function each_click()
{
    $('ul.templates-lists li').each(function() {
        $(this).click(function(){
            window.location.href = "{{ URL::route('makeImage') }}" + '?id=' + $(this).attr('data');
        });
    });
}

each_click();

function get_width()
{
    var width = $('body').width();
    var liWidth = (width - 20 * 2 - 10) / 2;
    return liWidth;
}

</script>
@stop
