<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="menu-categories-form span12">

    <?php $form = ActiveForm::begin(); ?>
<table>
<tr>
    <td> <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></td>
</tr>
<tr>
    <td><?= $form->field($model, 'description')->textarea(['rows' => 4,"style"=>"width:94%"]) ?></td>
</tr>
<tr><td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?></td></tr>
</table>

    <div class="form-group form-actions">
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['menu-categories/index']), ['class' => 'btn default','onClick' => 'parent.jQuery.colorbox.close();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
