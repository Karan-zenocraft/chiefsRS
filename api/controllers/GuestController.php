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
use common\models\RestaurantFloors;
use common\models\RestaurantTables;
/**
 * MainController implements the CRUD actions for APIs.
 */
class GuestController extends \yii\base\Controller
{
        /*
     * Function :
     * Description : Add Guest
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
       public function actionAddGuest(){

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id','first_name','last_name','email','contact_no','date','booking_time','total_stay_time','floor_id',"table_id","no_of_guests");
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
                 if ( ( $gModel = Users::findOne(['email'=>$requestParam['email']])) !== null){
                     
                     $ssMessage  = 'This Email is already in user list. Please try another email';
                     $amResponse = Common::errorResponse( $ssMessage );
                     Common::encodeResponseJSON( $amResponse );
                }else if(($gModel = Users::findOne(['contact_no'=>$requestParam['contact_no']])) !== null){

                     $ssMessage  = 'This Contact Number is already in user list. Please try another Contact Number';
                     $amResponse = Common::errorResponse( $ssMessage );
                     Common::encodeResponseJSON( $amResponse );
                }else if(!empty($requestParam['floor_id']) && empty(RestaurantFloors::findOne(['id'=>$requestParam['floor_id']]))){
                      $ssMessage  = "There is no floor exist with this floor_id";
                      $amResponse = Common::errorResponse( $ssMessage );
                     Common::encodeResponseJSON( $amResponse );
                }else if(!empty($requestParam['table_id']) && empty(RestaurantTables::findOne(['id'=>$requestParam['table_id']]))){
                      $ssMessage  = "There is no table exist with this table_id";
                      $amResponse = Common::errorResponse( $ssMessage );
                     Common::encodeResponseJSON( $amResponse );
                }else if(!empty($requestParam['floor_id']) && !empty(RestaurantFloors::findOne(['id'=>$requestParam['floor_id'],"is_deleted"=>"1"]))){
                      $ssMessage  = "This floor is deleted please pass valid floor_id";
                      $amResponse = Common::errorResponse( $ssMessage );
                     Common::encodeResponseJSON( $amResponse );
                }else if(!empty($requestParam['table_id']) && !empty(RestaurantTables::findOne(['id'=>$requestParam['table_id'],"is_deleted"=>"1"]))){
                      $ssMessage  = "This table is deleted please pass valid table_id";
                      $amResponse = Common::errorResponse( $ssMessage );
                     Common::encodeResponseJSON( $amResponse );
                }else{
                  $tableModel = RestaurantTables::find()->where(['id'=>$requestParam['table_id']])->one();
                      if($tableModel['floor_id'] != $requestParam['floor_id']){
                        $ssMessage  = "This table is from another floor. Please pass this floor's table id";
                        $amResponse = Common::errorResponse( $ssMessage );
                        Common::encodeResponseJSON( $amResponse );
                    }
                    $guestModel = new Users();
                    $guestModel->first_name = !empty($requestParam['first_name']) ? $requestParam['first_name'] : "";
                    $guestModel->last_name = !empty($requestParam['last_name']) ? $requestParam['last_name'] : "";
                    $guestModel->email = !empty($requestParam['email']) ? $requestParam['email'] : "";
                    $guestModel->contact_no = !empty($requestParam['contact_no']) ? $requestParam['contact_no'] : "";
                    $guestModel->walkin_note = !empty($requestParam['special_comment']) ? $requestParam['special_comment'] : "";
                    $guestModel->birthdate = !empty($requestParam['birthday']) ? $requestParam['birthday'] : "";
                    $guestModel->anniversary = !empty($requestParam['anniversary']) ? $requestParam['anniversary'] : "";
                    $guestModel->role_id = Yii::$app->params['userroles']['walk_in'];
                    $guestModel->status = Yii::$app->params['user_status_value']['active'];
                    if($guestModel->save(false)){
                        $reserveationModel = new Reservations();
                        $reserveationModel->first_name = $guestModel->first_name;
                        $reserveationModel->last_name = $guestModel->last_name;
                        $reserveationModel->email = $guestModel->email;
                        $reserveationModel->contact_no = $guestModel->contact_no;
                        $reserveationModel->user_id = $guestModel->id;
                        $reserveationModel->restaurant_id = $restaurant_id;
                        $reserveationModel->floor_id = !empty($requestParam['floor_id']) ? $requestParam['floor_id'] : ""; 
                        $reserveationModel->table_id = !empty($requestParam['table_id']) ? $requestParam['table_id'] : ""; 
                        $reserveationModel->date = !empty($requestParam['date']) ? $requestParam['date'] : "";
                        $reserveationModel->booking_start_time = !empty($requestParam['booking_time']) ? $requestParam['booking_time'] : ""; 
                        $reserveationModel->total_stay_time =!empty($requestParam['total_stay_time']) ? $requestParam['total_stay_time'] : "";
                         $reserveationModel->booking_end_time = date("H:i:s", strtotime('+'.$requestParam['total_stay_time'].' minutes',strtotime($requestParam['booking_time'])));
                         $reserveationModel->no_of_guests =!empty($requestParam['no_of_guests']) ? $requestParam['no_of_guests'] : "";
                          $reserveationModel->special_comment =!empty($requestParam['special_comment']) ? $requestParam['special_comment'] : ""; 
                          $reserveationModel->status = Yii::$app->params['reservation_status_value']['booked'];
                          $reserveationModel->role_id = Yii::$app->params['userroles']['walk_in'];
                          $reserveationModel->save(false);
                          $amReponseParam = $reserveationModel;

                    $ssMessage                                = 'Guest is successfully created.';
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }
            }
            }else{
                 $ssMessage  = 'You have not assigned any restaurant yet.';
                 $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Invalid Manager.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

     /*
     * Function :
     * Description : Get List of Floors and tables
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
       public function actionGetGuestsList(){
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );
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
              $arrUserIds = Reservations::find()->select("user_id")->where(["restaurant_id"=>$restaurant_id,"status"=>Yii::$app->params['reservation_status_value']['completed']])->distinct()->all();
             if(!empty($arrUserIds)){
               foreach ($arrUserIds as $key => $user_id) {
                  $user_data = $user_id->user;
                  $user_data->id = "$user_data->id";
                  unset($user_data->password);
                  unset($user_data->restaurant_id);
                  unset($user_data->is_code_verified);
                  unset($user_data->password_reset_token);
                  unset($user_data->badge_count);
                  unset($user_data->auth_token);
                  unset($user_data->badge_count);
                  unset($user_data->verification_code);
                  unset($user_data->role_id);  
                  $user_data->address = !empty($user_data->address) ? $user_data->address : "";
                  $user_data->contact_no = !empty($user_data->contact_no) ? $user_data->contact_no : "";
                  $user_data->walkin_note = !empty($user_data->walkin_note) ? $user_data->walkin_note : "";
                  $user_data->birthdate = !empty($user_data->birthdate) ? $user_data->birthdate : "";
                  $user_data->anniversary = !empty($user_data->anniversary) ? $user_data->anniversary : "";
                  $user_data->status = !empty($user_data->status) ? Yii::$app->params['user_status'][$user_data->status] : "";
                  $usersDataArr[] = $user_data;
               }
               $amReponseParam = $usersDataArr;
                $ssMessage                                = 'Guest List';
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

             }else{
                 $ssMessage  = 'No guests found for your restaurant';
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

}
