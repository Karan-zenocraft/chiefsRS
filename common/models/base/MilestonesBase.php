<?php

namespace common\models\base;

use Yii;
 use common\models\Users;
use common\models\Projects;
use common\models\Tasks;
use common\models\Timesheet;

/**
 * This is the model class for table "milestones".
 *
 * @property string $id
 * @property integer $project_id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $actual_hours
 * @property integer $status
 * @property string $is_deleted
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Projects $project
 * @property Tasks[] $tasks
 * @property Timesheet[] $timesheets
 */
class MilestonesBase extends \yii\db\ActiveRecord
{
    /**
     *
     *
     * @inheritdoc
     */
    public static function tableName() {
        return 'milestones';
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function rules() {
        return [
        [['name', 'description', 'start_date', 'end_date', 'actual_hours', 'status'], 'required'],
        [['project_id', 'actual_hours', 'status'], 'integer'],
        [['actual_hours'], 'compare', 'compareValue' => 0, 'operator' => '>'],
        [['description'], 'string'],
        [['start_date', 'is_deleted', 'end_date', 'created_at', 'updated_at', 'created_by', 'created_by'], 'safe'],
        [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        'id' => 'ID',
        'project_id' => 'Project ID',
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
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQaUser() {
        return $this->hasOne( Users::className(), ['id' => 'qa_user_id'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject() {
        return $this->hasOne( Projects::className(), ['id' => 'project_id'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne( Users::className(), ['id' => 'created_by'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne( Users::className(), ['id' => 'updated_by'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSendToQaBy() {
        return $this->hasOne( Users::className(), ['id' => 'send_to_qa_by'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks() {
        return $this->hasMany( Tasks::className(), ['milestone_id' => 'id'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimesheets() {
        return $this->hasMany( Timesheet::className(), ['milestone_id' => 'id'] );
    }

    public function beforeSave( $insert ) {
        if ( $this->isNewRecord ) {
            $this->setAttribute( 'created_at', date( 'Y-m-d H:i:s' ) );
            $this->setAttribute( 'created_by', Yii::$app->user->id );

        }
        else {
            $this->setAttribute( 'updated_at', date( 'Y-m-d H:i:s' ) );
            $this->setAttribute( 'updated_by', Yii::$app->user->id );
        }
        return parent::beforeSave( $insert );
    }
}
