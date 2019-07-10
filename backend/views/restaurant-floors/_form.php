<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantFloors */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurant-floors-form span12">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'restaurant_id')->textInput() ?>
<div class="row">
    <div class="span3"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
</div>
<div class="row">
    <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?></div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>
