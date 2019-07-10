<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\RestaurantFloors;
use common\models\Restaurants;

/**
 * This is the model class for table "restaurant_tables".
*
    * @property integer $id
    * @property integer $restaurant_id
    * @property integer $floor_id
    * @property integer $table_no
    * @property string $name
    * @property integer $min_capacity
    * @property integer $max_capacity
    * @property integer $created_by
    * @property integer $updated_by
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Users $createdBy
            * @property RestaurantFloorss $layout
            * @property Restaurants $restaurant
            * @property Users $updatedBy
    */
class RestaurantTablesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurant_tables';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['restaurant_id', 'floor_id', 'table_no', 'name', 'min_capacity', 'max_capacity', 'created_by', 'updated_by', 'status', 'created_at', 'updated_at'], 'required'],
            [['restaurant_id', 'floor_id', 'table_no', 'min_capacity', 'max_capacity', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantFloors::className(), 'targetAttribute' => ['floor_id' => 'id']],
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
    'floor_id' => 'Layout ID',
    'table_no' => 'Table No',
    'name' => 'Name',
    'min_capacity' => 'Min Capacity',
    'max_capacity' => 'Max Capacity',
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
    public function getLayout()
    {
    return $this->hasOne(RestaurantFloors::className(), ['id' => 'floor_id']);
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