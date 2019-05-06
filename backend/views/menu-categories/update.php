<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */

$this->title = 'Update Menu Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Menu Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-categories-update email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
