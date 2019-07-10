<?php

namespace common\models\base;

use Yii;
use common\models\RestaurantFloors;
use common\models\RestaurantMenu;
use common\models\RestaurantTables;
use common\models\RestaurantWorkingHours;
use common\models\RestaurentMealTimes;

/**
 * This is the model class for table "restaurants".
*
    * @property integer $id
    * @property string $name
    * @property string $description
    * @property string $address
    * @property string $city
    * @property string $state
    * @property string $country
    * @property integer $pincode
    * @property double $lattitude
    * @property double $longitude
    * @property string $website
    * @property integer $contact_no
    * @property string $email
    * @property string $max_stay_time_after_reservation
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property RestaurantFloorss[] $RestaurantFloorss
            * @property RestaurantMenu[] $restaurantMenus
            * @property RestaurantTables[] $restaurantTables
            * @property RestaurantWorkingHours[] $restaurantWorkingHours
            * @property RestaurentMealTimes[] $restaurentMealTimes
    */
class RestaurantsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurants';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'address', 'city', 'contact_no', 'max_stay_time_after_reservation'], 'required'],
            [['description', 'address'], 'string'],
            [['pincode', 'contact_no', 'status'], 'integer'],
            [['lattitude', 'longitude'], 'number'],
            [['max_stay_time_after_reservation', 'created_at', 'updated_at'], 'safe'],
            [['name', 'city', 'country', 'website', 'email'], 'string', 'max' => 255],
            [['state'], 'string', 'max' => 250],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'name' => 'Name',
    'description' => 'Description',
    'address' => 'Address',
    'city' => 'City',
    'state' => 'State',
    'country' => 'Country',
    'pincode' => 'Pincode',
    'lattitude' => 'Lattitude',
    'longitude' => 'Longitude',
    'website' => 'Website',
    'contact_no' => 'Contact No',
    'email' => 'Email',
    'max_stay_time_after_reservation' => 'Max Stay Time After Reservation',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantFloorss()
    {
    return $this->hasMany(RestaurantFloors::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantMenus()
    {
    return $this->hasMany(RestaurantMenu::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantTables()
    {
    return $this->hasMany(RestaurantTables::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantWorkingHours()
    {
    return $this->hasMany(RestaurantWorkingHours::className(), ['restaurant_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurentMealTimes()
    {
    return $this->hasMany(RestaurentMealTimes::className(), ['restaurant_id' => 'id']);
    }
}