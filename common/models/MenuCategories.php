<?php

namespace common\models;
use yii\helpers\ArrayHelper;


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
public static function MenuCategoriesDropdown(){
        //->where(['status'=>Yii::$app->params['department_active_status']])
        return ArrayHelper::map(MenuCategories::find()->orderBy('name')->asArray()->all(),'id','name');
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