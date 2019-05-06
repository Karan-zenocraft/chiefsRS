<?php

namespace common\models;

class MenuCategories extends \common\models\base\MenuCategoriesBase
{
     public static function tableName()
{
return 'menu_categories';
}

public function beforeSave($insert) {
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
            [['name', 'status','description'], 'required'],
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