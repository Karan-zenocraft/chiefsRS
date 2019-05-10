<?php

namespace common\models;
use Yii;

class RestaurantMenu extends \common\models\base\RestaurantMenuBase
{
    public static function tableName()
{
return 'restaurant_menu';
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
            [['name', 'description', 'menu_category_id', 'price'], 'required'],
            [['menu_category_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['restaurant_id', 'created_by', 'updated_by','created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['menu_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategories::className(), 'targetAttribute' => ['menu_category_id' => 'id']],
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
    'name' => 'Name',
    'description' => 'Description',
    'menu_category_id' => 'Menu Category ID',
    'price' => 'Price',
    'photo' => 'Photo',
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
    public function getMenuCategory()
    {
    return $this->hasOne(MenuCategories::className(), ['id' => 'menu_category_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurant()
    {
    return $this->hasOne(Restaurants::className(), ['id' => 'restaurant_id']);
    }
}