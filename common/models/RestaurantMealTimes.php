<?php

namespace common\models;
use Yii;
class RestaurantMealTimes extends \common\models\base\RestaurantMealTimesBase
{
    public static function tableName()
{
return 'restaurent_meal_times';
}
public function beforeSave($insert) {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_by',$user_id);
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $this->setAttribute('updated_by',$user_id);

        return parent::beforeSave($insert);
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