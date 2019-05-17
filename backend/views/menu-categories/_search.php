<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-categories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'id') ?>
<table>
    <tr><td><?= $form->field($model, 'name') ?></td>

    <td><?= $form->field($model, 'description') ?></td>

<td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></td>
</tr>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>
</table>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
       <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['menu-categories/index',"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
