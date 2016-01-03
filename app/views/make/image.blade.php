@extends('layouts.frame')

@section('content')
<img style="display:block;" id="template" src="{{ $data->image->source }}" />
<div id='editor'></div>
<input type="file" id="upfile" />
@stop

@section('js')
<script type="text/javascript" src="/js/alloyimage.js"></script>
<script type="text/javascript" src="/js/alloy.js"></script>
<script src="/js/hammer.min.js"></script>
<script src='/js/ImageEditor.js'></script>
<script type="text/javascript">
$(function() {
    var screenHeight = $(document).height();
    $('img#template').height(screenHeight - 70);
});
</script>
@stop
