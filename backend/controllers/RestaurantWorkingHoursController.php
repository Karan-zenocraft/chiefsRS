<?php

namespace backend\controllers;

use Yii;
use common\models\RestaurantWorkingHours;
use common\models\RestaurantWorkingHoursSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\AdminCoreController;
use common\components\Common;

/**
 * RestaurantWorkingHoursController implements the CRUD actions for RestaurantWorkingHours model.
 */
class RestaurantWorkingHoursController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
   /* public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all RestaurantWorkingHours models.
     * @return mixed
     */
    public function actionIndex()
    {
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $snRestaurantName = Common::get_name_by_id($snRestaurantId,$flag = "Restaurants");
        $searchModel = new RestaurantWorkingHoursSearch();
        $dataProvider = $searchModel->backendsearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snRestaurantName' => $snRestaurantName
        ]);
    }

    /**
     * Displays a single RestaurantWorkingHours model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RestaurantWorkingHours model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $postData = Yii::$app->request->post();
         $days = Yii::$app->params['week_days'];
        if(Yii::$app->request->post()){
             foreach ($days as $key => $value) { 
                $model = new RestaurantWorkingHours();
                $model->restaurant_id = $_GET['rid'];
                $model->weekday = $key;
                $model->opening_time = $postData['RestaurantWorkingHours']['opening_time'][$key];
                $model->closing_time = $postData['RestaurantWorkingHours']['closing_time'][$key];
                $model->status = $postData['RestaurantWorkingHours']['status'][$key];
                $model->save();
             }
        }
            return $this->redirect(['index', 'rid' => $model->restaurant_id]);

        return $this->render('create', [
            'days' => $days,
        ]);
    }

    /**
     * Updates an existing RestaurantWorkingHours model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RestaurantWorkingHours model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RestaurantWorkingHours model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantWorkingHours the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantWorkingHours::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
