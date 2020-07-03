<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use oonne\scrollTop\ScrollTop;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title><?= $this->title ?></title>
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
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="bookmark" href="/favicon.ico">
    <?php $this->head() ?>
</head>
<body class="nav-md">
<?php $this->beginBody() ?>
<div class="container body">
    <div class="main_container" >

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <?php if (Yii::$app->params['devicedetect']['isDesktop']): ?>
                    <div class="navbar nav_title">
                        <a class="site_title" style="font-size:20px;"><?= Yii::$app->params['applicationName'] ?></a>
                    </div>
                    <div class="clearfix"></div>
                <?php else: ?>
                <?php endif; ?>

                <!-- sidebar menu -->
                <?php echo $this->render('@app/views/part/menu.php', []); ?>
                <!-- /sidebar menu -->

                <!-- menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->

            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="user-profile dropdown-toggle cursorPointer" data-toggle="dropdown"
                               aria-expanded="false">
                                <span><i class="fa fa-user"></i> <?= Yii::$app->user->identity ? Yii::$app->user->identity->phone : '' ?></span>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a class="a-pointer" id="modifyInfoButton">
                                        <i class="fa fa-cog pull-right"></i> 修改密码
                                    </a>
                                </li>
                                <li>
                                    <a class="a-pointer" id="logoutFormButton">
                                        <?= Html::beginForm(['site/logout'], 'post', ['id' => 'logoutForm', 'hidden' => 'hidden']) . Html::endForm() ?>
                                        <i class="fa fa-sign-out pull-right"></i> 退出登录
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" >

            <!-- 面包屑-->
            <div class="page-title">
                <div class="title_left">
                    <h4>
                        <?= Breadcrumbs::widget([
                            'homeLink' => ['label' => '首页', 'url' => ['site/index']],
                            'itemTemplate' => "<li>{link}</li>\n",
                            'links' => $this->params['breadcrumbs'],
                            'options' => [
                                'class' => 'breadcrumb',
                                'style' => 'background-color: #F7F7F7;'
                            ]
                        ]) ?>
                    </h4>
                </div>
            </div>
            <!-- /面包屑-->

            <!--页面内容-->
            <div class="x_panel main-container-body">
                <div class="x_content">
                    <?= $content ?>
                </div>
            </div>
            <!--/页面内容-->

            <div class="modal fade bs-example-modal-lg" id="commonModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /page content -->

        <!-- totop content -->
        <?= ScrollTop::widget([
            'tagContent' => '<i class="fa fa-chevron-up"></i>',
        ]) ?>
        <!-- /totop content -->

        <!-- footer content -->
        <footer>
            <div class="pull-left">
                <span>管理后台</span>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

    </div>
</div>

<?php $this->endBody() ?>
<script>

$(document).ready(function () {

    $(document).on('click', '#modifyInfoButton', function () {
        $.get("<?= Url::to(['site/modify-info']) ?>", {}, function (html) {
            $('#commonModal .modal-body').html(html);
            $('#commonModal').modal('show');
        });
    });

});

</script>
</body>
</html>
<?php $this->endPage() ?>
