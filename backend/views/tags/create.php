<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tags',
]);
$this->params['breadcrumbs'][] = ['label' => 'Manage Tags', 'url' => ['tags/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-create email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
