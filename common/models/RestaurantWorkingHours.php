<?php

namespace common\models;
use Yii;

class RestaurantWorkingHours extends \common\models\base\RestaurantWorkingHoursBase
{
	
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
            //[['weekday', 'opening_time', 'closing_time', 'status'], 'required'],
           // [['restaurant_id', 'weekday', 'status', 'created_by', 'updated_by'], 'integer'],
            [['opening_time', 'closing_time', 'created_at', 'updated_at','restaurant_id','hours24'], 'safe'],
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