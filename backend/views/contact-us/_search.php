<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modelContactUsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-us-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1,
    ],
]);?>

<div class="row">
     <div class="span3"><?=$form->field($model, 'name')?></div>

     <div class="span3"><?=$form->field($model, 'email')?></div>

     <div class="span3"><?=$form->field($model, 'message')?></div>
</div>
    <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['contact-us/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
