<?php

namespace common\models\base;

use Yii;

/**
* This is the model class for table "department".
*
    * @property integer $id
    * @property string $name
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
*/
class DepartmentBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'department';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255]
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
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}
}