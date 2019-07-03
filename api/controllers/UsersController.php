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
use backend\controllers\SiteController;
use common\models\UserActivities;
use common\models\EmailFormat;
use common\models\Reservations;
/**
 * MainController implements the CRUD actions for APIs.
 */
class UsersController extends \yii\base\Controller
{
    /*
     * Function : Login()
     * Description : The Restaurant's manager can login from application.
     * Request Params :Email address and password.
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionLogin() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_email', 'password', 'device_id');
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );
    

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        if ( ( $model = Users::findOne( ['email' => $requestParam['user_email'], 'password' => md5( $requestParam['password'] )] ) ) !== null ) {
        
            if ( ( $modell = Users::findOne( ['email' => $requestParam['user_email'], 'password' => md5( $requestParam['password'] ),'role_id' => [Yii::$app->params['userroles']['super_admin'],Yii::$app->params['userroles']['admin'],Yii::$app->params['userroles']['supervisor'],Yii::$app->params['userroles']['customer']]] ) ) !== null ) {
                $ssMessage  = ' You are not authorize to login.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
            else if ( ( $model1 = Users::findOne( ['email' => $requestParam['user_email'], 'password' => md5( $requestParam['password'] ), 'status' => "0"] ) ) !== null ) {
                $ssMessage  = ' User has been deactivated. Please contact admin.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
            else {
                if ( ( $device_model = DeviceDetails::findOne( ['type' => "1", 'user_id' => $model->id] ) ) === NULL ) {
                    $device_model = new DeviceDetails;
                }

                $device_model->setAttributes( $amData['request_param'] );
                $device_model->device_tocken = $requestParam['device_id'];
                $device_model->type          = "1";
                $device_model->user_id        = $model->id;
              //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                $device_model->save( false );
                $ssAuthToken = Common::generateToken( $model->id );
                $model->auth_token = $ssAuthToken;
                $model->save( false );

                $ssMessage                                = 'successfully login.';
                $amReponseParam['user_email']             = $model->email;
                $amReponseParam['user_id']                = $model->id;
                $amReponseParam['first_name']             = $model->first_name;
                $amReponseParam['last_name']              = $model->last_name;
                $amReponseParam['address']         = !empty( $model->address ) ? $model->address : "";
               // $amReponseParam['contact_no']                  = $model->contact_no;
                $amReponseParam['device_token']           = $device_model->device_tocken;
                $amReponseParam['auth_token']             = $ssAuthToken;
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid email OR password.';
            $amResponse = Common::errorResponse( $ssMessage );
        }

        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : SignUp()
     * Description : new user singup.
     * Request Params : irst_name,last_name,email address,contact_no
     * Response Params : user_id,firstname,email,last_name, email,status
     * Author : Rutusha Joshi
     */

    public function actionSignUp() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'first_name', 'last_name', 'user_email', 'password', 'device_id', 'device_type', 'country_code', 'phone', 'birth_date', 'gender' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        $requestFileparam = $amData['file_param'];

        if ( empty( $requestParam['user_id'] ) ) {
            if ( !empty( Users::findOne( ["email" => $requestParam['user_email']] ) ) ) {
                $amResponse = Common::errorResponse( "This Email id is already registered." );
                Common::encodeResponseJSON( $amResponse );
            }
            if ( !empty( Users::findOne( ["phone" => $requestParam['phone']] ) ) ) {
                $amResponse = Common::errorResponse( "Phone you entered is already registered by other user." );
                Common::encodeResponseJSON( $amResponse );
            }
            $model = new Users;
        } else {
            $snUserId = $requestParam['user_id'];
            $model = Users::findOne( ["id" => $snUserId] );
            if ( !empty( $model ) ) {
                $ssEmail = $model->email;
                $modelUser = Users::find()->where( "id != '" . $snUserId . "' AND email = '" . $requestParam['user_email'] . "'" )->all();
                if ( !empty( $modelUser ) ) {
                    $amResponse = Common::errorResponse( "Email you entered is already registred by other user." );
                    Common::encodeResponseJSON( $amResponse );
                }
                $modelUserr = Users::find()->where( "id != '" . $snUserId . "' AND phone = '" . $requestParam['phone'] . "'" )->all();
                if ( !empty( $modelUserr ) ) {
                    $amResponse = Common::errorResponse( "Phone you entered is already registered by other user." );
                    Common::encodeResponseJSON( $amResponse );
                }
            }
        }

        $SnRandomNumber = rand( 1111, 9999 );
        $Textmessage    = "Your verification code is : " . $SnRandomNumber;
        // Common::sendSms( $Textmessage, "$requestParam[phone]" );
        // Database field
        $model->first_name             = $requestParam['first_name'];
        $model->last_name              = $requestParam['last_name'];
        $model->email                  = $requestParam['user_email'];
        $model->password               = md5( $requestParam['password'] );
        $model->address_line_1         = !empty( $requestParam['address_line_1'] ) ? $requestParam['address_line_1'] : "";
        $model->country_code           = $requestParam['country_code'];
        $model->phone                  = Common::clean_special_characters( $requestParam['phone'] );
        $model->gender                 = Yii::$app->params['gender'][$requestParam['gender']];
        $model->verification_code      = $SnRandomNumber;
        $model->birth_date             = date( "Y-m-d", strtotime( $requestParam['birth_date'] ) );
        $model->user_initial_longitude = !empty( $requestParam['user_initial_longitude'] ) ? $requestParam['user_initial_longitude'] : "";
        $model->user_initial_latitude  = !empty( $requestParam['user_initial_latitude'] ) ? $requestParam['user_initial_latitude'] : "";
        $model->event_radious_range    = !empty( $requestParam['event_radious_range'] ) ? $requestParam['event_radious_range'] : 20;
        $model->role_id                = Yii::$app->params['userroles']['application_users'];
        $model->notification_status    = Yii::$app->params['notification_status']['active'];
        $model->created_at             = date( 'Y-m-d H:i:s' );
        $model->updated_at             = date( 'Y-m-d H:i:s' );
        $model->status                 = Yii::$app->params['status']['active'];
        $ssAuthToken                   = Common::generateToken( $model->id );
        $model->auth_token             = $ssAuthToken;


        if ( isset( $requestFileparam['image']['name'] ) ) {

            $model->user_image = UploadedFile::getInstanceByName( 'image' );
            $Modifier          = md5( ( $model->user_image ) );
            $OriginalModifier  = $Modifier . rand( 11111, 99999 );
            $Extension         = $model->user_image->extension;
            $model->user_image->saveAs( Yii::$app->params['upload_user_image'] . $OriginalModifier . '.' . $model->user_image->extension );
            $model->user_image = $OriginalModifier . '.' . $Extension;
        }
        if ( $model->save( false ) ) {
            // Device Registration
            if ( ( $device_model = Devicedetails::findOne( [/*'gcm_id' => $amData['request_param']['gcm_registration_id'], */'type' => $amData['request_param']['device_type'], 'userid' => $model->id] ) ) === NULL ) {
                $device_model = new Devicedetails;
            }

            $device_model->setAttributes( $amData['request_param'] );
            $device_model->device_tocken = $requestParam['device_id'];
            $device_model->type          = $requestParam['device_type'];
            $device_model->gcm_id        = !empty( $requestParam['gcm_registration_id'] ) ? $requestParam['gcm_registration_id'] : "";
            $device_model->userid        = $model->id;
            $device_model->created_at    = date( 'Y-m-d H:i:s' );
            $device_model->save( false );

            ///////////////////////////////////////////////////////////
            //Get email template from database for sign up WS
            ///////////////////////////////////////////////////////////
            if ( empty( $ssEmail ) ) {
                $ssEmail = $model->email;
            }
            if ( empty( $requestParam['user_id'] ) || ( $ssEmail != $requestParam['user_email'] ) ) {
                $emailformatemodel = EmailFormat::findOne( ["title"=>'welcome', "status"=>'1'] );
                if ( $emailformatemodel ) {

                    //create template file
                    $AreplaceString = array( '{password}' => $requestParam['password'], '{username}' => $model->first_name." ".$model->last_name, '{email}' => $model->email );

                    $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );
                    $ssSubject = $emailformatemodel->subject;
                    //send email for new generated password
                    $ssResponse = Common::sendMail( $model->email, Yii::$app->params['adminEmail'], $ssSubject, $body );

                }
            }

            $ssMessage                                = 'You are successfully registered.';
            $amReponseParam['user_email']             = $model->email;
            $amReponseParam['user_id']                = $model->id;
            $amReponseParam['first_name']             = $model->first_name;
            $amReponseParam['last_name']              = $model->last_name;
            $amReponseParam['address_line_1']         = !empty( $model->address_line_1 ) ? $model->address_line_1 : "";
            $amReponseParam['country_code']           = $model->country_code;
            $amReponseParam['phone']                  = $model->phone;
            $amReponseParam['verification_code']      = $model->verification_code;
            $amReponseParam['birth_date']             = date( "d-m-Y", strtotime( $model->birth_date ) );
            $amReponseParam['gender']                 = Yii::$app->params['gender_value'][$model->gender];
            $amReponseParam['user_initial_longitude'] = !empty( $model->user_initial_longitude ) ? $model->user_initial_longitude : "";
            $amReponseParam['user_initial_latitude']  = !empty( $model->user_initial_latitude ) ? $model->user_initial_latitude : "";
            $amReponseParam['event_radious_range']    = !empty( $model->event_radious_range ) ? $model->event_radious_range : '';
            $amReponseParam['is_mobile_verified']     = !empty( $model->is_code_verified ) && ( $model->is_code_verified > 0 ) ? $model->is_code_verified : 0;
            $amReponseParam['image']                  = !empty( $model->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$model->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $model->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
            $amReponseParam['device_token']           = $device_model->device_tocken;
            $amReponseParam['device_type']            = Yii::$app->params['device_type_value'][$device_model->type];
            $amReponseParam['gcm_registration_id']    = !empty( $device_model->gcm_id ) ? $device_model->gcm_id : "";
            $amReponseParam['auth_token']             = $ssAuthToken;

            $amResponse                               = Common::successResponse( $ssMessage, $amReponseParam );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : verifyEmail()
     * Description : email verification
     * Request Params : verification_code,user_id
     * Author : Rutusha Joshi
     */

    public function actionVerifyCode() {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'verification_code', 'user_id' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        $ssCode = $requestParam['verification_code'];

        $modelUsers = Users::findOne( ["id" => $snUserId, "verification_code" => $ssCode] );
        if ( !empty( $modelUsers ) ) {
            $modelUsers->is_code_verified = 1;
            $modelUsers->save( false );
            $amResponseData = [
            'is_mobile_verified' => '1',
            ];
            $amResponse = Common::successResponse( "Code verified successfully.", $amResponseData );
        } else {
            $amResponseData = [
            'is_mobile_verified' => '0',
            ];
            $amResponse = Common::successResponse( "Invalid verification code.", $amResponseData );
        }
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : ResendVerificationCode()
     * Description : Re send verification code
     * Request Params : 'user_id', 'phone','country_code'
     * Author : Rutusha Joshi
     */

    public function actionResendVerificationCode() {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'phone' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        $snUserId     = $requestParam['user_id'];
        $ssPhone      = $requestParam['phone'];

        $modelUsers = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $modelUsers ) ) {
            $SnRandomNumber = rand( 1111, 9999 );
            $Textmessage    = "Your verification code is : " . $SnRandomNumber;
            // Common::sendSms( $Textmessage, "$requestParam[phone]" );
            $modelUsers->verification_code = $SnRandomNumber;
            $modelUsers->save( false );
            $amResponseData['Verification_code'] = $modelUsers->verification_code;
            $amResponse = Common::successResponse( "Code sent successfully.", $amResponseData );
        }   else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : ChangePassword()
     * Description : user can change password
     * Request Params : user_id,old_password, new_password
     * Response Params : success or error message
     * Author : Rutusha Joshi
     */

    public function actionChangePassword() {


        $amData = Common::checkRequestType();

        $amResponse       = array();
        $ssMessage        = '';
        // Check required validation for request parameter.
        $amRequiredParams = array( 'old_password', 'new_password', 'user_id' );

        $amParamsResult = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {

            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        // Check User Status
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        if ( ( $model = Users::findOne( ['id' => $requestParam['user_id'], 'password' => md5( $requestParam['old_password'] ), 'status' => '1'] ) ) !== null ) {

            $model->password = md5( $amData['request_param']['new_password'] );
            if ( $model->save() ) {
                $ssMessage                    = 'Your password has been changed successfully.';
                $amReponseParam['user_id']    = $model->id;
                $amReponseParam['user_email'] = $model->email;
                $amResponse                   = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Old Password is wrong';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : ForgotPassword()
     * Description : if user can forgot passord so send password by mail.
     * Request Params : email,auth_token
     * Response Params : success or error message
     * Author : Rutusha Joshi
     */

    public function actionForgotPassword() {

        $amData     = Common::checkRequestType();
        $amResponse = array();

        $ssMessage        = '';
        // Check required validation for request parameter.
        $amRequiredParams = array('user_email');

        $amParamsResult = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        // Check User Status


        if ( ( $omUsers = Users::findOne( ['email' => $requestParam['user_email'], 'status' => Yii::$app->params['user_status_value']['active']] ) ) !== null ) {

            // $ssEmail = 'rutusha@inheritx.com';
            if (!Users::isPasswordResetTokenValid($omUsers->password_reset_token)) {
            $token = $omUsers->generatePasswordResetToken();
            $omUsers->password_reset_token = $token;
            if (!$omUsers->save()) {
                return false;
            }
        }
        $resetLink = Yii::$app->params['root_url']."site/reset-password?token=".$omUsers->password_reset_token;

          $emailformatemodel = EmailFormat::findOne(["title"=>'reset_password',"status"=>'1']);
                if($emailformatemodel){
                    
                    //create template file
                    $AreplaceString = array('{resetLink}' => $resetLink, '{username}' => $omUsers->first_name);
                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

                    //send email for new generated password
                  $mail =  Common::sendMailToUser($omUsers->email,Yii::$app->params['adminEmail'] , $emailformatemodel->subject,$body );
                }
            if ( $mail == 1 ) {
                $amReponseParam['user_email'] = $omUsers->email;
                $ssMessage                    = 'Email has been sent successfully please check your email. ';
                $amResponse                   = Common::successResponse( $ssMessage, $amReponseParam );
            }
            else {
                $ssMessage  = 'Email could not be sent successfully try again later.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
        }
        else {
            $ssMessage  = 'Please enter valid email address which is provided during sign up.';
            $amResponse = Common::errorResponse( $ssMessage );
        }



        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : Logout()
     * Description : Log out
     * Request Params : user_id,auth_token
     * Response Params :
     * Author : Rutusha Joshi
     */

    // For Geting Daily data by date
    public function actionLogout() {
        $amData           = Common::checkRequestType();
        $amResponse       = array();
        $ssMessage        = '';
        $amRequiredParams = array('user_id', 'device_id');
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );
        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        if ( ( $device_model = Devicedetails::findOne( ['device_tocken' => $amData['request_param']['device_id'],'userid' => $requestParam['user_id']] ) ) !== NULL ) {
            $device_model->delete();
            $ssMessage      = 'Logout successfully';
            $amResponse     = Common::successResponse( $ssMessage, $amReponseParam = '' );
        }
        else {
            $ssMessage  = 'Your deivce token is invalid.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        Common::encodeResponseJSON( $amResponse );
    }

    // User Status Match. Either its deactive or Deleted
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
    /*
     * Function : EditProfile()
     * Description : Edit User Profile
     * Request Params : university_id,first_name,last_name,email address,contact_no
     * Response Params : user_id,firstname,email,last_name, email,status,created_at
     * Author : Rutusha Joshi
     */

    public function actionEditProfile() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'first_name', 'last_name','email','address', 'contact_no');
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
         if ( !empty( $requestParam['user_id'] ) ) {
        
            if ( !empty( Users::find()->where("email = '".$requestParam['email']."' AND id != '".$requestParam['user_id']."'")->one())){
                $amResponse = Common::errorResponse( "This Email id is already registered." );
                Common::encodeResponseJSON( $amResponse );
            }
            if ( !empty( Users::find()->where("contact_no = '".$requestParam['contact_no']."' AND id != '".$requestParam['user_id']."'")->one())){
            
                $amResponse = Common::errorResponse( "Contact Number you entered is already registered by other user." );
                Common::encodeResponseJSON( $amResponse );
            }

        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {

            // Database field
            $model->first_name             = $requestParam['first_name'];
            $model->last_name              = $requestParam['last_name'];
            $model->address                = !empty( $requestParam['address'] ) ? $requestParam['address'] : "";
            $model->email                  = !empty( $requestParam['email'] ) ? $requestParam['email'] : "";
            $model->contact_no = !empty( $requestParam['contact_no'] ) ? $requestParam['contact_no'] : '';

            if ( $model->save( false ) ) {
                $ssMessage                                = 'Your profile has been updated successfully.';

                $amReponseParam['user_email']             = $model->email;
                $amReponseParam['user_id']                = $model->id;
                $amReponseParam['first_name']             = $model->first_name;
                $amReponseParam['last_name']              = $model->last_name;
                $amReponseParam['address']                = !empty( $model->address ) ? $model->address : "";
                $amReponseParam['contact_no']           = $model->contact_no;
                $amReponseParam['auth_token']             = !empty( $model->auth_token ) ? $model->auth_token : "";
                $amResponse                               = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
    }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }
    /*
     * Function : GetUserDetails()
     * Description : Get User Details
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionGetUserDetails() {
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
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            // Device Registration
            $ssMessage                                = 'User Profile Details.';

            $amReponseParam['user_email']             = $model->email;
            $amReponseParam['user_id']                = $model->id;
            $amReponseParam['first_name']             = $model->first_name;
            $amReponseParam['last_name']              = $model->last_name;
            $amReponseParam['address']         = $model->address;
            $amReponseParam['contact_no']           = $model->contact_no;

            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

       /*
     * Function : Reservations()
     * Description : Get Reservations
     * Request Params : user_id
     * Response Params : reservation details
     * Author : Rutusha Joshi
     */

    public function actionGetReservationList() {
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
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){
                $reservations = Reservations::find()->where(['restaurant_id'=>$restaurant_id])->asArray()->all();
            // Device Registration
                $ssMessage                                = 'User Reservations Details.';

                $amReponseParam['reservations']             = $reservations;

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

    /*
     * Function :
     * Description : Reset Badge Count
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionResetBadgeCount() {

        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {

            $oModelUser->badge_count = 0;
            $oModelUser->save( false );
            $ssMessage  = "Badge count updated successfully.";
            $amResponse = Common::successResponse( $ssMessage );
        }else {
            $ssMessage  = 'Invalid User.';
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
       public function actionGetFloors(){
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
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){
                $layouts = RestaurantLayout::find()->where(['restaurant_id'=>$restaurant_id,'status'=>Yii::$app->params['user_status_value']['active'])->asArray()->all();
                if(!empty($layouts)){
                    $ssMessage                                = 'User Floors Details.';

                    $amReponseParam['Floors']             = $layouts;

                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }else{
                    $ssMessage  = 'There is no any floors added to your restaurant';
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
