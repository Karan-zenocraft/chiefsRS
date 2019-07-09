<?php

namespace common\models;
use Yii;

class RestaurantTables extends \common\models\base\RestaurantTablesBase
{
    /**
* @inheritdoc
*/
public static function tableName()
{
return 'restaurant_tables';
}

 /* public function beforeSave($insert) {
        $user_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->setAttribute('created_by',$user_id);
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $this->setAttribute('updated_by',$user_id);

        return parent::beforeSave($insert);
    }*/
/**
* @inheritdoc
*/
 
	public function rules(){
        return [
            [['name', 'min_capacity', 'max_capacity','status'], 'required'],
            [['restaurant_id', 'layout_id','min_capacity', 'max_capacity', 'created_by', 'updated_by', 'status'], 'integer'],
            [['restaurant_id', 'layout_id','width','height','x_cordinate','y_cordinate','shape','created_at', 'updated_at','created_by', 'updated_by','status'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['layout_id'], 'exist', 'skipOnError' => true, 'targetClass' => RestaurantLayout::className(), 'targetAttribute' => ['layout_id' => 'id']],
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
    'layout_id' => 'Layout ID',
    'table_no' => 'Table No',
    'name' => 'Name',
    'width' => 'Width',
    'height' => 'Height',
    'x_cordinate' => 'X Cordinate',
    'y_cordinate' => 'Y Cordinate',
    'shape' => 'Shape',
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
    return $this->hasOne(RestaurantLayout::className(), ['id' => 'layout_id']);
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