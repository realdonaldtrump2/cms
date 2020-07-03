<?php


use yii\helpers\Url;
use common\models\Menu;

$menuModel = new Menu();
$treeLevelList = $menuModel->treeLevel();

?>

<div class="profile clearfix">
    <div class="profile_pic">
        <img src="<?= Yii::$app->params['defaultAvatar'] ?>" class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>欢迎,</span>
        <h2><?= Yii::$app->user->identity ? Yii::$app->user->identity->phone : '' ?></h2>
    </div>
</div>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">

            <?php foreach ($treeLevelList as $treeLevel) { ?>
                <li>
                    <a>
                        <i class="<?= $treeLevel['icon'] ?>"></i>
                        <?= $treeLevel['title'] ?>
                        <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                        <?php foreach ($treeLevel['data'] as $key => $data) { ?>
                            <li>
                                <a href="<?= Url::to([$data['controller'] . '/' . $data['action']]); ?>"><?= $data['title'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if (Yii::$app->user->identity && Yii::$app->user->identity->checkIsAdmin()): ?>
                <li>
                    <a>
                        <i class="fa fa-bug"></i>
                        开发者选项<span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                        <li>
                            <a href="<?= Url::to(['develop/icon']) ?>">图标</a>
                        </li>
                        <li>
                            <a target="_blank" href="<?= Url::to(['develop/phpinfo']) ?>">phpinfo</a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
            <?php endif; ?>

        </ul>
    </div>
</div>
