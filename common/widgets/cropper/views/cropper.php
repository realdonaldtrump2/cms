<?php

use yii\helpers\Url;


$css = <<<CSS
    
    .clipContent {
        width: 140px;
        height: 32px;
        border-radius: 4px;
        background-color: #337AB7;
        color: #fff;
        font-size: 14px;
        text-align: center;
        line-height: 32px;
        outline: none;
        position: relative;
    }
    
    .clipBgn {
        width: 80%;
        margin: 30px auto;
        background-color: #fff;
        overflow: hidden;
        border-radius: 4px
    }
    
    .cover-wrap {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.4);
        z-index: 10000000;
        text-align: center
    }
    
    #clipFile {
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0
    }
    
    #clipView {
        width: 480px; 
        height: 270px; 
        background-color: rgb(102, 102, 102); 
        background-repeat: no-repeat; 
        background-position: center center; 
        background-size: contain;
    }

CSS;

$this->registerCss($css);

$uploadImageBase64Url = Url::toRoute('upload/image-base64');

$js = <<<JS

    var clipArea = new bjj.PhotoClip("#clipArea", {
        size: ['{$width}', '{$height}'], // 截取框的宽和高组成的数组。默认值为[260,260]
        outputSize: ['{$width}', '{$height}'], // 输出图像的宽和高组成的数组。默认值为[0,0]，表示输出图像原始大小
        //outputType: "jpg", // 指定输出图片的类型，可选 "jpg" 和 "png" 两种种类型，默认为 "jpg"
        file: "#clipFile", // 上传图片的<input type="file">控件的选择器或者DOM对象
        view: "#clipView", // 显示截取后图像的容器的选择器或者DOM对象
        ok: "#clipBtn", // 确认截图按钮的选择器或者DOM对象
        loadStart: function () {
            // 开始加载的回调函数。this指向 fileReader 对象，并将正在加载的 file 对象作为参数传入
            $('.cover-wrap').fadeIn();
            console.log("照片读取中");
        },
        loadComplete: function () {
            // 加载完成的回调函数。this指向图片对象，并将图片地址作为参数传入
            console.log("照片读取完成");
        },
        loadError: function (event) {
            // 加载失败的回调函数。this指向 fileReader 对象，并将错误事件的 event 对象作为参数传入
        },
        clipFinish: function (dataURL) {

            // 裁剪完成的回调函数。this指向图片对象，会将裁剪出的图像数据DataURL作为参数传入
            $('.cover-wrap').fadeOut();
            $('#clipView').css('background-size', '100% 100%');
            console.log(dataURL); //输出图像base64

            $.ajax({
                type: 'POST',
                url: '{$uploadImageBase64Url}',
                data: {file: dataURL},
                success: function (response) {
                    
                    if (response.error === 0) {
                        
                        $('#{$id}').val(response.data.url);
                        
                    } else {
                        
                        bootbox.alert({
                            size: 'middle',
                            title: '提示',
                            message: '上传失败'
                        });
                        
                    }
                    
                }
            });

        }
    });

JS;

$this->registerJs($js);

?>

<input type="text" class="form-control" id="<?= $id ?>" name="<?= $name ?>" value="<?= $value ?>" aria-required="true"
       readonly="readonly">

<div style="padding: 15px;">

    <div id="clipView"></div>
    <br>
    <div class="clipContent" style="">
        上传图片<input type="file" id="clipFile" accept="image/*">
    </div>

</div>

<div class="cover-wrap" style="display: none;">
    <div class="clipBgn">
        <div id="clipArea"
             style="margin: 10px; height: 520px; user-select: none; overflow: hidden; position: relative;">
            <div class="photo-clip-view"
                 style="position: absolute; left: 50%; top: 50%; width: 428px; height: 321px; margin-left: -214px; margin-top: -160px;">
                <div class="photo-clip-moveLayer"
                     style="transform-origin: 0px 0px; transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) scale(1) translateZ(0px);">
                    <div class="photo-clip-rotateLayer"></div>
                </div>
            </div>
            <div class="photo-clip-mask"
                 style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; pointer-events: none;">
                <div class="photo-clip-mask-left"
                     style="position: absolute; left: 0px; right: 50%; top: 50%; bottom: 50%; width: auto; height: 321px; margin-right: 214px; margin-top: -160px; margin-bottom: -160px; background-color: rgba(0, 0, 0, 0.5);"></div>
                <div class="photo-clip-mask-right"
                     style="position: absolute; left: 50%; right: 0px; top: 50%; bottom: 50%; margin-left: 214px; margin-top: -160px; margin-bottom: -160px; background-color: rgba(0, 0, 0, 0.5);"></div>
                <div class="photo-clip-mask-top"
                     style="position: absolute; left: 0px; right: 0px; top: 0px; bottom: 50%; margin-bottom: 160px; background-color: rgba(0, 0, 0, 0.5);"></div>
                <div class="photo-clip-mask-bottom"
                     style="position: absolute; left: 0px; right: 0px; top: 50%; bottom: 0px; margin-top: 160px; background-color: rgba(0, 0, 0, 0.5);"></div>
                <div class="photo-clip-area"
                     style="border: 1px dashed rgb(221, 221, 221); position: absolute; left: 50%; top: 50%; width: 428px; height: 321px; margin-left: -215px; margin-top: -161px;"></div>
            </div>
        </div>
        <br>
        <center>
            <a id="clipBtn" class="btn btn-primary">保存图片</a>
        </center>
        <br>
    </div>
</div>