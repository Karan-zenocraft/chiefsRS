<?php

namespace common\models\base;

use Yii;

/**
* This is the model class for table "news".
*
    * @property integer $id
    * @property string $title
    * @property string $content
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
*/
class NewsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'news';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['title', 'content', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'title' => Yii::t('app', 'Title'),
    'content' => Yii::t('app', 'Content'),
    'status' => Yii::t('app', 'Status'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}
}