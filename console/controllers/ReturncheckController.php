<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\Taken;
use Yii;

class ReturncheckController extends Controller
{
    public function actionMail()
    {
        $now = strtotime("now");

        $takens = Taken::find()->where('return_before < :now', [':now' => $now])->all();

        foreach($takens as $taken) {
            $filmName =  $taken->film->name;
            $email =  $taken->user->email;

            $subject = 'Просрочен срок возврата фильма!';

            Yii::$app->mailer->compose()
                ->setFrom('admin@films.com')
                ->setTo($email)
                ->setSubject($subject)
                ->setTextBody('Фильм ' . $filmName . ' должен был быть возвращен до ' . $taken->return_before)
                ->send();
        }
    }
}