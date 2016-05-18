<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TakenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Возврат фильма';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taken-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'user_id',
                'label' => 'Пользователь',
                'value' => function($model) {
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'film_id',
                'label' => 'Фильм',
                'value' => function($model) {
                    return $model->film->name;
                }
            ],
            [
                'attribute' => 'return_before',
                'label' => 'Вернуть до',
                'value' => function($model) {
                    return date('d.m.Y', $model->return_before);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>
</div>
