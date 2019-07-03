<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontCoreController;
use yii\web\Response;
use common\models\Restaurants;
use common\models\RestaurantLayout;
use common\models\RestaurantMenu;
use common\models\RestaurantTables;
use common\models\RestaurantWorkingHours;
use common\models\RestaurentMealTimes;
use common\models\MenuCategories;
use common\models\RestaurantsGallery;
use yii\data\Pagination;
use common\models\ContactUs;
use common\models\EmailFormat;
use common\components\Common;


/**
 * Site controller
 */
class SiteController extends FrontCoreController
{
    public function beforeAction($action) {

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
 
  /*  public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }*/

    public function actionIndex()
    {   
        $this->layout = "landingpage";

        $model = new LoginForm();
        $model2 = new SignupForm();
       
        if(isset($_REQUEST['hidden']) && !empty($_REQUEST['hidden']) && ($_REQUEST['hidden'] == 'login')){
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(isset($_GET['rid']) && !empty($_GET['rid'])){
                return $this->redirect(\Yii::$app->urlManager->createUrl(['reservations/create','rid'=>$_GET['rid']]));
            }else{
                return $this->redirect(\Yii::$app->urlManager->createUrl(['site/restaurants']));    
            }           
        }
        }
        if(isset($_REQUEST['hidden']) && !empty($_REQUEST['hidden']) && ($_REQUEST['hidden'] == 'signup')){
             if ($model2->load(Yii::$app->request->post())) {
            if ($user = $model2->signup()) {


                if (Yii::$app->getUser()->login($user)) {
                      if(isset($_GET['rid']) && !empty($_GET['rid'])){
                        return $this->redirect(\Yii::$app->urlManager->createUrl(['reservations/create','rid'=>$_GET['rid']]));
                      }else{
                        return $this->redirect(\Yii::$app->urlManager->createUrl(['site/restaurants']));    
            }  
                }
            }
        }

        }
        return $this->render('frontpage',[
            "model" => $model,
            "model2" => $model2
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $this->layout = "forgot_password";
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success',Yii::getAlias('Check your email for Reset Password.'));
                return $this->goHome();
            }else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        $this->layout = "forgot_password";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionRestaurants(){
        $this->layout = "restaurant_list";
        
        if(isset($_REQUEST['search_restaurant']) && !empty($_REQUEST['search_restaurant'])){
            
            $query = Restaurants::find()->where("name LIKE '".$_REQUEST['search_restaurant']."%' AND status = '".Yii::$app->params['user_status_value']['active']."'");
            $snRestaurantsArr = Restaurants::find()->where("name LIKE '".$_REQUEST['search_restaurant']."%' AND status = '".Yii::$app->params['user_status_value']['active']."'")->all();
        }else{
            $query = Restaurants::find()->where(["status"=>Yii::$app->params['user_status_value']['active']]);
           $snRestaurantsArr = Restaurants::find()->where(["status"=>Yii::$app->params['user_status_value']['active']])->all();
        }
         $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize'=>9]);
             $models = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('restaurants', [
            'Restaurants' => $snRestaurantsArr,
            'models' => $models,
            'pagination' => $pagination,
        ]);
    }

     public function actionRestaurantDetails($rid){

        $this->layout = "detail";
        
        if(isset($rid) && !empty($rid)){
            
            $snRestaurantsDetail = Restaurants::find()->where(['id'=>$rid])->one();
            $snRestaurantMenuCategoryArr = MenuCategories::find()->where(["status"=>"1"])->all();
            $snRestaurantMenusArr = RestaurantMenu::find()->where(['restaurant_id'=>$rid,'status'=>"1"])->all();
            $query = RestaurantsGallery::find()->where(['restaurant_id'=>$rid,'status'=>"1"]);
             $snRestaurantgallerysArr = RestaurantsGallery::find()->where(['restaurant_id'=>$rid,'status'=>"1"])->all();
             $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize'=>3]);
             $models = $query->offset($pagination->offset)
             ->limit($pagination->limit)
             ->all();
            $snRestaurantWorkingHours = $snRestaurantsDetail->getRestaurantWorkingHours();
            $snRestaurantWorkingHoursArr = $snRestaurantWorkingHours->all();
         //   p($snRestaurantWorkingHoursArr);
            $snRestaurantMealTimes = $snRestaurantsDetail->getRestaurentMealTimes();
            $snRestaurantMealTimesArr = $snRestaurantMealTimes->all();

         /*   $snRestaurantLayoutsArr = $snRestaurantsDetail->getRestaurantLayouts();
            $snRestaurantTablesArr = $snRestaurantsDetail->getRestaurantTables();*/

            //p($snRestaurantsDetail);
        }
        return $this->render('restaurant_detail', [
            'rid' => $rid,
            'snRestaurantsDetail' => $snRestaurantsDetail,
            'snRestaurantMenuCategoryArr' => $snRestaurantMenuCategoryArr,
            'snRestaurantMenusArr' => $snRestaurantMenusArr,
            'snRestaurantMealTimesArr' => $snRestaurantMealTimesArr,
            'snRestaurantWorkingHoursArr' => $snRestaurantWorkingHoursArr,
            'snRestaurantgallerysArr' => $snRestaurantgallerysArr,
            'models' => $models,
            'pagination' => $pagination,
        ]);
    }
      public function actionContactUs()
    {
      if(isset($_POST) && !empty($_POST)){
       $name = $_POST['ContactUs']['name'];
       $fromEmail = $_POST['ContactUs']['email'];
       $message = $_POST['ContactUs']['message'];
       $model = new ContactUs();
       $model->name = $name;
       $model->email = $fromEmail;
       $model->message = $message;
       $model->save(false);
       
            ///////////////////////////////////////////////////////////
            //Get email template into database for forgot password
            $emailformatemodel = EmailFormat::findOne( ["title"=>'contact_us', "status"=>'1'] );
            if ( $emailformatemodel ) {
                //create template file
                $AreplaceString = array('{name}' => $name,'{message}'=>$message);
                
                $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );
                
                //send email
                $mail = Common::sendMailToUser(Yii::$app->params['adminEmail'],$fromEmail, $emailformatemodel->subject, $body );
                return $mail;
            }
       }
      }
    
}
