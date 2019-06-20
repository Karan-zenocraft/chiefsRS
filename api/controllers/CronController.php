<?php

namespace api\controllers;

use Yii;
use yii\helpers\Json;
use yii\db\Query;
/* USE COMMON MODELS */
use common\components\Common;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\DateTime;
use common\models\Reservations;
use common\models\Devicedetails;

/**
 * MainController implements the CRUD actions for APIs.
 */
class CronController extends \yii\base\Controller
{
   public function actionCompleteReservation(){

   	$snReservationsArr = Reservations::find()->where("status IN "Yii::$app->params['reservation_status_value']['booked'].",".Yii::$app->params['reservation_status_value']['seated'].") AND date = CURDATE() AND booking_end_time = TIME_FORMAT(CURRENT_TIME(),\"H:i:00\")")->asArray()->all(); 
   	p($snReservationsArr);
   	if(!empty($snReservationsArr)){
   		foreach ($snReservationsArr as $key => $event) {
   			$snEventParticipants = EventParticipants::find()->where(['event_id'=> $event['id'],'participant_status'=> Yii::$app->params['participant_status']['active']])->asArray()->all();
   			if(!empty($snEventParticipants)){
   				foreach ($snEventParticipants as $key => $participant) {
   					$snDeviceDetails = Devicedetails::find()->where(["userid"=>$participant['user_id']])->one();
   					$snDeviceToken = $snDeviceDetails['device_tocken'];
   					$notificationArray = [
                              "device_token"   => $snDeviceToken,
                              "message"               => "Your session will start in next hour.",
                              "notification_type"     => 'Before Hour Notification',
                              "user_id"   => $participant['user_id'],
                              ];    
			          if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64') {

			              Common::SendNotification( $notificationArray );
			          }

   				}
   			}
   		}
   	}

   		/*$ssMessage  = " updated successfully.";
        $amResponse = Common::successResponse( $ssMessage );
        Common::encodeResponseJSON( $amResponse );*/
   }
}
