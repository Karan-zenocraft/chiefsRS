<?php
namespace frontend\models;

use common\components\Common;
use common\models\EmailFormat;
use common\models\Users;
use Yii;
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
                'message' => 'There is no user with such email.',
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

        if (!$user) {
            return false;
        }

        if (!Users::isPasswordResetTokenValid($user->password_reset_token)) {
            $token = $user->generatePasswordResetToken();
            $user->password_reset_token = $token;
            if (!$user->save()) {
                return false;
            }
        }
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

        $emailformatemodel = EmailFormat::findOne(["title" => 'reset_password', "status" => '1']);
        if ($emailformatemodel) {

            //create template file
            $AreplaceString = array('{resetLink}' => $resetLink, '{username}' => $user->first_name);
            $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

            //send email for new generated password
            $mail = Common::sendMailToUser($user->email, Yii::$app->params['adminEmail'], $emailformatemodel->subject, $body);
        }
        return $mail;
    }
}
