<?php

namespace frontend\controllers;

use common\models\Taken;
use common\models\User;
use Yii;

class UserController extends \yii\web\Controller
{
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/index');
        } else {
            $user = $this->findModel(Yii::$app->user->identity->id);
            $filmsTaken = $user->takens;
            $filmsBought = $user->boughts;

            return $this->render('profile', [
                'filmsTaken' => $filmsTaken,
                'filmsBought' => $filmsBought,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
