<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Taken */

$this->title = 'Create Taken';
$this->params['breadcrumbs'][] = ['label' => 'Takens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taken-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
