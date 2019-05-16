<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTablesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-tables-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'restaurant_id') ?>

    <?= $form->field($model, 'layout_id') ?>

    <?= $form->field($model, 'table_no') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'min_capacity') ?>

    <?php // echo $form->field($model, 'max_capacity') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
