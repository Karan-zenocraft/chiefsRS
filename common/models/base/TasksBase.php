<?php

namespace common\models\base;

use Yii;
use common\models\Milestones;
use common\models\Timesheet;

/**
* This is the model class for table "tasks".
*
    * @property string $id
    * @property string $milestone_id
    * @property string $name
    * @property string $description
    * @property string $start_date
    * @property string $end_date
    * @property integer $actual_hours
    * @property integer $status
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Milestones $milestone
            * @property Timesheet[] $timesheets
    */
class TasksBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'tasks';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['name','description','start_date','end_date','actual_hours', 'status'], 'required'],
            [['milestone_id', 'actual_hours', 'status'], 'integer'],
            [['actual_hours'],'compare', 'compareValue' => 0, 'operator' => '>'],
            [['description'], 'string'],
            [['start_date','is_deleted', 'end_date', 'created_at', 'updated_at','created_by','created_by'], 'safe'],
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
    'milestone_id' => 'Milestone ID',
    'name' => 'Name',
    'description' => 'Description',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'actual_hours' => 'Actual Hours',
    'status' => 'Status',
    'is_deleted' => 'Is Deleted', 
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    'created_by' => 'Created By',
    'updated_by' => 'Updated By',
];
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
    public function getTimesheets()
    {
    return $this->hasMany(Timesheet::className(), ['task_id' => 'id']);
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
           $this->setAttribute('created_at', date('Y-m-d H:i:s'));
           $this->setAttribute('created_by', Yii::$app->user->id);

        }
        else
        {
          $this->setAttribute('updated_at', date('Y-m-d H:i:s'));
          $this->setAttribute('updated_by', Yii::$app->user->id);
        }
    return parent::beforeSave($insert);
    }
}