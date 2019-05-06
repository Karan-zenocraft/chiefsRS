<?php

namespace common\models\base;

use Yii;
use common\models\Users;

/**
* This is the model class for table "leaves".
*
    * @property string $id
    * @property string $user_id
    * @property string $tl_user_id
    * @property string $start_date
    * @property string $end_date
    * @property integer $no_of_days
    * @property integer $leave_type
    * @property integer $leave_type1
    * @property string $reason
    * @property integer $leave_status
    * @property string $created_at
    * @property string $updated_at
    * @property string $created_by
    * @property string $updated_by
    *
            * @property Users $user
            * @property Users $tlUser
    */
class LeavesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'leaves';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['user_id', 'tl_user_id', 'start_date', 'end_date', 'leave_type', 'reason'], 'required'],
            [['user_id', 'tl_user_id', 'no_of_days', 'leave_type', 'leave_status', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at','leave_type1','no_of_days_approved'], 'safe'],
            [['reason'], 'string']
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'user_id' => 'User Name',
    'tl_user_id' => 'Team Leader',
    'start_date' => 'Start Date',
    'end_date' => 'End Date',
    'no_of_days' => 'Number of days applied',
    'no_of_days_approved' => 'Number of days approved',
    'user_leave_balance'=> 'Leave Balance',
    'leave_type' => 'Leave Mode',
    'leave_type1' => 'Leave Type',
    'reason' => 'Reason For Leave',
    'leave_status' => 'Leave Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    'created_by' => 'Created By',
    'updated_by' => 'Updated By',
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
    public function getTlUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'tl_user_id']);
    }
}