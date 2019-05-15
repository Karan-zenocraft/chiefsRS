<?php

namespace backend\controllers;

use Yii;
use common\models\Restaurants;
use common\models\RestaurantsSearch;
use yii\web\Controller;
use backend\components\AdminCoreController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\RestaurantMealTimes;
use yii\helpers\ArrayHelper;
use common\models\RestaurantMealTimesSearch;
use common\components\Common;
use common\models\RestaurantWorkingHours;

/**
 * RestaurantsController implements the CRUD actions for Restaurants model.
 */
class RestaurantsController extends AdminCoreController
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
     * Lists all Restaurants models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RestaurantsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Restaurants model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'popup';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
      public function actionTest()
    {
        return $this->render('test');
    }

    /**
     * Creates a new Restaurants model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Restaurants();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

           $mealTimes = Yii::$app->params['meal_times'];
           foreach ($mealTimes as $key => $value) {
                $modelMealTimes = new RestaurantMealTimes();
                $modelMealTimes->restaurant_id = $model->id;
                $modelMealTimes->meal_type = $key;
                $modelMealTimes->status = "1";
                $modelMealTimes->save(false);
           }
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_add_message' ) );
            return $this->redirect( ['restaurants/index'] );
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Restaurants model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    $milestones = ArrayHelper::map( RestaurantMealTimes::find()->where( ['restaurant_id' => $id] )->asArray()->all(), 'meal_type', 'meal_type' );
    $searchModel = new RestaurantMealTimesSearch();
    $queryParams = array_merge( array(), Yii::$app->request->getQueryParams() );
    $queryParams["RestaurantMealTimesSearch"]["restaurant_id"] = $id;
    $dataProvider = $searchModel->backendSearch( $queryParams );
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_update_message' ) );
            return $this->redirect( ['restaurants/index'] );
        }

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Restaurants model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
          $snDeleteStatus = $this->findModel( $id )->delete();
         if ( !empty( $snDeleteStatus ) && $snDeleteStatus=='1' ) {
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_delete_message' ) );
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateWorkinghours($rid){
    
    $this->layout = 'popup';
    //GET PROJECT NAME BY PROJECT ID
    $snRestaurantName = Restaurants::find()->where( "id=$rid" )->one();
    $arrWeeks = Yii::$app->params['week_days'];
    $week_days_hours_details = array();
    foreach ( $arrWeeks as $key=>$week ) {
      $weekDetails[$key] = $week;
      $days = RestaurantWorkingHours::find()->where( ['restaurant_id' => $rid, 'weekday'=>$key] )->one();

      if ( !empty( $days ) ) {
        $week_days_hours_details[$key] = $days;
      }else {
        $week_days_hours_details[$key] = new RestaurantWorkingHours;
      }
    }
      if (Yii::$app->request->post()){
      $arrRequestFields = $_REQUEST['RestaurantWorkingHours'];
      $postData = Yii::$app->request->post();
      $postData = $postData['RestaurantWorkingHours'];
      foreach ( $postData as $key => $value ) {
          $week_days_hours_details[$key]->load( $value );
          $week_days_hours_details[$key]['weekday'] = $key;
          $week_days_hours_details[$key]['hours24'] = $value['hours24'];
          $week_days_hours_details[$key]['restaurant_id'] = $rid;
          $week_days_hours_details[$key]['opening_time'] = $value['opening_time'];
          $week_days_hours_details[$key]['closing_time'] = $value['closing_time'];
          $week_days_hours_details[$key]['status'] = $value['status'];
          $week_days_hours_details[$key]->save();
         
      }
      Yii::$app->session->setFlash( 'success', Yii::getAlias( '@hours_update_message' ) );
      return Common::closeColorBox();
    }
      return $this->render( 'hours', [
      'snRestaurantName' => $snRestaurantName->name,
      'week_days_hours_details' => $week_days_hours_details,
      'weekDetails' => $weekDetails
      ] );
    }

    /**
     * Finds the Restaurants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Restaurants::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
