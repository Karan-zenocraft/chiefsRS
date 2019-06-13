<?php

namespace frontend\controllers;

use Yii;
use common\models\Reservations;
use common\models\ReservationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\components\FrontCoreController;
use common\models\Restaurants;

/**
 * ReservationsController implements the CRUD actions for Reservations model.
 */
class ReservationsController extends FrontCoreController
{
    /**
     * {@inheritdoc}
     */
  /*  public function behaviors()
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
     * Lists all Reservations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "booking";
        $searchModel = new ReservationsSearch();
        $snRestaurantDropDown = Restaurants::RestaurantsDropdown();
        $dataProvider = $searchModel->forntendSearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snRestaurantDropDown' => $snRestaurantDropDown
        ]);
    }

    /**
     * Displays a single Reservations model.
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
     * Creates a new Reservations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $this->layout = "booking";
        $snRestaurantDropDown = Restaurants::RestaurantsDropdown();
        $model = new Reservations();
        $postData = Yii::$app->request->post();
       
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->restaurant_id = (isset($_GET['rid']) && !empty($_GET['rid'])) ? $_GET['rid'] : $model->restaurant_id;
            $model->booking_start_time = date("H:i:s", strtotime($postData['Reservations']['booking_start_time']));
            $model->booking_end_time = date("H:i:s", strtotime($postData['Reservations']['booking_end_time']));
             if($postData['Reservations']['pickup_drop'] == 0){
            $model->pickup_time = "";
            $model->drop_time = "";
            $model->pickup_location = "";
            $model->drop_location = "";
            $model->pickup_lat = "";
            $model->pickup_long = "";
            $model->drop_lat = "";
            $model->drop_long = "";
        }else{

             $model->pickup_time = !empty($model->pickup_time) ? date("H:i:s", strtotime($postData['Reservations']['pickup_time'])) : "";
            $model->drop_time = !empty($model->pickup_time) ? date("H:i:s", strtotime($postData['Reservations']['drop_time'])) : "";
        }
            $model->status = Yii::$app->params['reservation_status_value']['requested'];
            
            $model->save(false);
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@create_booking_message' ) );
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'snRestaurantDropDown' => $snRestaurantDropDown
        ]);
    }

    /**
     * Updates an existing Reservations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = "booking";
        $model = $this->findModel($id);
         $postData = Yii::$app->request->post();
        $snRestaurantDropDown = Restaurants::RestaurantsDropdown();
        if ($model->load($postData)) {

            $model->booking_start_time = date("H:i:s", strtotime($postData['Reservations']['booking_start_time']));
            $model->booking_end_time = date("H:i:s", strtotime($postData['Reservations']['booking_end_time']));
        if($postData['Reservations']['pickup_drop'] == 0){
            $model->pickup_time = "";
            $model->drop_time = "";
            $model->pickup_location = "";
            $model->drop_location = "";
            $model->pickup_lat = "";
            $model->pickup_long = "";
            $model->drop_lat = "";
            $model->drop_long = "";
        }else{

             $model->pickup_time = !empty($model->pickup_time) ? date("H:i:s", strtotime($postData['Reservations']['pickup_time'])) : "";
            $model->drop_time = !empty($model->pickup_time) ? date("H:i:s", strtotime($postData['Reservations']['drop_time'])) : "";
        }
            $model->status = "0";
            $model->save(false);
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@update_booking_message' ) );
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'snRestaurantDropDown' => $snRestaurantDropDown
        ]);
    }

    /**
     * Deletes an existing Reservations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(!empty($model)){
            $model->status = "4";
            $model->save(false);
        }
        Yii::$app->session->setFlash( 'success', Yii::getAlias( '@delete_booking_message' ) );
        return $this->redirect(['index']);
    }

     public function actionCancel($id)
    {
        $model = $this->findModel($id);
        if(!empty($model)){
            $model->status = "3";
            $model->save(false);
        }
        Yii::$app->session->setFlash( 'success', Yii::getAlias( '@cancel_booking_message' ) );
        return $this->redirect(['index']);
    }

    /**
     * Finds the Reservations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reservations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}