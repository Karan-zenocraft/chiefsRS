<?php

namespace api\controllers;

use Yii;
use yii\helpers\Json;
use common\components\Common;
use yii\web\Controller;
use api\components\ApiCoreController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\UploadedFile;
use yii\db\Query;

/* USE COMMON MODELS */
use common\models\Users;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use common\models\DeviceDetails;
use common\models\EmailFormat;
use common\models\Reservations;
use common\models\Guests;
/**
 * MainController implements the CRUD actions for APIs.
 */
class ReservationsController extends \yii\base\Controller
{
        /*
     * Function :
     * Description : List of requested reservations
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionGetReservationList() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id','date');
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){
                $reservations = Reservations::find()->where(['restaurant_id'=>$restaurant_id,"status"=>Yii::$app->params['reservation_status_value']['requested'],"date"=>$requestParam['date']])->asArray()->all();
                    if(!empty($reservations)){
                        foreach ($reservations as $key => $reservation){
                          $reservation['layout_id'] = !empty($reservation['layout_id']) ? $reservation['layout_id'] : "null";
                           $reservation['table_id'] = !empty($reservation['table_id']) ? $reservation['table_id'] : "null";
                            $reservation['pickup_location'] = !empty($reservation['pickup_location']) ? $reservation['pickup_location'] : "null";
                            $reservation['pickup_time'] = !empty($reservation['pickup_time']) ? $reservation['pickup_time'] : "null";
                            $reservation['drop_location'] = !empty($reservation['drop_location']) ? $reservation['drop_location'] : "null";
                            $reservation['drop_time'] = !empty($reservation['drop_time']) ? $reservation['drop_time'] : "null";
                            $reservation['updated_at'] = !empty($reservation['updated_at']) ? $reservation['updated_at'] : "null";
                            unset($reservation['pickup_lat']);
                            unset($reservation['pickup_long']);
                            unset($reservation['drop_lat']);
                            unset($reservation['drop_long']);
                           $arrReservation[] = $reservation;
                        }
                    $ssMessage                                = 'User Reservations Details.';

                    $amReponseParam['reservations']            = $arrReservation;

                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

                }else{
                     $ssMessage  = 'There is no any reservations on this date.';
                     $amResponse = Common::errorResponse( $ssMessage );
                }
            }else{
                 $ssMessage  = 'You have not assigned any restaurant yet.';
                 $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

            /*
     * Function :
     * Description : Book Table
     * Request Params :'user_id','auth_token','reservation_id','table_id','layout_id'
     * Response Params :
     * Author :Rutusha Joshi
     */

  /*  public function actionGetReservationList() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id','date');
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){
                $reservations = Reservations::find()->where(['restaurant_id'=>$restaurant_id,"status"=>Yii::$app->params['reservation_status_value']['requested'],"date"=>$requestParam['date']])->asArray()->all();
                    if(!empty($reservations)){
                        foreach ($reservations as $key => $reservation){
                          $reservation['layout_id'] = !empty($reservation['layout_id']) ? $reservation['layout_id'] : "null";
                           $reservation['table_id'] = !empty($reservation['table_id']) ? $reservation['table_id'] : "null";
                            $reservation['pickup_location'] = !empty($reservation['pickup_location']) ? $reservation['pickup_location'] : "null";
                            $reservation['pickup_time'] = !empty($reservation['pickup_time']) ? $reservation['pickup_time'] : "null";
                            $reservation['drop_location'] = !empty($reservation['drop_location']) ? $reservation['drop_location'] : "null";
                            $reservation['drop_time'] = !empty($reservation['drop_time']) ? $reservation['drop_time'] : "null";
                            $reservation['updated_at'] = !empty($reservation['updated_at']) ? $reservation['updated_at'] : "null";
                            unset($reservation['pickup_lat']);
                            unset($reservation['pickup_long']);
                            unset($reservation['drop_lat']);
                            unset($reservation['drop_long']);
                           $arrReservation[] = $reservation;
                        }
                    $ssMessage                                = 'User Reservations Details.';

                    $amReponseParam['reservations']            = $arrReservation;

                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

                }else{
                     $ssMessage  = 'There is no any reservations on this date.';
                     $amResponse = Common::errorResponse( $ssMessage );
                }
            }else{
                 $ssMessage  = 'You have not assigned any restaurant yet.';
                 $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }*/
}
