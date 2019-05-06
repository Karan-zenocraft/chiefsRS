<?php

namespace common\models\base;

use Yii;
use common\models\Users;
use common\models\Technology;

/**
* This is the model class for table "users_technical_skills".
*
    * @property integer $id
    * @property integer $technology_id
    * @property string $user_id
    * @property integer $rating
    * @property string $created_at
    * @property string $updated_at
    *
            * @property Users $user
            * @property Technology $technology
    */
class UsersTechnicalSkillsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'users_technical_skills';
}

/**
* @inheritdoc
*/
public function rules()
{
return [
            [['technology_id', 'user_id', 'rating'], 'integer'],
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
    'technology_id' => 'Technology ID',
    'user_id' => 'User ID',
    'rating' => 'Rating',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
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
    public function getTechnology()
    {
    return $this->hasOne(Technology::className(), ['id' => 'technology_id']);
    }
}