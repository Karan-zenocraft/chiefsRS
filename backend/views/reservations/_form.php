<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reservations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php// $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?php// $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?php// $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php// $form->field($model, 'contact_no')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'restaurant_id')->textInput() ?>

    <?= $form->field($model, 'floor_id')->textInput() ?>

    <?= $form->field($model, 'table_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'booking_start_time')->textInput() ?>

    <?= $form->field($model, 'booking_end_time')->textInput() ?>

    <?= $form->field($model, 'total_stay_time')->textInput() ?>

    <?= $form->field($model, 'no_of_guests')->textInput() ?>

    <?= $form->field($model, 'pickup_drop')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pickup_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pickup_lat')->textInput() ?>

    <?= $form->field($model, 'pickup_long')->textInput() ?>

    <?= $form->field($model, 'pickup_time')->textInput() ?>

    <?= $form->field($model, 'drop_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'drop_lat')->textInput() ?>

    <?= $form->field($model, 'drop_long')->textInput() ?>

    <?= $form->field($model, 'drop_time')->textInput() ?>

    <?= $form->field($model, 'special_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
