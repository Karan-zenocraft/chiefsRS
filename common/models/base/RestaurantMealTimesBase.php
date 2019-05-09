<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\Restaurants;

/**
 * This is the model class for table "restaurent_meal_times".
*
    * @property integer $id
    * @property integer $restaurant_id
    * @property integer $meal_type
    * @property string $start_time
    * @property string $end_time
    * @property integer $status
    * @property integer $created_by
    * @property integer $updated_by
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Users $createdBy
            * @property Restaurants $restaurant
            * @property Users $updatedBy
    */
class RestaurantMealTimesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurent_meal_times';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['restaurant_id', 'meal_type', 'start_time', 'end_time', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'meal_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
    'meal_type' => 'Meal Type',
    'start_time' => 'Start Time',
    'end_time' => 'End Time',
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
    public function getCreatedBy()
    {
    return $this->hasOne(Users::className(), ['id' => 'created_by']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurant()
    {
    return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUpdatedBy()
    {
    return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }
}