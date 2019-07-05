<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "guests".
*
    * @property integer $id
    * @property integer $reservation_id
    * @property string $name
    * @property string $email
    * @property integer $contact_no
    * @property string $guest_note
    * @property string $birthday
    * @property string $anniversary
*/
class GuestsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
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
            [['birthday', 'anniversary'], 'safe'],
            [['name', 'email', 'guest_note'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'reservation_id' => Yii::t('app', 'Reservation ID'),
    'name' => Yii::t('app', 'Name'),
    'email' => Yii::t('app', 'Email'),
    'contact_no' => Yii::t('app', 'Contact No'),
    'guest_note' => Yii::t('app', 'Guest Note'),
    'birthday' => Yii::t('app', 'Birthday'),
    'anniversary' => Yii::t('app', 'Anniversary'),
];
}
}