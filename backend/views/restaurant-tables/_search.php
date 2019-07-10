<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTablesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-tables-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index','rid'=>$_GET['rid'],'lid'=>$_GET['lid']],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'restaurant_id') ?>

    <?php // $form->field($model, 'floor_id') ?>
        <div class="row">

            <div class="span3"><?= $form->field($model, 'name') ?></div>
             <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
            
        </div>
        <div class="row">
           <div class="span3"> <?php  echo $form->field($model, 'min_capacity') ?></div>

           <div class="span3"> <?php  echo $form->field($model, 'max_capacity') ?></div>
        </div>
        <div class="row">
             
        </div>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>


    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurant-tables/index','rid'=>$_GET['rid'],'lid'=>$_GET['lid'],"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
