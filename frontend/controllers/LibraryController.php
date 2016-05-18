<?php

namespace frontend\controllers;

use common\models\Actions;
use common\models\Taken;
use Yii;
use common\models\Library;
use common\models\LibrarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\data\Pagination;
use common\models\Bought;

/**
 * LibraryController implements the CRUD actions for Library model.
 */
class LibraryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Library models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibrarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!Yii::$app->user->isGuest && User::isUserAdmin(Yii::$app->user->identity->username)){

            return $this->render('indexAdmin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $searchInput = Yii::$app->request->Post('search-query');
            $query = Library::find();
            if (isset($searchInput) ) {
                $query = $query->where(['LIKE','genre', $searchInput]);
            }

            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
            $films = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            if(Yii::$app->request->isAjax){
                echo $this->renderPartial('catalog', array(
                    'films' => $films,
                    'pages' => $pages,
                ));
            } else {
                return $this->render('catalog', [
                    'films' => $films,
                    'pages' => $pages,
                ]);
            }
        }
    }

    /**
     * Displays a single Library model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->user->isGuest && User::isUserAdmin(Yii::$app->user->identity->username)) {
            return $this->render('viewAdmin', [
                'model' => $model,
            ]);
        } else {
            $model->q_viewed += 1;
            $model->save();

            $action = new Actions();
            $action->type = 'view';
            $action->film_id = $id;
            $action->user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
            $action->date = strtotime('now');
            $action->save();

            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    public function actionTake($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login', 302);
        } else {
            return $this->render('take', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionTakeConfirm($id)
    {
        if ((Taken::find()
                ->where(
                    'film_id=:f AND user_id=:u', [':f' => $id, ':u' => intval(Yii::$app->user->identity->getId())])
                ->one() == null && Bought::find()
                ->where(
                    'film_id=:f AND user_id=:u', [':f' => $id, ':u' => intval(Yii::$app->user->identity->getId())])
                ->one() == null)) {


            $taken = new Taken();
            $taken->user_id = Yii::$app->user->identity->getId();
            $taken->film_id = $id;
            $taken->return_before = strtotime("+1 week");

            if ($taken->save()) {
                $model = $this->findModel($id);
                $model->q_taken += 1;
                $model->save();
                $action = new Actions();
                $action->type = 'take';
                $action->film_id = $id;
                $action->user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
                $action->date = strtotime('now');
                $action->save();

                return $this->render('success');
            }
        } else {
            return $this->render('error');
        }
    }

    public function actionBuy($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login', 302);
        } else {
            return $this->render('buy', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionBuyConfirm($id)
    {
        if ((Bought::find()
                ->where(
                'film_id=:f AND user_id=:u', [':f' => $id, ':u' => intval(Yii::$app->user->identity->getId())])
                ->one() == null
        )) {

            $taken = new Bought();
            $taken->user_id = Yii::$app->user->identity->getId();
            $taken->film_id = $id;

            if ($taken->save()) {
                $model = $this->findModel($id);
                $model->q_bought += 1;
                $model->save();
                $action = new Actions();
                $action->type = 'buy';
                $action->film_id = $id;
                $action->user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
                $action->date = strtotime('now');
                $action->save();
                return $this->render('success');
            }
        } else {
            return $this->render('error');
        }
    }

    public function actionStatistic()
    {
        if (!Yii::$app->user->isGuest && User::isUserAdmin(Yii::$app->user->identity->username)) {
            $searchModel = new LibrarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('statisticAdmin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect('/site/index');
        }
    }



    /**
     * Creates a new Library model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Library();

        $fileName = 'file';
        $imgs = \yii\web\UploadedFile::getInstancesByName($fileName);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($imgs as $img) {
                $mysqlName = time().'_'. $img->name;
                $url = getcwd() . '/images/upload/' . $mysqlName ;
                $img->saveAs($url);
                chmod($url, 0777);
                $model->art = $mysqlName;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Library model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $fileName = 'file';
        $imgs = \yii\web\UploadedFile::getInstancesByName($fileName);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($imgs as $img) {
                $mysqlName = time().'_'. $img->name;
                $url = getcwd() . '/images/upload/' . $mysqlName ;
                $img->saveAs($url);
                chmod($url, 0777);
                $model->art = $mysqlName;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Library model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Library model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Library the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Library::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
