<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистиcтический отчёт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'q_taken',
                'value' => function($model) {
                    return $model->q_taken == null ? 0 : $model->q_taken;
                }
            ],
            [
                'attribute' => 'q_bought',
                'value' => function($model) {
                    return $model->q_bought == null ? 0 : $model->q_bought;
                }
            ],
            [
                'attribute' => 'q_viewed',
                'value' => function($model) {
                    return $model->q_viewed == null ? 0 : $model->q_viewed;
                }
            ],
        ],
    ]); ?>
</div>
