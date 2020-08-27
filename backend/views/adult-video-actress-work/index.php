<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdultVideoActressWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adult Video Actress Works';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adult-video-actress-work-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Adult Video Actress Work', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'adult_video_actress_id',
            'title',
            'cover:ntext',
            'cover_url:url',
            //'designation',
            //'information',
            //'publish_datetime',
            //'duration',
            //'is_delete',
            //'create_datetime',
            //'update_datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
