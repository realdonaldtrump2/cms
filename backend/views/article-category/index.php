<?php

use kartik\tree\TreeView;
use common\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章分类';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="alert alert-success" role="alert">
    最多只能有两级分类
</div>

<?= TreeView::widget([
    'id' => 'shop-goods-category',
    'query' => ArticleCategory::find()->addOrderBy('root'),
    'treeOptions' => ['style' => 'min-height:400px;height:auto;'],
    'detailOptions' => ['style' => 'height:300px;'],
    'headingOptions' => ['label' => '文章分类'],
    'rootOptions' => ['label' => '<span class="text-primary">文章分类</span>'],
    'isAdmin' => false,
    'displayValue' => 1,
]) ?>
