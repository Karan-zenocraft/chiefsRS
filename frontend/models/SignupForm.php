<?php
namespace frontend\models;

use common\models\Users;
use yii\base\Model;
use Yii;
use common\models\EmailFormat;
use common\components\Common;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $address;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // ['username', 'filter', 'filter' => 'trim'],
            ['first_name', 'required'],
            ['last_name', 'required'],
            //['username', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This username has already been taken.'],
          //  ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
          ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            
            $user = new Users();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->email = $this->email;
            $user->role_id = "5";
            $user->password = md5($this->password);
            $user->address = $this->address;
          //  $user->generateAuthKey();
            if ($user->save()) {
                  ///////////////////////////////////////////////////////////
            //Get email template into database for forgot password
            $emailformatemodel = EmailFormat::findOne( ["title"=>'user_registration', "status"=>'1'] );
            if ( $emailformatemodel ) {
                $frontendLoginURL = Yii::$app->params['site_url'].Yii::$app->params['frontend_login_url'];

                //create template file
                $AreplaceString = array( '{password}' => $this->password, '{username}' => $this->first_name." ".$this->last_name, '{email}' => $this->email, '{loginurl}'=>$frontendLoginURL );

                $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );

                //send email for new generated password
                Common::sendMailToUser( $this->email, Yii::$app->params['adminEmail'] , $emailformatemodel->subject, $body );

            }
            return $user;
            }
        }else {
    // HERE YOU CAN PRINT THE ERRORS OF MODEL
    $data = $this->getErrors();
    Yii::$app->session->setFlash('message', $data['email'][0]);// its dislplays error msg on your form
}


        return null;
    }
}
