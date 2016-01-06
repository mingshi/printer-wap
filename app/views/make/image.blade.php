@extends('layouts.frame')

@section('content')
<img style="width: 100%; display:block;" id="template" src="{{ $data->image->source }}" />
<input type="hidden" name="image_id" value="{{ $data->image->id }}" />
<input type="hidden" name="template_id" value="{{ $data->template->id }}" />
<input type="hidden" name="class_id" value="{{ $data->class->id }}" />
<div id='editor'></div>
<div class="image-tools" id="image-tools">
    <a href="javascript:;" class="file">
        <input type="file" name="" id="upfile" />选择文件
    </a>
    <ul class="image-ul">
    </ul>
    <a href="javascript:;" class="file next" id="next">
        <span>下一步</span>    
    </a>
</div>

<div class="image-tools" id="filter" style="display: none;">
    <a href="javascript:;" class="file previous" id="previous">
        <span>上一步</span>
    </a>
    <div id="swiper">
        <ul class="filter-ul ">
            <li class="filterBtn"><img src="/img/e1.jpg" />原图</li>
            <li class="filterBtn"><img src="/img/e1.png" />美肤</li>
            <li class="filterBtn"><img src="/img/e2.png" />素描</li>
            <li class="filterBtn"><img src="/img/e3.png" />自然增强</li>
            <li class="filterBtn"><img src="/img/e4.png" />紫调</li>
            <li class="filterBtn"><img src="/img/e5.png" />柔焦</li>
            <li class="filterBtn"><img src="/img/e6.png" />复古</li>
            <li class="filterBtn"><img src="/img/e7.png" />黑白</li>
            <li class="filterBtn"><img src="/img/e8.png" />lomo</li>
            <li class="filterBtn"><img src="/img/e9.png" />亮白增强</li>
            <li class="filterBtn"><img src="/img/e10.png" />灰白</li>
            <li class="filterBtn"><img src="/img/e11.png" />灰色</li>
            <li class="filterBtn"><img src="/img/e12.png" />暖秋</li>
            <li class="filterBtn"><img src="/img/e13.png" />木雕</li>
            <li class="filterBtn"><img src="/img/e14.png" />粗糙</li>
        </ul>
    </div> 
    <a href="javascript:;" class="file save" id="save">
        <span>保存</span>    
    </a>
</div>
@stop

@section('js')
<script src="/js/swiper-3.2.7.min.js"></script>
<script type="text/javascript" src="/js/a1.js"></script>
<script type="text/javascript" src="/js/a.js"></script>
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
            $('#template').attr('src', '');
            $('#template').hide();
            var images = [];
            if (editor == null) {
                images = [{'url':res, 'clickToSelect': true},{'url':url, 'clickToSelect': false}];
                editor = $('#editor').ImageEditor({
                    imageUrls: images,
                    width: width,
                    height: height,
                    removeIcon: null,

                    onInitCompleted: function() {
                        editor.selectImage(0);
                    }
                });
            } else {
                //var images = editor.images;
                //images.unshift({'url':res, 'clickToSelect': true});
                editor.unshiftImage(res, true);
            }
            var html = '<li><img id="thumb" style="position: relative; width:60px; height: 60px;" src="' + res + '" /><img src="/img/delete.png" style="position: absolute; margin-left:-15px; margin-top:-7px; width: 30px;" id="delete" /></li>';
            $('ul.image-ul').append(html);
            set_id();
            each_del();
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
        //each_del();
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
                set_id();
                return false;
            });
        });
    }

    var screenWidth = $('body').width();
    var ulWidth = parseFloat(screenWidth) - 66 - 10 - 48;
    $('ul.image-ul').width(ulWidth);
    $('div#swiper').width(ulWidth);
    $('ul.filter-ul').width(1080);

    $('#next').click(function(){
        if (editor == null || editor.images.length < 2) {
            alert('你还没有编辑任何图片');
            return false;
        }
        var cvs = editor.mergeImage();
        $('#editor').hide();
        $('#image-tools').hide();
        $('#filter').show();

        $('#template').attr('src', cvs.toDataURL());
        $('#template').show();
        Main.init();
    });

    $('#previous').click(function() {
        $('#mergeImage').hide();
        $('#filter').hide();
        $('#template').attr('src', '');
        $('#template').hide();

        $('#image-tools').show();
        $('#editor').show();
    });

    $('#save').click(function(){
        var image_id = $("input[name='image_id']").val();
        var template_id = $("input[name='template_id']").val();
        var class_id = $("input[name='class_id']").val();
        var image_data = $('#template').attr('src'); 

        show_loading();
        $.ajax({
            url:"{{ URL::route('saveImage') }}",
            type: 'POST',
            dataType: 'json',
            data: {'image_id': image_id, 'template_id': template_id, 'class_id': class_id, 'image_data': image_data}
        }).done(function(result){
            hide_loading();
            if (result.status == 'success') {
                show_alert('保存成功');
            } else {
                alert(result.msg);
                return false;
            }
        });    
    });
});
</script>
@stop
