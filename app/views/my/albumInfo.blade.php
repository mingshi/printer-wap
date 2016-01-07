@extends('layouts.frame')

@section('css')
@stop

@section('content')
<ul class="templates-lists album-info">
    @if (!empty($data->images))
    @foreach ($data->images as $key => $t)
        <li is_selected="0" class="{{{ $key % 2 == 0 ? 'left-image' : '' }}}"  data="{{ $t->id }}" rel="{{ $key + 1 }}">
            <img src="{{ $t->source }}" />
            <img src="/img/no-selected.png" id="select" data="{{ $t->id }}" />
        </li>
    @endforeach
    @endif
</ul>

<div class="image-tools">
    <a class="album-info-btn left" id="del">删除</a>
    <a href="{{ URL::route('orderCreate', ['album_id' => $data->album->id]) }}" rel="external" data-ajax="false" class="album-info-btn" id="order">下单</a>
    <a class="album-info-btn right" id="addImage">加图</a>
</div>
@stop

@section('js')
<script type="text/javascript">
$(function() {
    $("ul.templates-lists li").width(get_width());
    
    $('ul.templates-lists li').each(function() {
        $(this).click(function() {
            var select = $(this).attr('is_selected');
            if (select == 0) {
                $(this).children('img#select').attr('src', '/img/selected.png');
                $(this).attr('is_selected', 1);
            }

            if (select == 1) {
                $(this).children('img#select').attr('src', '/img/no-selected.png');
                $(this).attr('is_selected', 0);
            }
        });
    });

    $('#addImage').click(function() {
        if ({{ $data->can_add }} == 0) {
            alert('相册图片数量已满');
            return false;
        } else {
            window.location.href = "{{ URL::route('templateInfo', ['id' => $data->album->template_id, 'album_id' => $data->album->id]) }}";
        }
    });
    $('#del').click(function() {
        var del_ids = '';
        $("ul.templates-lists li[is_selected=1]").each(function(){
            del_ids += ',' + $(this).attr('data');
        });

        if (del_ids == '') {
            alert('你还未选择任何图片');
            return false;
        }

        if (!confirm('你确定要删除这些图片?')) {
            return false;
        } else {
            $.ajax({
                url: "{{ URL::route('delImage') }}",
                type: 'POST',
                dataType: 'json',
                data: {'ids': del_ids}
            }).done(function(result){
                if (result.status == 'success') {
                    show_alert('删除成功');
                    window.location.reload();
                } else {
                    show_alert(result.msg);
                }
            });
        }
    });
});

function get_width()
{
    var width = $('body').width();
    var liWidth = (width - 20 * 2 - 10) / 2;
    return liWidth;
}
</script>
@stop
