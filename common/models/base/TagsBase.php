<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "tags".
*
    * @property integer $id
    * @property string $name
    * @property string $description
*/
class TagsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'tags';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
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
];
}
}