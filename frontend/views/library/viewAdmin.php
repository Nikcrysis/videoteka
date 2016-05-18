<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Library */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="col-md-6">
        <?php
        if ($model->art != null) {
            echo Html::img('@web/images/upload/' . $model->art, ['class' => 'img-responsive', 'style' => 'margin:0 auto; height:400px;']);
        } else {
            echo Html::img('@web/images/upload/no_art.png', ['class' => 'img-responsive', 'style' => 'margin:0 auto; height:400px;']);
        }
        ?>
    </div>
    <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
                'name',
                'genre',
                'year',
//                'count_all',
//                'count_taken',
                'prce_for_sale',
                'prce_for_take',
//                'q_taken',
//                'q_bought',
            ],
        ]) ?>
    </div>

</div>
