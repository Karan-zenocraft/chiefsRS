<?php

namespace common\models;
use Yii;

class ContactUs extends \common\models\base\ContactUsBase
{
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
            [['email'], 'email'],
            [['name'], 'string', 'max' => 255],
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