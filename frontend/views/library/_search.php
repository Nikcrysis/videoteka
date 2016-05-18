<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LibrarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="library-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'genre') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'count_all') ?>

    <?php // echo $form->field($model, 'count_taken') ?>

    <?php // echo $form->field($model, 'prce_for_sale') ?>

    <?php // echo $form->field($model, 'prce_for_take') ?>

    <?php // echo $form->field($model, 'q_taken') ?>

    <?php // echo $form->field($model, 'q_bought') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
