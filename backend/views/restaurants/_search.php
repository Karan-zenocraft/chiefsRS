<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurants-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'id') ?>
 <div class="row">
        <div class="span3"><?= $form->field($model, 'name') ?></div>
        <div class="span3"><?= $form->field($model, 'description') ?></div>
        <div class="span3"><?= $form->field($model, 'country') ?>  </div>  
 </div>
    <?php // $form->field($model, 'address') ?>
 <div class="row">
        <div class="span3"><?php  echo $form->field($model, 'website') ?></div>
        <div class="span3"><?php  echo $form->field($model, 'max_stay_time_after_reservation') ?></div>
        <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
</div>

    


    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'pincode') ?>

    <?php // echo $form->field($model, 'lattitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'contact_no') ?>


    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurants/index',"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
