<?php

return [

    // +----------------------------------------------------------------------
    // | 邮箱相关设置
    // +----------------------------------------------------------------------

    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    // +----------------------------------------------------------------------
    // | 项目设置
    // +----------------------------------------------------------------------

    // 项目名称
    'applicationName' => '内容管理系统',
    // 默认商品分类图片
    'shopGoodsCategoryDefaultIcon' => 'https://jianhe-oss.oss-cn-beijing.aliyuncs.com/shop-goods-category/default_goods_category.png',
    // 默认头像
    'defaultAvatar' => 'https://jianhe-oss.oss-cn-beijing.aliyuncs.com/function/default_avatar.png',

    // +----------------------------------------------------------------------
    // | 上传文件相关设置
    // +----------------------------------------------------------------------

    // 图片服务器的域名设置，拼接保存在数据库中的相对地址，可通过web进行展示
    'webuploader' => [
        // 后端处理图片的地址，value 是相对的地址
        'uploadUrl' => 'upload/webuploader-image-file',
        // 多文件分隔符
        'delimiter' => ',',
        // 基本配置
        'baseConfig' => [
            'defaultImage' => 'https://jianhe-oss.oss-cn-beijing.aliyuncs.com/function/default_avatar.png',
            'disableGlobalDnd' => true,
            'accept' => [
                'title' => 'Images',
                'extensions' => 'jpeg,jpg,gif,bmp,png',
                'mimeTypes' => 'image/*',
            ],
            'pick' => [
                'multiple' => false,
            ],
        ],
    ],
    // 访问图片的域名拼接
    'domain' => 'http://www.example.com',
    // 图片默认上传的目录
    'imageUploadRelativePath' => './uploads/images/',
    // 图片上传成功后，路径前缀
    'imageUploadSuccessPath' => '/uploads/images/',

    // +----------------------------------------------------------------------
    // | 后台级别相关设置
    // +----------------------------------------------------------------------

    'backendLevel' => [
        'admin' => '超级管理员',
    ],

    // +----------------------------------------------------------------------
    // | 分页相关设置
    // +----------------------------------------------------------------------

    'perPage' => 20,

];
