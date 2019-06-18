<?php

namespace common\models;
use yii\helpers\ArrayHelper;

class Tags extends \common\models\base\TagsBase
{
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->setAttribute('created_at', date('Y-m-d H:i:s'));
        }
        $this->setAttribute('updated_at', date('Y-m-d H:i:s'));

        return parent::beforeSave($insert);
}

  public static function TagsDropDown(){
        //->where(['status'=>Yii::$app->params['department_active_status']])
        return ArrayHelper::map(Tags::find()->where(['status'=>'1'])->orderBy('name')->asArray()->all(),'id','name');
    }

}