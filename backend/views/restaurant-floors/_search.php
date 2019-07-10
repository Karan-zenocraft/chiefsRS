<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantFloorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-floors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index','rid'=>$_GET['rid']],
        'method' => 'get',
       /* 'options' => [
            'data-pjax' => 1
        ],*/
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'restaurant_id') ?>
  
  <div class="row">
    <div class="span3"><?= $form->field($model, 'name') ?></div>
   <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
 </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurant-floors/index','rid'=>$_GET['rid'],"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
