<?php

namespace common\models\base;

use Yii;
use common\models\RestaurantLayout;
use common\models\Restaurants;
use common\models\RestaurantTables;
use common\models\Users;

/**
 * This is the model class for table "reservations".
*
    * @property integer $id
    * @property integer $user_id
    * @property integer $restaurant_id
    * @property integer $layout_id
    * @property integer $table_id
    * @property string $date
    * @property string $booking_start_time
    * @property string $booking_end_time
    * @property string $total_stay_time
    * @property integer $no_of_guests
    * @property string $pickup_drop
    * @property string $pickup_location
    * @property double $pickup_lat
    * @property double $pickup_long
    * @property string $pickup_time
    * @property string $drop_location
    * @property double $drop_lat
    * @property double $drop_long
    * @property string $drop_time
    * @property string $special_comment
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property RestaurantLayouts $layout
            * @property Restaurants $restaurant
            * @property RestaurantTables $table
            * @property Users $user
    */
class ReservationsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'reservations';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'restaurant_id', 'layout_id', 'date', 'booking_start_time', 'booking_end_time', 'no_of_guests', 'status', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'restaurant_id', 'layout_id', 'table_id', 'no_of_guests', 'status'], 'integer'],
            [['date', 'booking_start_time', 'booking_end_time', 'total_stay_time', 'pickup_time', 'drop_time', 'created_at', 'updated_at'], 'safe'],
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
    'restaurant_id' => 'Restaurant ID',
    'layout_id' => 'Layout ID',
    'table_id' => 'Table ID',
    'date' => 'Date',
    'booking_start_time' => 'Booking Start Time',
    'booking_end_time' => 'Booking End Time',
    'total_stay_time' => 'Total Stay Time',
    'no_of_guests' => 'No Of Guests',
    'pickup_drop' => 'Pickup Drop',
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