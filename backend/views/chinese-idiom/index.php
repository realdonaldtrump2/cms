<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChineseIdiomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chinese Idioms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-idiom-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Chinese Idiom', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'word',
            'pinyin',
            'abbreviation',
            'derivation',
            //'explain',
            //'example',
            //'is_delete',
            //'create_datetime',
            //'update_datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
