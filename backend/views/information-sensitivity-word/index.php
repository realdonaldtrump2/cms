<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InformationSensitivityWordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Information Sensitivity Words';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="information-sensitivity-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Information Sensitivity Word', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category',
            'word',
            'is_delete',
            'create_datetime',
            //'update_datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
