<?php
namespace frontend\models;
use Yii;
use common\components\Common;
use common\models\Users;
use common\models\EmailFormat;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    public $password_reset_token;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\Users',
                'filter' => ['status' => Users::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Users::findOne([
            'status' => Users::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
        if ($user) {

           $snNewPassword = common::generatepassword();
           $user->password = md5($snNewPassword);
          // p($user->password);
           $user->save();
            if ($user->save()) {
                $emailformatemodel = EmailFormat::findOne(["title"=>'forgot_password',"status"=>'1']);
                if($emailformatemodel){
                    
                    //create template file
                    $AreplaceString = array('{password}' => $snNewPassword, '{username}' => $user->first_name, '{email}' => $user->email);
                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

                    //send email for new generated password
                   $status= Common::sendMail($user->email,Yii::$app->params['adminEmail'] , $emailformatemodel->subject,$body );
                   return $status;
                 }
            }

        }
    }
}