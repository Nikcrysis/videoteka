<?php
/* @var $this yii\web\View */
?>

<div class="row">

    <div class="taken col-md-6">
        <h2>Взятые в прокат фильмы:</h2>
        <?php
         if (count($filmsTaken) > 0) {
             foreach ($filmsTaken as $taken) {
                 echo \yii\bootstrap\Html::beginTag('div');
                 $film = $taken->film;
                 echo \yii\helpers\Html::tag('p', 'Название фильма: ' . $film->name);
                 echo \yii\helpers\Html::tag('p', 'Вернуть до ' . date('d.m.Y', $taken->return_before));
                 echo \yii\bootstrap\Html::endTag('div');
             }
         } else {
             echo \yii\bootstrap\Html::tag('p', 'У вас нет взятых в прокат фильмов');
         }
        ?>
    </div>

    <div class="bought col-md-6">
        <h2>Купленные фильмы:</h2>
        <?php
        if (count($filmsBought) > 0) {
            foreach ($filmsBought as $bought) {
                echo \yii\bootstrap\Html::beginTag('div');
                $film = $bought->film;
                echo \yii\helpers\Html::tag('p', 'Название фильма: ' . $film->name);
                echo \yii\bootstrap\Html::endTag('div');
            }
        } else {
            echo \yii\bootstrap\Html::tag('p', 'У вас нет купленных фильмов');
        }
        ?>
    </div>
</div>