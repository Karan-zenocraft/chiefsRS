<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Pages */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Page',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Page'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
