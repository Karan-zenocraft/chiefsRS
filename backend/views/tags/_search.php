<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TagsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'id') ?>
<div class="row">
   <div class="span3"><?= $form->field($model, 'name') ?></div>

     <div class="span3"><?= $form->field($model, 'description') ?></div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
         <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['tags/index',"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
