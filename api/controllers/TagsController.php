<?php

namespace api\controllers;

use common\components\Common;
use common\models\Tags;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class TagsController extends \yii\base\Controller
{
    /*
     * Function :
     * Description : List of Tags
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionGetTagsList()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'date');
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
                $date = date("Y-m-d H:i:s");
                $tagslist = Tags::find()->where("status = '" . Yii::$app->params['user_status_value']['active'] . "' AND updated_at BETWEEN '" . $requestParam['date'] . "' AND '" . $date . "'")->asArray()->all();
                $amReponseParam['sync_datetime'] = $date;
                $amReponseParam['tags_list'] = [];
                if (!empty($tagslist)) {

                    foreach ($tagslist as $key => $tag) {
                        unset($tag['created_at']);
                        unset($tag['updated_at']);
                        $image = Yii::$app->params['root_url'] . "uploads/" . $tag['image'];
                        $tagslist[$key]['image'] = $image;
                        $amReponseParam['tags_list'][] = $tag;
                    }

                    $ssMessage = 'Tags List';
                    $amResponse = Common::successResponse($ssMessage, $tagslist);
                } else {
                    $ssMessage = 'Tags List';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
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
