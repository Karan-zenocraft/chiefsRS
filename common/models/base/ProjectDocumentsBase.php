<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\Projects;

/**
* This is the model class for table "project_documents".
*
    * @property string $id
    * @property integer $project_id
    * @property string $document_name
    * @property string $document_file
    * @property integer $status
    * @property string $uploaded_by
    * @property string $uploaded_at
    *
            * @property Users $uploadedBy
            * @property Projects $project
    */
class ProjectDocumentsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'project_documents';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['id'], 'required'],
            [['id', 'project_id', 'status', 'uploaded_by'], 'integer'],
            [['uploaded_at'], 'safe'],
            [['document_name', 'document_file'], 'string', 'max' => 255]
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'project_id' => 'Project ID',
    'document_name' => 'Document Name',
    'document_file' => 'Document File',
    'status' => 'Status',
    'uploaded_by' => 'Uploaded By',
    'uploaded_at' => 'Uploaded At',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUploadedBy()
    {
    return $this->hasOne(Users::className(), ['id' => 'uploaded_by']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProject()
    {
    return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }
}