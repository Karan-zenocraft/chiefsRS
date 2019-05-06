<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmailFormat */

$this->title = 'Update Email Template: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Email Templates', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-format-update">

    <!--h1><?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
