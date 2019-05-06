<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */

$this->title = 'Update Tag: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Tags', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tags-update email-format-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
