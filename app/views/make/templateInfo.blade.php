@extends('layouts.frame')

@section('content')
<ul class="templates-lists">
    @if (!empty($lists))
    @foreach ($lists as $k => $s)
        <li class="{{{ $k % 2 == 0 ? 'left-image' : '' }}}" data="{{ $s->id }}">
            <a href="{{ URL::route('makeImage', ['id' => $s->id]) }}" rel="external" data-ajax="false"><img src="{{ $s->source }}"></a>
        </li>
    @endforeach
    @endif
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
