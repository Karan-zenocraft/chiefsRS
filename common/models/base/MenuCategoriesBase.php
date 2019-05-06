<?php

namespace common\models\base;

use Yii;
use common\models\RestaurantMenu;

/**
 * This is the model class for table "menu_categories".
*
    * @property integer $id
    * @property string $name
    * @property string $description
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property RestaurantMenu[] $restaurantMenus
    */
class MenuCategoriesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'menu_categories';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'status', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRestaurantMenus()
    {
    return $this->hasMany(RestaurantMenu::className(), ['menu_category_id' => 'id']);
    }
}