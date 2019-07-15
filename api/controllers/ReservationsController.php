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
use yii\data\Pagination;
/**
 * MainController implements the CRUD actions for APIs.
 */
class ReservationsController extends \yii\base\Controller
{
        /*
     * Function :
     * Description : List of requested reservations
     * Request Params :'user_id','date'
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
              $arrReservationsList = Reservations::find()
             ->select(["users.id","users.first_name","users.last_name","users.email","users.address","users.contact_no","users.status","users.created_at","reservations.id as reservation_id","reservations.floor_id","reservations.table_id","reservations.date","reservations.booking_start_time","reservations.booking_end_time","reservations.total_stay_time","reservations.no_of_guests","reservations.pickup_drop","reservations.pickup_location","reservations.pickup_time","reservations.drop_location","reservations.drop_time","reservations.tag_id","reservations.special_comment","reservations.role_id"])
             ->leftJoin('users','reservations.user_id=users.id')
             ->where(["reservations.restaurant_id"=>$restaurant_id,"reservations.status"=>Yii::$app->params['reservation_status_value']['requested'],"reservations.date"=>$requestParam['date']]) 
             ->orderBy('reservations.created_at');
        /*     ->asArray()
             ->all();*/
                $countQuery = clone $arrReservationsList;  
                $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize'=>1]);
                $totalCount = $pages->totalCount;
               for($i=0;$i<$totalCount;$i++){
                //$links[] = "http://".$_SERVER['HTTP_HOST'].$pages->createUrl($i-1);
                $page_no[] = $i+1;
               }
        
                $models = $arrReservationsList->offset((isset($requestParam['page_no']) && !empty($requestParam['page_no'])) ? $requestParam['page_no'] : $pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();   
                    if(!empty($models)){
                        foreach ($models as $key => $reservation){
                            unset($reservation['pickup_lat']);
                            unset($reservation['pickup_long']);
                            unset($reservation['drop_lat']);
                            unset($reservation['drop_long']);
                             $arrReservation[] = array_map('strval', $reservation);
                        }
                $amReponseParam['reservations'] = $models;
                $amReponseParam['pages'] = $page_no;
                    $ssMessage                                = 'User Reservations Details.';
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

                }else{
                     $ssMessage  = 'No reservations found.';
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
     * Description : Book table for requested reservations
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionBookTable() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id','reservation_id',"floor_id","table_id");
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
}
