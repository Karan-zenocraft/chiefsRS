<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\Restaurants;
use common\models\RestaurantTables;

/**
 * This is the model class for table "restaurant_layouts".
*
    * @property integer $id
    * @property integer $restaurant_id
    * @property string $name
    * @property integer $created_by
    * @property integer $updated_by
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Users $createdBy
            * @property Restaurants $restaurant
            * @property Users $updatedBy
            * @property RestaurantTables[] $restaurantTables
    */
class RestaurantFloorsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurant_floors';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['restaurant_id', 'name', 'created_by', 'updated_by', 'status', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
    'name' => 'Name',
    'created_by' => 'Created By',
    'updated_by' => 'Updated By',
    'status' => 'Status',
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

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantTables()
    {
    return $this->hasMany(RestaurantTables::className(), ['floor_id' => 'id']);
    }
}