<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use common\models\Library;
/* @var $this yii\web\View */
/* @var $searchModel common\models\LibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Возврат взятых в прокат фильмов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'label' => 'Пользователь',
                'value' => function($model) {
                    return User::find()->where('id=:id', [':id' => $model->user_id])->one()->username;
                }
            ],

            [
                'attribute' => 'film_id',
                'label' => 'Фильм',
                'value' => function($model) {
                    return Library::find()->where('id=:id', [':id' => $model->film_id])->one()->name;
                }
            ],

            [
                'attribute' => 'return_before',
                'label' => 'Вернуть до',
                'value' => function($model) {
                    return date('d.m.Y', $model->return_before);
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
</div>
