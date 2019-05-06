<?php

namespace common\models\base;

use Yii;

/**
* This is the model class for table "leave_quota".
*
    * @property string $id
    * @property integer $year
    * @property integer $month
    * @property double $total_leaves
    * @property double $previous_month_bal
    * @property string $created_at
    * @property string $updated_at
*/
class LeaveQuotaBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'leave_quota';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['year', 'month'], 'integer'],
            [['total_leaves', 'previous_month_bal'], 'required'],
            [['total_leaves', 'previous_month_bal'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'year' => 'Year',
    'month' => 'Month',
    'total_leaves' => 'Total Leaves',
    'previous_month_bal' => 'Previous Month Balance', 
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
];
}
}