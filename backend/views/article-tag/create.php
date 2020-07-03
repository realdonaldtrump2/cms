<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTag */

$this->title = '文章标签创建';
$this->params['breadcrumbs'][] = ['label' => '文章标签列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
