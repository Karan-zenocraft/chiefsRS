<?php

namespace api\controllers;

use common\components\Common;
use common\models\Reservations;
use common\models\Users;

/* USE COMMON MODELS */
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

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
    /* public function actionAddGuest()
    {

    //Get all request parameter
    $amData = Common::checkRequestType();
    $amResponse = $amReponseParam = [];

    // Check required validation for request parameter.
    $amRequiredParams = array('user_id', 'first_name', 'last_name', 'email', 'contact_no', 'date', 'booking_time', 'total_stay_time', 'floor_id', "table_id", "no_of_guests");
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
    if (($gModel = Users::findOne(['email' => $requestParam['email']])) !== null) {

    $ssMessage = 'This Email is already in user list. Please try another email';
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else if (($gModel = Users::findOne(['contact_no' => $requestParam['contact_no']])) !== null) {

    $ssMessage = 'This Contact Number is already in user list. Please try another Contact Number';
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else if (!empty($requestParam['floor_id']) && empty(RestaurantFloors::findOne(['id' => $requestParam['floor_id']]))) {
    $ssMessage = "There is no floor exist with this floor_id";
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else if (!empty($requestParam['table_id']) && empty(RestaurantTables::findOne(['id' => $requestParam['table_id']]))) {
    $ssMessage = "There is no table exist with this table_id";
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else if (!empty($requestParam['floor_id']) && !empty(RestaurantFloors::findOne(['id' => $requestParam['floor_id'], "is_deleted" => "1"]))) {
    $ssMessage = "This floor is deleted please pass valid floor_id";
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else if (!empty($requestParam['table_id']) && !empty(RestaurantTables::findOne(['id' => $requestParam['table_id'], "is_deleted" => "1"]))) {
    $ssMessage = "This table is deleted please pass valid table_id";
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else {
    $tableModel = RestaurantTables::find()->where(['id' => $requestParam['table_id']])->one();
    if ($tableModel['floor_id'] != $requestParam['floor_id']) {
    $ssMessage = "This table is from another floor. Please pass this floor's table id";
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
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
    if ($guestModel->save(false)) {
    $reserveationModel = new Reservations();
    $reserveationModel->user_id = $guestModel->id;
    $reserveationModel->restaurant_id = $restaurant_id;
    $reserveationModel->floor_id = !empty($requestParam['floor_id']) ? $requestParam['floor_id'] : "";
    $reserveationModel->table_id = !empty($requestParam['table_id']) ? $requestParam['table_id'] : "";
    $reserveationModel->date = !empty($requestParam['date']) ? $requestParam['date'] : "";
    $reserveationModel->booking_start_time = !empty($requestParam['booking_time']) ? $requestParam['booking_time'] : "";
    $reserveationModel->total_stay_time = !empty($requestParam['total_stay_time']) ? $requestParam['total_stay_time'] : "";
    $reserveationModel->booking_end_time = date("H:i:s", strtotime('+' . $requestParam['total_stay_time'] . ' minutes', strtotime($requestParam['booking_time'])));
    $reserveationModel->no_of_guests = !empty($requestParam['no_of_guests']) ? $requestParam['no_of_guests'] : "";
    $reserveationModel->special_comment = !empty($requestParam['special_comment']) ? $requestParam['special_comment'] : "";
    $reserveationModel->status = Yii::$app->params['reservation_status_value']['booked'];
    $reserveationModel->role_id = Yii::$app->params['userroles']['walk_in'];
    $reserveationModel->save(false);
    $amReponseParam = $reserveationModel;

    $ssMessage = 'Guest is successfully created.';
    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
    }
    }
    } else {
    $ssMessage = 'You have not assigned any restaurant yet.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    } else {
    $ssMessage = 'Invalid Manager.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    // FOR ENCODE RESPONSE INTO JSON //
    Common::encodeResponseJSON($amResponse);
    }
     */
    public function actionAddGuest()
    {

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'first_name', 'last_name', 'email', 'contact_no');
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
        $model = Users::findOne(["id" => $snUserId, "role_id" => Yii::$app->params['userroles']['manager']]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);

                if (($gModel = Users::findOne(['email' => $requestParam['email']])) !== null) {

                    $ssMessage = 'This Email is already in user list. Please try another email';
                    $amResponse = Common::errorResponse($ssMessage);
                    Common::encodeResponseJSON($amResponse);
                }
                if (($gModel = Users::findOne(['contact_no' => $requestParam['contact_no']])) !== null) {

                    $ssMessage = 'This Contact Number is already in user list. Please try another Contact Number';
                    $amResponse = Common::errorResponse($ssMessage);
                    Common::encodeResponseJSON($amResponse);
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
                $guestModel->restaurant_id = $restaurant_id;
                $guestModel->save(false);
                $amReponseParam = $guestModel;
                $model_id = $guestModel->id;
                $amReponseParam->id = "$model_id";

                $ssMessage = 'Guest is successfully created.';
                $amResponse = Common::successResponse($ssMessage, $amReponseParam);

            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid Manager.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function :
     * Description : Get List of Floors and tables
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    /*  public function actionGetGuestsList()
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
    $arrGuestsList = Reservations::find()
    ->select(["users.id", "users.first_name", "users.last_name", "users.email", "users.address", "users.walkin_note", "users.birthdate", "users.anniversary", "users.status", "users.created_at", "total_visits" => Reservations::find()->select(["COUNT(reservations.id)"])->where("reservations.user_id = users.id AND reservations.restaurant_id = " . $restaurant_id . " AND reservations.status = '" . Yii::$app->params['reservation_status_value']['completed'] . "'"), "total_cancellations" => Reservations::find()->select(["COUNT(reservations.id)"])->where("reservations.user_id = users.id AND reservations.restaurant_id = " . $restaurant_id . " AND reservations.status = '" . Yii::$app->params['reservation_status_value']['cancelled'] . "'")])
    ->leftJoin('users', 'reservations.user_id=users.id')
    ->where("reservations.restaurant_id = '" . $restaurant_id . "'")
    ->groupBy('reservations.user_id')
    ->orderBy('users.first_name,users.last_name');

    $countQuery = clone $arrGuestsList;
    $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 1]);
    $totalCount = $pages->totalCount;
    for ($i = 0; $i < $totalCount; $i++) {
    //$links[] = "http://".$_SERVER['HTTP_HOST'].$pages->createUrl($i-1);
    $page_no[] = $i;
    }

    $models = $arrGuestsList->offset((isset($requestParam['page_no']) && !empty($requestParam['page_no'])) ? $requestParam['page_no'] : $pages->offset)
    ->limit($pages->limit)
    ->asArray()
    ->all();
    if (!empty($models)) {
    foreach ($models as $key => $guest) {
    $result[] = array_map('strval', $guest);
    }
    $amReponseParam['guest_list'] = $result;
    $amReponseParam['pages'] = $page_no;
    $ssMessage = 'Guest List';
    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

    } else {
    $ssMessage = 'No guests found for your restaurant';
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
    }*/

    /*
     * Function :
     * Description : Get List of Floors and tables
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionGetGuestsList()
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
                Common::checkRestaurantIsDeleted($restaurant_id);

                $date = date("Y-m-d H:i:s");
                $arrGuestsList = Users::find()->select(["users.id", "users.first_name", "users.last_name", "users.email", "users.address", "users.contact_no", "users.walkin_note", "users.birthdate", "users.anniversary", "users.status",
                    /* "total_visits" => Reservations::find()->select(["COUNT(reservations.id)"])->where("reservations.user_id = users.id AND reservations.restaurant_id = " . $restaurant_id . " AND reservations.status = '" . Yii::$app->params['reservation_status_value']['completed'] . "'"),
                "total_cancellations" => Reservations::find()->select(["COUNT(reservations.id)"])->where("reservations.user_id = users.id AND reservations.restaurant_id = " . $restaurant_id . " AND reservations.status = '" . Yii::$app->params['reservation_status_value']['cancelled'] . "'")*/])
                    ->where("role_id = '" . Yii::$app->params['userroles']['walk_in'] . "' AND status = '" . Yii::$app->params['user_status_value']['active'] . "' AND restaurant_id = '" . $restaurant_id . "' AND users.updated_at BETWEEN '" . $requestParam['date'] . "' AND '" . $date . "'")
                    ->orderBy('first_name,last_name');
                /*->asArray()
                ->all();*/
                $countQuery = clone $arrGuestsList;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 20]);

                /* $totalCount = $pages->totalCount;
                for ($i = 0; $i < $totalCount; $i++) {
                //$links[] = "http://".$_SERVER['HTTP_HOST'].$pages->createUrl($i-1);
                $page_no[] = $i;
                }
                 */
                $models = $arrGuestsList->offset((isset($requestParam['page_no']) && !empty($requestParam['page_no'])) ? $requestParam['page_no'] : $pages->offset)
                    ->limit($pages->limit)
                    ->asArray()
                    ->all();
                $amReponseParam['sync_datetime'] = $date;
                $amReponseParam['guest_list'] = [];
                if (!empty($models)) {

                    foreach ($models as $key => $guest) {
                        $result[] = array_map('strval', $guest);
                    }
                    $amReponseParam['guest_list'] = $result;
                    // $amReponseParam['pages'] = $page_no;
                    $ssMessage = 'Guest List';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                } else {
                    $ssMessage = 'Guest List';
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

    /*
     * Function :
     * Description : Get List of reservations of guest
     * Request Params :'user_id','auth_token',guest_id
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionGetGuestReservationsHistory()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'guest_id');
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

                $arrGuestsReservations = Reservations::find()->select(["reservations.id", "reservations.date", "reservations.booking_start_time", "reservations.booking_end_time", "reservations.total_stay_time", "reservations.no_of_guests", "reservations.pickup_drop", "reservations.pickup_location", "reservations.pickup_time", "reservations.drop_location", "reservations.drop_time", "reservations.tag_id", "reservations.special_comment", "reservations.status", "reservations.role_id", "reservations.created_at", "reservations.updated_at"])->where("restaurant_id = '" . $restaurant_id . "'   AND user_id = '" . $requestParam['guest_id'] . "'")->orderBy('created_at DESC')->asArray()->all();
                $amReponseParam['total_visits'] = 0;
                $amReponseParam['total_cancellations'] = 0;
                if (!empty($arrGuestsReservations)) {
                    $i = $j = 0;
                    foreach ($arrGuestsReservations as $key => $reservations) {
                        if ($reservations['status'] == Yii::$app->params['reservation_status_value']['booked']) {
                            $i++;

                        } else if ($reservations['status'] == Yii::$app->params['reservation_status_value']['cancelled']) {
                            $j++;
                        }
                        $result[] = array_map('strval', $reservations);
                    }
                    $amReponseParam['total_visits'] = $i;
                    $amReponseParam['total_cancellations'] = $j;

                    $amReponseParam['reservations_history'] = $result;
                    $ssMessage = 'Guest Reservations History';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                } else {
                    $amReponseParam['reservations_history'] = [];
                    $ssMessage = 'Guest Reservations History';
                    $amResponse = Common::successResponseBlank($ssMessage, $amReponseParam);
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
