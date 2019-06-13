<?php

namespace common\models;
use Yii;

class Reservations extends \common\models\base\ReservationsBase
{
    public static function tableName()
{
return 'reservations';
}
public function beforeSave($insert) {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        return parent::beforeSave($insert);
    }
/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['first_name','last_name','email','contact_no','date', 'booking_start_time', 'booking_end_time', 'no_of_guests','total_stay_time'], 'required'],
            [['user_id', 'restaurant_id', 'layout_id', 'table_id', 'no_of_guests', 'status'], 'integer'],
            [['user_id', 'restaurant_id', 'layout_id','date', 'booking_start_time', 'booking_end_time', 'total_stay_time', 'pickup_time', 'drop_time', 'created_at', 'updated_at'], 'safe'],
            [['pickup_drop', 'special_comment'], 'string'],
            [['pickup_lat', 'pickup_long', 'drop_lat', 'drop_long'], 'number'],
            [['pickup_location', 'drop_location'], 'string', 'max' => 255],
            [['layout_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantLayout::className(), 'targetAttribute' => ['layout_id' => 'id']],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurants::className(), 'targetAttribute' => ['restaurant_id' => 'id']],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantTables::className(), 'targetAttribute' => ['table_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'user_id' => 'User ID',
    'restaurant_id' => 'Restaurant',
    'layout_id' => 'Layout ID',
    'table_id' => 'Table ID',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'email' => 'Email',
    'contact_no' => 'Contact Number',
    'date' => 'Date',
    'booking_start_time' => 'Booking Time',
    'booking_end_time' => 'Booking End Time',
    'total_stay_time' => 'Total Stay Time',
    'no_of_guests' => 'No Of Guests',
    'pickup_drop' => 'Pickup & Drop',
    'pickup_location' => 'Pickup Location',
    'pickup_lat' => 'Pickup Lat',
    'pickup_long' => 'Pickup Long',
    'pickup_time' => 'Pickup Time',
    'drop_location' => 'Drop Location',
    'drop_lat' => 'Drop Lat',
    'drop_long' => 'Drop Long',
    'drop_time' => 'Drop Time',
    'special_comment' => 'Special Comment',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLayout()
    {
    return $this->hasOne(RestaurantLayouts::className(), ['id' => 'layout_id']);
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
    public function getTable()
    {
    return $this->hasOne(RestaurantTables::className(), ['id' => 'table_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}