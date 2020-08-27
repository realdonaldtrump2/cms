<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActressWork */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Adult Video Actress Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="adult-video-actress-work-view">

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
            'adult_video_actress_id',
            'title',
            'cover:ntext',
            'cover_url:url',
            'designation',
            'information',
            'publish_datetime',
            'duration',
            'is_delete',
            'create_datetime',
            'update_datetime',
        ],
    ]) ?>

</div>
