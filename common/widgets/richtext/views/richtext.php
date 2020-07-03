<?php

use yii\helpers\Url;

$css = <<<CSS

CSS;

$this->registerCss($css);

$uploadImageFileUrl = Url::toRoute('upload/image-file');

if ($scenario === 'computer') {

$js = <<<JS

    $('#{$id}').summernote({
        height: 500,
        minHeight: null,             
        maxHeight: null, 
        lang:'zh-CN',
        callbacks: {
            onImageUpload: function(files) {
                
                if (!checkIsMatch(files[0].name,'image')){
                    bootbox.alert({
                        size:'middle',
                        title:'提示',
                        message:'请上传正确格式的图片'
                    });
                    return false;
                }
                
                var data = new FormData();
                data.append('file', files[0]);
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: '{$uploadImageFileUrl}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.error === 0) {
                            $('#{$id}').summernote('insertImage', res.data.url, 'image'); // the insertImage API
                        }else{
                            bootbox.alert({
                                size:'middle',
                                title:'提示',
                                message:'上传失败'
                            });
                        }
                    }
                });
                
            }
        }  
    });   

JS;

} else {

$js = <<<JS

    $('#{$id}').summernote({
        height: 667,
        width: 375, 
        minHeight: null,             
        maxHeight: null, 
        lang:'zh-CN',
        callbacks: {
            onImageUpload: function(files) {
                
                if (!checkIsMatch(files[0].name,'image')){
                    bootbox.alert({
                        size:'middle',
                        title:'提示',
                        message:'请上传正确格式的图片'
                    });
                    return false;
                }
                
                var data = new FormData();
                data.append('file', files[0]);
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: '{$uploadImageFileUrl}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.error === 0) {
                            $('#{$id}').summernote('insertImage', res.data.url, 'image'); // the insertImage API
                        }else{
                            bootbox.alert({
                                size:'middle',
                                title:'提示',
                                message:'上传失败'
                            });
                        }
                    }
                });
                
            }
        }  
    });

JS;

}

$this->registerJs($js);

?>

<textarea class="form-control" name="<?= $name ?>" id="<?= $id ?>" rows="3"><?= $value ?></textarea>
