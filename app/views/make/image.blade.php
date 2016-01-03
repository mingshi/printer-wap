@extends('layouts.frame')

@section('content')
<img style="width: 100%; display:block;" id="template" src="{{ $data->image->source }}" />
<div id='editor'></div>
<div class="image-tools">
    <a href="javascript:;" class="file">
        <input type="file" name="" id="upfile" />选择文件
    </a>
    <a href="javascript:;" class="file next">
        <span>下一步</span>    
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
    var editor = null;
    var width = $('body').width();
    var img1  = new Image();
    var url = "{{ $data->image->source }}"; 
    img1.src = url;
    var height = img1.height / img1.width * width;
    $('#upfile').change(function(e){
        var path = e.target.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(path);
        reader.onload = function() {
            var res = this.result;
            $('#template').hide();
            var images = [];
            if (editor == null) {
                images = [
                    {'url':res, 'clickToSelect': true},
                    {'url':url, 'clickToSelect': false},
                ];
            } else {
                var images = editor.images;
                images.unshift({'url':res, 'clickToSelect': true});
            }
            editor = $('#editor').ImageEditor({
                imageUrls: images,
                width: width,
                height: height,
                removeIcon: null,

                onInitCompleted: function() {
                    editor.selectImage(0); // 初始化完成后，默认选中第一个图片（头像图片）作为当前编辑图片
                }
            });
            $('#index').val(0);
        } 
    });
});
</script>
@stop
