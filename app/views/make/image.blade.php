@extends('layouts.frame')

@section('content')
<img style="width: 100%; display:block;" id="template" src="{{ $data->image->source }}" />
<div id='editor'></div>
<div class="image-tools">
    <a href="javascript:;" class="file">
        <input type="file" name="" id="upfile" />选择文件
    </a>
    <ul class="image-ul">
    </ul>
    <a href="javascript:;" class="file next">
        <span>下一步</span>    
    </a>
</div>
@stop

@section('js')
<!--
<script type="text/javascript" src="/js/alloyimage.js"></script>
<script type="text/javascript" src="/js/alloy.js"></script>
-->
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
            var html = '<li><img id="thumb" style="position: relative; width:60px; height: 60px;" src="' + res + '" /><img src="/images/delete.png" style="position: absolute; margin-left:-15px; margin-top:-7px; width: 30px;" id="delete" /></li>';
            $('ul.image-ul').append(html);
            set_id();
        }
    });

    function set_id()
    {
        var len = editor.images.length;
        var liLen = $('ul.image-ul li').length;
        var start = parseInt(len) - 2;
        for (var i=0; i < liLen; i++) {
            $('ul.image-ul').children().eq(i).attr('id', start);
            start--;
        }
        set_active(0);
        each_click();
        each_del();
        return false;
    }

    function set_active(id)
    {
        $('ul.image-ul li').each(function(){
            $(this).removeClass('active');
        });
    
        $('ul.image-ul').children("li[id='"+ id + "']").addClass('active');
    }

    function each_click()
    {
        $('img#thumb').each(function() {
            $(this).click(function() {
                var id = $(this).parent().attr('id');
                editor.selectImage(id);
                set_active(id);
                return false;
            });
        });
    }

    function each_del()
    {
        $('img#delete').each(function() {
            $(this).unbind('click');
            $(this).click(function() {
                var id = $(this).parent().attr('id');
                editor.removeImage(id);
                $(this).parent().remove();
                return false;
            });
        });
    }
});
</script>
@stop
