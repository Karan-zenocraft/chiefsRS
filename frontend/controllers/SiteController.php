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

/**
 * Site controller
 */
class SiteController extends FrontCoreController
{
    public function beforeAction($action) {

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function actions()
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
    }

    public function actionIndex()
    {   
        $this->layout = "landingpage";

        $model = new LoginForm();
        $model2 = new SignupForm();
       
        if(isset($_REQUEST['hidden']) && !empty($_REQUEST['hidden']) && ($_REQUEST['hidden'] == 'login')){
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(\Yii::$app->urlManager->createUrl(['site/index']));
        }
        }
        if(isset($_REQUEST['hidden']) && !empty($_REQUEST['hidden']) && ($_REQUEST['hidden'] == 'signup')){
             if ($model2->load(Yii::$app->request->post())) {
            if ($user = $model2->signup()) {


                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        }
        return $this->render('frontpage',[
            "model" => $model,
            "model2" => $model2
        ]);
    }

    public function actionLogin()
    {
       /* if (!\Yii::$app->user->isGuest) {            
            return $this->redirect(\Yii::$app->urlManager->createUrl(['site/index']));
        }
*/
         if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(\Yii::$app->urlManager->createUrl(['site/index']));
        } 
        return $this->render('login', [
                'model' => $model,
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash( 'success', Yii::getAlias( '@user_add_message' ) );
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
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

        if(isset($_REQUEST['search_restaurant']) && !empty($_REQUEST['search_restaurant'])){
            
            $snRestaurantsArr = Restaurants::find()->where("name LIKE '".$_REQUEST['search_restaurant']."%' AND status = '".Yii::$app->params['user_status_value']['active']."'")->all();
        }else{
           $snRestaurantsArr = Restaurants::find(["status"=>Yii::$app->params['user_status_value']['active']])->all();
        }
        return $this->render('restaurants', [
            'Restaurants' => $snRestaurantsArr,
        ]);
    }
}
