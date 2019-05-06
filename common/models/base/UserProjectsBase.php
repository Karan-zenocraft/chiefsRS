<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\Projects;

/**
* This is the model class for table "user_projects".
*
    * @property integer $id
    * @property integer $project_id
    * @property string $user_id
        * @property string $start_date 
           * @property string $end_date 
           * @property integer $allocated_hours 
           * @property integer $avg_hours 
    *
            * @property Users $user
            * @property Projects $project
    */
class UserProjectsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'user_projects';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['project_id', 'user_id', 'allocated_hours', 'avg_hours'], 'integer'],
            [['start_date', 'end_date'], 'safe'],

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
    'user_id' => 'User ID',
    'start_date' => 'Start Date', 
    'end_date' => 'End Date', 
    'allocated_hours' => 'Total Allocated Hours', 
    'avg_hours' => 'Daily Allocated Hours', 
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProject()
    {
    return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }
}