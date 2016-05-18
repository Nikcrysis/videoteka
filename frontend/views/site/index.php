<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use common\models\User;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<style>
    img {
        /*max-height: 200px;*/
        margin: 0 auto;
    }
    .wrap > .container {
        padding-bottom: 0 !important;
    }
</style>

<div class="site-index">

    <div class="text-center">
        <h1>Добро пожаловать!</h1>

        <p class="lead">Чтобы перейти в каталог фильмов, нажмите большую зеленую кнопку ниже!</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute('library/index') ?>">Перейти в каталог -></a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <?php echo Html::img('@web/images/1.png', ['class' => 'img-responsive']) ?>
            </div>
        </div>

    </div>
</div>
