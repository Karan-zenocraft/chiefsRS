<?php

namespace common\models\base;

use Yii;
use common\models\Projects;
use common\models\Milestones;
use common\models\Users;
use common\models\Tasks;

/**
* This is the model class for table "timesheet".
*
    * @property string $id
    * @property integer $project_id
    * @property string $milestone_id
    * @property string $user_id
    * @property string $task_id
    * @property integer $task_type
    * @property string $task_description
    * @property double $hours
    * @property string $entry_date
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Projects $project
            * @property Milestones $milestone
            * @property Users $user
            * @property Tasks $task
    */
class TimesheetBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'timesheet';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['project_id','milestone_id','task_id','task_description','hours','minutes','task_type','entry_date'], 'required'],

            //[['project_id', 'milestone_id', 'user_id', 'task_id', 'task_type'], 'integer'],
            [['task_description'], 'string'],
            [['hours'], 'number'],
            [['entry_date', 'created_at', 'updated_at'], 'safe']
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
    'milestone_id' => 'Milestone ID',
    'user_id' => 'User ID',
    'task_id' => 'Task ID',
    'task_type' => 'Task Type',
    'task_description' => 'Task Description',
    'hours' => 'Hours',
    'entry_date' => 'Entry Date',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
/*    'created_by' => 'Created By',
    'updated_by' => 'Updated By',*/
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProject()
    {
    return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMilestone()
    {
    return $this->hasOne(Milestones::className(), ['id' => 'milestone_id']);
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
    public function getTask()
    {
    return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}