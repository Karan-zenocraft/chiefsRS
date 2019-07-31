<?php

namespace api\controllers;

use common\components\Common;
use common\models\BookReservations;
use common\models\Reservations;
use common\models\RestaurantTables;
use common\models\Tags;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\helpers\ArrayHelper;
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
                $tagslist = Tags::find()->where("status = '" . Yii::$app->params['user_status_value']['active'] . "' AND updated_at > '" . $requestParam['date'] . "' ")->asArray()->all();
                foreach ($tagslist as $key => $tag) {
                    $image = Yii::$app->params['root_url'] . "uploads/" . $tag['image'];
                    $tagslist[$key]['image'] = $image;
                }

                $ssMessage = 'Tags List';
                $amResponse = Common::successResponse($ssMessage, $tagslist);
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
                        ->where("date = '" . $reservation->date . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND (
                                        (booking_start_time >= '" . $reservation->booking_start_time . "'
                                            AND booking_end_time <= '" . $reservation->booking_end_time . "')
                                        OR (('" . $reservation->booking_start_time . "' > booking_start_time) AND ('" . $reservation->booking_start_time . "' < booking_end_time))
                                        OR (('" . $reservation->booking_end_time . "' > booking_start_time) AND ('" . $reservation->booking_end_time . "' < booking_end_time)))")->asArray()->all();

                    if (!empty($matchReservationValues)) {
                        foreach ($matchReservationValues as $match) {
                            $match_tables[] = BookReservations::find()->where("reservation_id = '" . $match['id'] . "' AND floor_id = '" . $requestParam['floor_id'] . "' AND table_id IN ('" . $requestParam['table_id'] . "')")->asArray()->all();
                        }
                        if (!empty($match_tables) && count($match_tables) > 0) {
                            $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);

                        }
                    } else {
                        $capacity = RestaurantTables::find()->select(["SUM(max_capacity) as max_capacity"])->where("id IN (" . $requestParam['table_id'] . ")")->asArray()->all();

                        if ($capacity[0]['max_capacity'] < $reservation->no_of_guests) {

                            $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);

                        } else {
                            $table_array = explode(",", $requestParam['table_id']);
                            foreach ($table_array as $key => $oneTable) {
                                $bookReservation = new BookReservations;
                                $bookReservation->reservation_id = $requestParam['reservation_id'];
                                $bookReservation->floor_id = $requestParam['floor_id'];
                                $bookReservation->table_id = $oneTable;
                                $bookReservation->created_at = date('Y-m-d H:i:s');
                                $bookReservation->created_at = date('Y-m-d H:i:s');
                                $bookReservation->save(false);

                                $reservation->status = Yii::$app->params['reservation_status_value']['booked'];
                                $reservation->save();
                            }
                            $reservation->floor_id = $requestParam['floor_id'];
                            $reservation->table_id = $requestParam['table_id'];
                            $amReponseParam = ArrayHelper::toArray($reservation);
                            $ssMessage = 'Table booked successfully.';
                            $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                            /*}*/

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
