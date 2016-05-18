<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin-bottom: 20px;">
        <label>Поиск по жанру:</label>
        <?php echo Html::input('text', 'search-query', '', ['class' => 'form-control', 'id' => 'search-query']); ?>
    </div>

    <div id="catalog-cont">
        <?php
        if (count($films) > 0) {
            $count = 0;
            foreach ($films as $film) {
                $count++;
                if ($count % 4 == 1) {
                    echo Html::beginTag('div', ['class' => 'row']);
                }
                echo Html::beginTag('div', ['class' => 'col-md-3 text-center']);
                if ($film->art != null) {
                    echo Html::beginTag('a', ['href' => \yii\helpers\Url::toRoute(['library/view', 'id' => $film->id])]);
                        echo Html::img('@web/images/upload/' . $film->art,
                            ['class' => 'img-responsive', 'style' => 'margin:0 auto; height:270px;']);
                    echo Html::endTag('a');
                } else {
                    echo Html::beginTag('a', ['href' => \yii\helpers\Url::toRoute(['library/view', 'id' => $film->id])]);
                        echo Html::img('@web/images/upload/no_art.png',
                            ['class' => 'img-responsive', 'style' => 'margin:0 auto; height:270px;']
                        );
                    echo Html::endTag('a');
                }
                echo Html::tag('p', '<b>Название: </b>' . $film->name);
                echo Html::tag('p', '<b>Год выпуска: </b>' . $film->year);
                echo Html::tag('p', '<b>Жанры: </b>' . $film->genre);
                //                echo Html::tag('p', '<b>Наличие: </b>' . ($film->count_all - $film->q_taken));
                echo Html::endTag('div');
                if ($count % 4 == 0) {
                    echo Html::endTag('div', ['class' => 'row']);
                }
            }
            if ($count % 4 !== 0) {
                echo Html::endTag('div', ['class' => 'row']);
            }
        } else {
            echo Html::tag('div', 'К сожалению, фильмов такого жанра не найдено.', ['class' => 'text-center']);
        }
        ?>

        <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
        ?>
    </div>
</div>

<?php
$script = '
    $(function(){
        $("#search-query").keyup(function () {
            var query = this;
            value = $(this).val();
            $.ajax({
                type: "POST",
                data: {"search-query" : value},
                success: function(data){
                    if (value==$(query).val()) {
                        $("#catalog-cont").html($(data).find("#catalog-cont").prop(\'outerHTML\'));
                    }
                }
            });
        })
    });
';
$this->registerJs($script, yii\web\View::POS_READY);