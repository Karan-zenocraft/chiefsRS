<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmailFormat */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Email Template',
]);
$this->params['breadcrumbs'][] = ['label' => 'Email Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="email-format-create">

    <!--h1><?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
