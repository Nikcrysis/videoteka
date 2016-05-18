<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Library */

?>
<div class="text-center">

    <h1>Операция прошла успешно!</h1>
    <?= Html::a('Вернуться в каталог', \yii\helpers\Url::toRoute('library/index')); ?>

</div>
