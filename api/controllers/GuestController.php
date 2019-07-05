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
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){

                $guestModel = new Guests();
                $guestModel->first_name = !empty($requestParam['first_name']) ? $requestParam['first_name'] : "";
                $guestModel->last_name = !empty($requestParam['last_name']) ? $requestParam['last_name'] : "";
                $guestModel->email = !empty($requestParam['email']) ? $requestParam['email'] : "";
                $guestModel->contact_no = !empty($requestParam['contact_no']) ? $requestParam['contact_no'] : "";
                $guestModel->reservation_id = !empty($requestParam['reservation_id']) ? $requestParam['reservation_id'] : "";
                $guestModel->restaurant_id = $restaurant_id;
                $guestModel->reservation_id = !empty($requestParam['reservation_idguest_note']) ? $requestParam['guest_note'] : "";
                $guestModel->birthday = !empty($requestParam['birthday']) ? $requestParam['birthday'] : "";
                $guestModel->anniversary = !empty($requestParam['anniversary']) ? $requestParam['anniversary'] : "";
                $guestModel->save(false); 
                 $amReponseParam['GuestDetails']['id'] = !empty($guestModel['id']) ? $guestModel['id'] : "null";
                $amReponseParam['GuestDetails']['first_name'] = !empty($guestModel['first_name']) ? $guestModel['first_name'] : "null";
                $amReponseParam['GuestDetails']['last_name'] = !empty($guestModel['last_name']) ? $guestModel['last_name'] : "null";
                $amReponseParam['GuestDetails']['email'] = !empty($guestModel['email']) ? $guestModel['email'] : "null";
                $amReponseParam['GuestDetails']['contact_no'] = !empty($guestModel['contact_no']) ? $guestModel['contact_no'] : "null";
                $amReponseParam['GuestDetails']['guest_note'] = !empty($guestModel['guest_note']) ? $guestModel['guest_note'] : "null";
                $amReponseParam['GuestDetails']['birthday'] = !empty($guestModel['birthday']) ? $guestModel['birthday'] : "null";
                $amReponseParam['GuestDetails']['anniversary'] = !empty($guestModel['anniversary']) ? $guestModel['anniversary'] : "null";
                $amReponseParam['GuestDetails']['reservation_id'] = !empty($guestModel['reservation_id']) ? $guestModel['reservation_id'] : "null";
                $amReponseParam['GuestDetails']['restaurant_id'] = !empty($guestModel['restaurant_id']) ? $guestModel['restaurant_id'] : "null";
               
                $ssMessage                                = 'Guest is successfully created.';
                $amReponseParam             = $amReponseParam;
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
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
    protected function matchUserStatus( $id ) {
       
        if ( ( $model = Users::findOne( $id ) ) !== null ) {
            if ( $model->status == Yii::$app->params['user_status_value']['in_active'] ) {
                $ssMessage     = 'User has been deactivated by admin.';
                $WholeMealData = Common::negativeResponse( $ssMessage );
                Common::encodeResponseJSON( $WholeMealData );
            }
        }
        else {
            $ssMessage     = 'User is not available';
            $WholeMealData = Common::negativeResponse( $ssMessage );
            Common::encodeResponseJSON( $WholeMealData );
        }
    }


}
