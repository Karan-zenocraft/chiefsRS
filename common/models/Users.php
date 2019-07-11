<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\base\Security;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

class Users extends \common\models\base\UsersBase implements IdentityInterface {

    const STATUS_ACTIVE = 1;
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
    }
    public function rules()
    {
    return [
            [['role_id', 'status','contact_no'], 'integer'],
            [['role_id','email', 'password', 'first_name','last_name','address','status','restaurant_id','contact_no'], 'required','on'=>'create'],
            [['role_id','email','first_name','last_name','address','status','contact_no'], 'required','on'=>'update'],
            [['created_at', 'updated_at','name','contact_no','walkin_note','birthdate','anniversary'], 'safe'],
            [['email'],'email'],
             ['contact_no', 'is10NumbersOnly'],
            ['email','validateEmail'],
            [['email','password', 'first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    public function validateEmail() {
        $ASvalidateemail = Users::find()->where('email = "' . $this->email . '" and id != "' . $this->id . '"')->all();
        if (!empty($ASvalidateemail)) {
            $this->addError('email', 'This email address already registered.');
            return true;
        }
    }

    public function is10NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
            $this->addError($attribute, 'Invalid contact Number.');
        }
    }


  /** 
   * @return \yii\db\ActiveQuery 
   */ 
   public function getUserProjects() 
   { 
   return $this->hasMany(UserProjects::className(), ['user_id' => 'id']); 
   } 
   public function getFullName() {
    return $this->first_name . ' ' . $this->last_name;
}

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS* */

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role',
            'email' => 'Email',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'status' => 'Status',
            'address' => 'Address', 
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'fullName' => 'Name',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['email' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {  
        return true;
        //return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === md5($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $user = new \common\models\Users;
        $user->password_reset_token = Security::generateRandomString() . '_' . time();
        return $user->password_reset_token;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
     /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

     /**
    * Get list of all QA Users
    */
    public static function QaUsersDropDownArr(){

     $snQaUsers = ArrayHelper::map( Users::find()->where(['role_id'=>Yii::$app->params['userroles']['qa'],'status'=>'1'])->asArray()->all(), 'id', function( $user ) {
                return $user['first_name'].' '.$user['last_name'];
            } );
        return $snQaUsers;
    }
    //GET USER NAME BY ID//
     public static function get_user_name_by_id( $id='') {
        if(!empty($id)){
            $snUserDetails = Users::find()->where( ['id'=>$id] )->one();
        }
        return !empty( $snUserDetails ) ? $snUserDetails->first_name.' '.$snUserDetails->last_name : '';
    }


    


}