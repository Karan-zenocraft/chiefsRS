<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MenuCategories;

/* @var $this yii\web\View */
/* @var $model common\models\\RestaurantMenuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-menu-search">

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

        <div class="span3"><?= $form->field($model, 'description') ?></div>
    </div>
    <div class="row">
   
        <?php 
         $MenuCategoriesDropdown = MenuCategories::MenuCategoriesDropdown();
    
        ?>
      <div class="span3"><?= $form->field($model, 'menu_category_id')->dropDownList($MenuCategoriesDropdown) ?></div>

    <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
   </div>
   
    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>


    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
         <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurant-menu/index','rid'=>$_GET['rid'],"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
