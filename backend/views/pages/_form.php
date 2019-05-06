<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
        <div class="span12">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'page_title')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'page_content')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'status')->textInput() ?>

           

            <div class="form-actions">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['pages/index']), ['class' => 'btn default']) ?>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
