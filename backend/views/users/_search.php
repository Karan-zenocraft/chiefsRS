<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'id') ?>

    <?php //echo $form->field($model, 'role_id') ?>
    <table>
        
   <tr><td><?= $form->field($model, 'email') ?></td>

    <?php //echo $form->field($model, 'password') ?>

    <td><?= $form->field($model, 'fullName') ?></td>

    <?php //$form->field($model, 'last_name') ?>

    <?php //echo $form->field($model, 'address') ?>

   <td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></td>
    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>
    </tr>
 </table>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['users/index',"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
