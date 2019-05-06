<?php

namespace common\models\base;

use Yii;
use common\models\Milestones;
use common\models\Timesheet;
use common\models\UserProjects;
use common\models\Clients;
use common\models\Users;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $client_name
 * @property integer $req_analysis_hours
 * @property integer $dev_hours
 * @property integer $qa_hours
 * @property integer $design_hours
 * @property integer $project_mgnt_hours
 * @property integer $wireframe_hours
 * @property integer $deploy_hours
 * @property integer $total_hours
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Milestones[] $milestones
 * @property Timesheet[] $timesheets
 * @property UserProjects[] $userProjects
 */
class ProjectsBase extends \yii\db\ActiveRecord
{
    /**
     *
     *
     * @inheritdoc
     */
    public static function tableName() {
        return 'projects';
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function rules() {
        return [
        [['description'], 'string'],
        [['name', 'client_name', 'dev_hours', 'status'], 'required'],
        [['req_analysis_hours', 'dev_hours', 'qa_hours', 'design_hours', 'project_mgnt_hours', 'wireframe_hours', 'deploy_hours', 'total_hours', 'status'], 'integer'],
        [['req_analysis_hours', 'dev_hours', 'qa_hours', 'design_hours', 'project_mgnt_hours', 'wireframe_hours', 'deploy_hours', 'total_hours'], 'compare', 'compareValue' => 0, 'operator' => '>'],
        [['description', 'req_analysis_hours', 'qa_hours', 'design_hours', 'project_mgnt_hours', 'wireframe_hours', 'deploy_hours', 'total_hours', 'created_at', 'updated_at', 'created_by', 'created_by'], 'safe'],
        [['name', 'client_name'], 'string', 'max' => 255]
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
        'name' => 'Name',
        'description' => 'Description',
        'client_name' => 'Client Name',
        'req_analysis_hours' => 'Req Analysis Hours',
        'dev_hours' => 'Dev Hours',
        'qa_hours' => 'Qa Hours',
        'design_hours' => 'Design Hours',
        'project_mgnt_hours' => 'Project Mgnt Hours',
        'wireframe_hours' => 'Wireframe Hours',
        'deploy_hours' => 'Deploy Hours',
        'total_hours' => 'Total Hours',
        'status' => 'Status',
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
    public function getMilestones() {
        return $this->hasMany( Milestones::className(), ['project_id' => 'id'] );
    }

    public function getClientName() {
        return $this->hasOne( Clients::className(), ['id' => 'client_name'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimesheets() {
        return $this->hasMany( Timesheet::className(), ['project_id' => 'id'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProjects() {
        return $this->hasMany( UserProjects::className(), ['project_id' => 'id'] );
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHandledBy() {
        return $this->hasOne( Users::className(), ['id' => 'handled_by'] );
    }
    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSalesPerson() {
        return $this->hasOne( Users::className(), ['id' => 'sales_person'] );
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
