<?php

use common\models\Library;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ActionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Действия';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'filter' => false,
                'value' => function($model) {
                    switch ($model->type) {
                        case 'view':
                            return 'просмотр';
                            break;
                        case 'take':
                            return 'прокат';
                            break;
                        case 'buy':
                            return 'покупка';
                            break;
                        default:
                            return 'действие неопределено';
                    }
                }
            ],
            [
                'attribute' => 'film_id',
                'filter' => false,
                'value' => function($model) {
                    return $model->film->name;
                }
            ],
            [
                'attribute' => 'user_id',
                'filter' => false,
                'value' => function($model) {
                    return $model->user_id == null ? 'Гость' : $model->user->username;
                }
            ],
            [
                'attribute' => 'date',
                'value' => function($model) {
                    return date('d.m.Y H:i:s', $model->date);
                }
            ],
        ],
    ]); ?>
</div>
