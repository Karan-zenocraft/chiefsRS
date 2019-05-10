<?php

namespace common\models\base;

use Yii;
use common\models\Restaurants;

/**
 * This is the model class for table "restaurant_working_hours".
*
    * @property integer $id
    * @property integer $restaurant_id
    * @property integer $weekday
    * @property string $opening_time
    * @property string $closing_time
    * @property integer $status
    * @property integer $created_by
    * @property integer $updated_by
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Restaurants $restaurant
    */
class RestaurantWorkingHoursBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurant_working_hours';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['restaurant_id', 'weekday', 'opening_time', 'closing_time', 'status', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'weekday', 'status', 'created_by', 'updated_by'], 'integer'],
            [['opening_time', 'closing_time', 'created_at', 'updated_at'], 'safe'],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'restaurant_id' => 'Restaurant ID',
    'weekday' => 'Weekday',
    'opening_time' => 'Opening Time',
    'closing_time' => 'Closing Time',
    'status' => 'Status',
    'created_by' => 'Created By',
    'updated_by' => 'Updated By',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurant()
    {
    return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }
}