<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Manu Categories',
]);
$this->params['breadcrumbs'][] = ['label' => 'Manage Menu Categories', 'url' => ['menu-categories/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-create email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
