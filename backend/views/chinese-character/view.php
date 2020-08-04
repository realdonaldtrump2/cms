<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseCharacter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chinese Characters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="chinese-character-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'word',
            'oldword',
            'strokes',
            'pinyin',
            'radicals',
            'explain',
            'more_explain',
            'is_delete',
            'create_datetime',
            'update_datetime',
        ],
    ]) ?>

</div>
