<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "contact_us".
*
    * @property integer $id
    * @property string $name
    * @property string $email
    * @property string $message
*/
class ContactUsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'contact_us';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'email', 'message'], 'required'],
            [['message'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'name' => Yii::t('app', 'Name'),
    'email' => Yii::t('app', 'Email'),
    'message' => Yii::t('app', 'Message'),
];
}
}