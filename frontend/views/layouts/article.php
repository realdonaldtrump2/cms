<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title><?= Yii::$app->params['applicationName'] ?></title>
    <?= Html::csrfMetaTags() ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no,email=no,address=no">
    <meta name="screen-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <meta name="x5-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="x5-page-mode" content="app">
    <meta name="author" content="<?= Yii::$app->params['applicationName'] ?>">
    <meta name="keywords" content="<?= Yii::$app->params['applicationName'] ?>">
    <meta name="description" content="<?= Yii::$app->params['applicationName'] ?>">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="bookmark" href="/favicon.ico">
    <link rel="stylesheet" href="/vendor/article/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/vendor/article/ionicons/ionicons.css">
    <link rel="stylesheet" href="/vendor/article/pace/pace.css">
    <link rel="stylesheet" href="/vendor/article/common/common.css">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<script src="/vendor/article/jquery/jquery.js"></script>
<script src="/vendor/article/bootstrap/bootstrap.js"></script>
<script src="/vendor/article/pace/pace.js"></script>
<script src="/vendor/article/modernizr/modernizr.js"></script>
<script src="/vendor/article/common/common.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
