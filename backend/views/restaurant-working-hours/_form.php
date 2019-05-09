<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantWorkingHours */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-working-hours-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'restaurant_id')->textInput() ?>

    <?= $form->field($model, 'weekday')->textInput() ?>

    <?= $form->field($model, 'opening_time')->textInput() ?>

    <?= $form->field($model, 'closing_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
