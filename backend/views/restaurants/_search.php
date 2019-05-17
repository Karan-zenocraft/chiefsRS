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
<table>
    <tr>
        <td><?= $form->field($model, 'name') ?></td>
        <td><?= $form->field($model, 'description') ?></td>
        <td><?= $form->field($model, 'country') ?>  </td>  
    </tr>


    <?php // $form->field($model, 'address') ?>
    <tr>
        <td><?php  echo $form->field($model, 'website') ?></td>

        <td><?php  echo $form->field($model, 'max_stay_time_after_reservation') ?></td>

        <td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></td>
        
    </tr>


    
</table>

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
