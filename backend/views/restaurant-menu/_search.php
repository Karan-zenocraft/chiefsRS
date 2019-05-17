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
<table>
    

   <tr> <td><?= $form->field($model, 'name') ?></td>

    <td><?= $form->field($model, 'description') ?></td></tr>
    <tr>
    <td>
        <?php 
         $MenuCategoriesDropdown = MenuCategories::MenuCategoriesDropdown();
    
        ?>
      <?= $form->field($model, 'menu_category_id')->dropDownList($MenuCategoriesDropdown) ?></td>

    <td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></td>
    </tr>
    </table>
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
