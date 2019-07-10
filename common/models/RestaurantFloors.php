<?php

namespace common\models;
use Yii;

class RestaurantFloors extends \common\models\base\RestaurantFloorsBase
{
	public static function tableName()
	{
		return 'restaurant_floors';
	}
    /*public function beforeSave($insert) {
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
public function rules()
{
        return [
            [['name','status'], 'required'],
            [['restaurant_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['restaurant_id','created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
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