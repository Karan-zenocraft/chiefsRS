<?php
namespace frontend\models;

use common\components\Common;
use common\models\EmailFormat;
use common\models\Users;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

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
    public $confirm_password;
    public $contact_no;
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
            ['confirm_password', 'required'],
            ['contact_no', 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['password', 'string', 'min' => 6],
            [['contact_no'], 'integer'],
            ['contact_no', 'is10NumbersOnly'],
            ['contact_no', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This Contact No. address has already been taken.'],
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
            if (!empty($this->contact_no)) {
                $user->contact_no = $this->contact_no;
            }

            $user->generateAuthKey();
            $email_verify_link = Url::to(['site/email-verify', 'verify' => base64_encode($user->verification_code), 'e' => base64_encode($user->email)], true);
            if ($user->save()) {
                ///////////////////////////////////////////////////////////
                //Get email template into database for forgot password
                $emailformatemodel = EmailFormat::findOne(["title" => 'user_registration', "status" => '1']);
                if ($emailformatemodel) {
                    $frontendLoginURL = Url::to(['site/index'], true);
                    //create template file
                    $AreplaceString = array('{password}' => $this->password, '{username}' => $this->first_name . " " . $this->last_name, '{email}' => $this->email, '{loginurl}' => $frontendLoginURL, '{email_verify_link}' => $email_verify_link);

                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

                    //send email for new generated password
                    Common::sendMailToUser($this->email, Yii::$app->params['adminEmail'], $emailformatemodel->subject, $body);

                }
                return $user;
            }
        } else {
            // HERE YOU CAN PRINT THE ERRORS OF MODEL
            $data = $this->getErrors();
            if (!empty($data['email'])) {
                Yii::$app->session->setFlash('message', $data['email'][0]); // its dislplays error msg on your form
            }
            if (!empty($data['contact_no'])) {
                Yii::$app->session->setFlash('message', $data['contact_no'][0]); // its dislplays error msg on your form
            }
        }

        return null;
    }
    public function is10NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
            $this->addError($attribute, 'Invalid contact Number.');
        }
    }

}
