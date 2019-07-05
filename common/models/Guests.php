<?php

namespace common\models;

class Guests extends \common\models\base\GuestsBase
{
    public static function tableName()
{
return 'guests';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['reservation_id', 'contact_no'], 'integer'],
            [['name', 'email'], 'required'],
            [['birthday', 'anniversary','first_name','last_name','restaurant_id'], 'safe'],
            [['first_name','last_name','email', 'guest_note'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'restaurant_id' => Yii::t('app', 'Restaurant Id'),
    'reservation_id' => Yii::t('app', 'Reservation Id'),
    'first_name' => Yii::t('app', 'First Name'),
    'last_name' => Yii::t('app', 'Last Name'),
    'email' => Yii::t('app', 'Email'),
    'contact_no' => Yii::t('app', 'Contact No'),
    'guest_note' => Yii::t('app', 'Guest Note'),
    'birthday' => Yii::t('app', 'Birthday'),
    'anniversary' => Yii::t('app', 'Anniversary'),
];
}
}