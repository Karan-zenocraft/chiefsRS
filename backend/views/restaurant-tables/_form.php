<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTables */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurant-tables-form span12">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'restaurant_id')->textInput() ?>

    <?php // echo $form->field($model, 'layout_id')->textInput() ?>

<div class="row">
    <div class="span3"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
</div>
<div class="row">
    <div class="span3"><?= $form->field($model, 'min_capacity')->textInput() ?></div>
</div>
<div class="row">
   <div class="span3"> <?= $form->field($model, 'max_capacity')->textInput() ?></div>
</div>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'updated_by')->textInput() ?>
<div class="row">
   <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?></div>
</div>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group form-actions">
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['menu-categories/index']), ['class' => 'btn default','onClick' => 'parent.jQuery.colorbox.close();']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
