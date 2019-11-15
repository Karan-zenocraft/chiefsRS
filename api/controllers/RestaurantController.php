<?php

namespace api\controllers;

use common\components\Common;
use common\models\Restaurants;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class RestaurantController extends \yii\base\Controller
{
    /*
     * Function :
     * Description : List of Tags
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionUpdateStatusRestaurant()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'status');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";

            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);
                $restaurant = Restaurants::findOne($restaurant_id);
                if (!empty($restaurant)) {
                    $status = !empty($requestParam['status']) && ($requestParam['status'] == 1) ? Yii::$app->params['user_status_value']['active'] : Yii::$app->params['user_status_value']['in_active'];
                    $restaurant->status = $status;
                    $restaurant->save(false);
                    $amReponseParam = [];
                    $ssMessage = !empty($requestParam['status']) && ($requestParam['status'] == 1) ? 'Your Restaurant is turn on successfully.' : 'Your Restaurant is turn off successfully.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'This restaurant does not exist';
                    $amResponse = Common::errorResponse($ssMessage);
                }
            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    /*
     * Function :
     * Description : Get current status of restaurant
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionGetRestaurantStatus()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";

            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);
                $restaurant = Restaurants::findOne($restaurant_id);
                if (!empty($restaurant)) {
                    $status = $restaurant->status;
                    $amReponseParam['status'] = $status;
                    $ssMessage = "Restaurant Status";
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'This restaurant does not exist';
                    $amResponse = Common::errorResponse($ssMessage);
                }
            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
}
