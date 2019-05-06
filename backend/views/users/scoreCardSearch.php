<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\TimesheetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scoreCard-search">

    <?php $form = ActiveForm::begin([
        'action' =>isset($_GET['pid']) ? Yii::$app->urlManager->createUrl(['users/get-score-card','id'=>$_GET['id'],'pid'=>$_GET['pid']]) : Yii::$app->urlManager->createUrl(['users/get-score-card','id'=>$_GET['id']]),
        'method' => 'post','id' => 'search_form_model'
    ]); 
    ?>
    <?= Html::dropDownList('pid',null,$ProjectsDropDown,['prompt' => Yii::t('app', '-Choose Project-')])?>

    <div class="form-group">
        <?= Html::submitButton('Search',['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Reset'), Yii::$app->urlManager->createUrl(['users/get-score-card','id'=>$_GET['id']]), ['class' => 'btn btn-default']) ?>
        <?php //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>