<?php

namespace api\controllers;

use common\components\Common;
use common\models\Reservations;
use common\models\Users;
use Yii;
use yii\data\Pagination;

/* USE COMMON MODELS */
use yii\helpers\ArrayHelper;
use yii\web\Controller;

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

    public function actionGetReservationList()
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
                $arrReservationsList = Reservations::find()
                    ->select(["users.id", "users.first_name", "users.last_name", "users.email", "users.address", "users.contact_no", "users.status", "users.created_at", "reservations.id as reservation_id", "reservations.floor_id", "reservations.table_id", "reservations.date", "reservations.booking_start_time", "reservations.booking_end_time", "reservations.total_stay_time", "reservations.no_of_guests", "reservations.pickup_drop", "reservations.pickup_location", "reservations.pickup_time", "reservations.drop_location", "reservations.drop_time", "reservations.tag_id", "reservations.special_comment", "reservations.role_id"])
                    ->leftJoin('users', 'reservations.user_id=users.id')
                    ->where(["reservations.restaurant_id" => $restaurant_id, "reservations.status" => Yii::$app->params['reservation_status_value']['requested'], "reservations.date" => $requestParam['date']])
                    ->orderBy('reservations.created_at');
                /*     ->asArray()
                ->all();*/
                $countQuery = clone $arrReservationsList;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 20]);
                $totalCount = $pages->totalCount;
                for ($i = 0; $i < $totalCount; $i++) {
                    //$links[] = "http://".$_SERVER['HTTP_HOST'].$pages->createUrl($i-1);
                    $page_no[] = $i + 1;
                }

                $models = $arrReservationsList->offset((isset($requestParam['page_no']) && !empty($requestParam['page_no'])) ? $requestParam['page_no'] : $pages->offset)
                    ->limit($pages->limit)
                    ->asArray()
                    ->all();
                if (!empty($models)) {
                    foreach ($models as $key => $reservation) {
                        unset($reservation['pickup_lat']);
                        unset($reservation['pickup_long']);
                        unset($reservation['drop_lat']);
                        unset($reservation['drop_long']);
                        $arrReservation[] = array_map('strval', $reservation);
                    }
                    $amReponseParam['reservations'] = $arrReservation;
                    //$amReponseParam['pages'] = $page_no;
                    $ssMessage = 'User Reservations Details.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                } else {
                    $ssMessage = 'No reservations found.';
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
     * Description : Book table for requested reservations
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionBookTable()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'reservation_id', "floor_id", "table_id");
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
                $reservation = Reservations::findOne($requestParam['reservation_id']);
                if (!empty($reservation)) {
                    $matchReservationValues = Reservations::find()
                        ->where("floor_id = '" . $requestParam['floor_id'] . "'
                                AND table_id = '" . $requestParam['table_id'] . "'
                                AND date = '" . $reservation->date . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND (
                                        (booking_start_time >= '" . $reservation->booking_start_time . "'
                                            AND booking_end_time <= '" . $reservation->booking_end_time . "')
                                        OR (('" . $reservation->booking_start_time . "' > booking_start_time) AND ('" . $reservation->booking_start_time . "' < booking_end_time))
                                        OR (('" . $reservation->booking_end_time . "' > booking_start_time) AND ('" . $reservation->booking_end_time . "' < booking_end_time)))")->asArray()->all();
                    if (!empty($matchReservationValues)) {
                        $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);
                    } else {
                        $tableDetails = $reservation->table;
                        if ($tableDetails['max_capacity'] < $reservation->no_of_guests) {

                            $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);

                        } else {
                            $reservation->floor_id = $requestParam['floor_id'];
                            $reservation->table_id = $requestParam['table_id'];
                            $reservation->status = Yii::$app->params['reservation_value_status']['booked'];
                            $reservation->save();
                            $amReponseParam = ArrayHelper::toArray($reservation);
                            $ssMessage = 'Table booked successfully.';
                            $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                        }

                    }
                } else {
                    $ssMessage = 'Please pass valid reservation_id';
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
