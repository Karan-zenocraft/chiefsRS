<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'User',
]);
$this->params['breadcrumbs'][] = ['label' => 'Manage Users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="users-create email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
        'UserRolesDropdown' => $UserRolesDropdown,
        'Restaurants' => $Restaurants
    ]) ?>
</div>
