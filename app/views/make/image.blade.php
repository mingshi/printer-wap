@extends('layouts.frame')

@section('content')
<img style="width: 100%; display:block;" id="template" src="{{ $data->image->source }}" />
<div id='editor'></div>
<div class="image-tools">
    <a href="javascript:;" class="file">
        <input type="file" name="" id="" />选择文件
    </a>
</div>
@stop

@section('js')
<script type="text/javascript" src="/js/alloyimage.js"></script>
<script type="text/javascript" src="/js/alloy.js"></script>
<script src="/js/hammer.min.js"></script>
<script src='/js/ImageEditor.js'></script>
<script type="text/javascript">
$(function() {
});
</script>
@stop
