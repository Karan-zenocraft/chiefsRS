<?php

namespace common\models\base;

use Yii;

/**
* This is the model class for table "pages".
*
    * @property integer $id
    * @property string $page_title
    * @property string $page_content
    * @property string $meta_title
    * @property string $meta_keyword
    * @property string $meta_description
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
*/
class PagesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'pages';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['page_title', 'page_content'], 'required'],
            [['page_content', 'meta_description'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['page_title', 'meta_title', 'meta_keyword'], 'string', 'max' => 255]
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'page_title' => 'Page Title',
    'page_content' => 'Page Content',
    'meta_title' => 'Meta Title',
    'meta_keyword' => 'Meta Keyword',
    'meta_description' => 'Meta Description',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}
}