<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="users-form span12">

    <?php $form = ActiveForm::begin(); ?>
<table>
    <tr>
        <td><?= $form->field($model, 'role_id')->dropDownList($UserRolesDropdown) ?></td>
        <td> <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?></td>
        <td>
    <?= $model->isNewRecord ? ($form->field($model, 'password')->passwordInput(['maxlength' => 255])) : '' ?>
        
    </td>
    </tr>
      <tr>
        <td><?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?></td>
        <td><?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?></td>
    </tr>
        <tr><td><?= $form->field($model, 'address')->textArea(['maxlength' => 255]) ?></td>
        <td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></td>
        </tr>

</table>
    
    

    <div class="form-group form-actions">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['users/index']), ['class' => 'btn default']) ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>
