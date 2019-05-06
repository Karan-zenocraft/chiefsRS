<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username, $email;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    const ACTIVE_STATUS = '1';
    const CONFIRMATION_STATUS = '4';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // Email Validation
            [['email'],'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'safe'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();            
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
                //}else if (!$user || ($user->role_id != Yii::$app->params['userroles']['teachers'] && $user->role_id != Yii::$app->params['userroles']['student'])) {
            } else if (!$user) {
                $this->addError($attribute, Yii::t('app', 'Incorrect email or password.'));                        
            }else if (!$user || $user->status != self::ACTIVE_STATUS) {
                $this->addError($attribute, Yii::t('app','Your account has been deactivated, please contact to administrator.'));
            }else {
                //$user->last_login = date('Y-m-d H:i:s');
                //$user->is_logged_in = '1';
                //$user->save();
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login() {

        $duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
        if ($this->validate()) {

            if ($this->rememberMe == 1) {
                setcookie(\Yii::getAlias('site_title') . "_front_email", $this->email, time() + 3600 * 24 * 4);
                setcookie(\Yii::getAlias('site_title') . "_front_password", $this->password, time() + 3600 * 24 * 4);
            } else {
                setcookie(\Yii::getAlias('site_title') . "_front_email", false);
                setcookie(\Yii::getAlias('site_title') . "_front_password", false);
            }            
            return Yii::$app->user->login($this->getUser(), $duration);
        } else {
            return false;
        }

        /* if ($this->validate()) {
          return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
          } else {
          return false;
          } */
    }

    public function studentlogin() {
        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = Users::findByUsername($this->email);
        }
        return $this->_user;
    }

}
