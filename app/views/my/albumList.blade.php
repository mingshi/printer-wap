@extends('layouts.frame')

@section('css')
@stop

@section('content')
<ul class="templates-lists">
    @foreach ($lists as $key => $t)
        <li class="{{{ $key % 2 == 0 ? 'left-image' : '' }}}"  data="{{ $t->id }}" rel="{{ $key + 1 }}">
            <a href="{{ URL::route('myAlbumInfo', ['id' => $t->id]) }}" rel="external" data-ajax="false"><img src="{{ $t->source }}"></a>
        </li>
    @endforeach
</ul>

@stop

@section('js')
<script type="text/javascript">
$(function() {
    $("ul.templates-lists li").width(get_width());
});

function get_width()
{
    var width = $('body').width();
    var liWidth = (width - 20 * 2 - 10) / 2;
    return liWidth;
}
</script>
@stop
