<?php

use common\models\UserRoles;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">
    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
    <?php //echo $form->field($model, 'id') ?>

    <div class="row">
        <div class="span3 style_input_width"><?=$form->field($model, 'fullName')?></div>
        <div class="span3 style_input_width"><?=$form->field($model, 'email')?></div>
    </div>

    <?php
$UserRolesDropdown = ArrayHelper::map(UserRoles::find()->where("id !=" . Yii::$app->params['super_admin_role_id'] . " AND id !=" . Yii::$app->params['administrator_role_id'] . " AND id !=" . Yii::$app->params['userroles']['walk_in'])->asArray()->all(), 'id', 'role_name');
//$form->field($model, 'last_name')
?>
    <?php //echo $form->field($model, 'address') ?>

    <div class="row">
        <div class="span3 style_input_width"><?php echo $form->field($model, 'role_id')->dropDownList($UserRolesDropdown); ?></div>
        <div class="span3 style_input_width"><?=$form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>

        <?php // echo $form->field($model, 'created_at') ?>
        <?php // echo $form->field($model, 'updated_at') ?>

    </div>

    <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['users/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>
</div>