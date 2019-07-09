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
        $amRequiredParams = array( 'user_id','first_name','last_name','email','contact_no');
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
                }else if(($gModel = Users::findOne(['contact_no'=>$requestParam['contact_no']])) !== null){

                     $ssMessage  = 'This Contact Number is already in user list. Please try another Contact Number.';
                     $amResponse = Common::errorResponse( $ssMessage );
                }else{
                    $guestModel = new Users();
                    $guestModel->first_name = !empty($requestParam['first_name']) ? $requestParam['first_name'] : "";
                    $guestModel->last_name = !empty($requestParam['last_name']) ? $requestParam['last_name'] : "";
                    $guestModel->email = !empty($requestParam['email']) ? $requestParam['email'] : "";
                    $guestModel->contact_no = !empty($requestParam['contact_no']) ? $requestParam['contact_no'] : "";
                    $guestModel->walkin_note = !empty($requestParam['walkin_note']) ? $requestParam['walkin_note'] : "";
                    $guestModel->birthdate = !empty($requestParam['birthday']) ? $requestParam['birthday'] : "";
                    $guestModel->anniversary = !empty($requestParam['anniversary']) ? $requestParam['anniversary'] : "";
                    $guestModel->role_id = Yii::$app->params['userroles']['walk_in'];
                    $guestModel->status = Yii::$app->params['user_status_value']['active'];
                    $guestModel->save(false); 
                     $amReponseParam['GuestDetails']['id'] = !empty($guestModel['id']) ? $guestModel['id'] : "null";
                    $amReponseParam['GuestDetails']['first_name'] = !empty($guestModel['first_name']) ? $guestModel['first_name'] : "null";
                    $amReponseParam['GuestDetails']['last_name'] = !empty($guestModel['last_name']) ? $guestModel['last_name'] : "null";
                    $amReponseParam['GuestDetails']['email'] = !empty($guestModel['email']) ? $guestModel['email'] : "null";
                    $amReponseParam['GuestDetails']['contact_no'] = !empty($guestModel['contact_no']) ? $guestModel['contact_no'] : "null";
                    $amReponseParam['GuestDetails']['guest_note'] = !empty($guestModel['guest_note']) ? $guestModel['guest_note'] : "null";
                    $amReponseParam['GuestDetails']['birthday'] = !empty($guestModel['birthdate']) ? $guestModel['birthdate'] : "null";
                    $amReponseParam['GuestDetails']['anniversary'] = !empty($guestModel['anniversary']) ? $guestModel['anniversary'] : "null";
                   
                    $ssMessage                                = 'Guest is successfully created.';
                    $amReponseParam             = $amReponseParam;
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
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

}
