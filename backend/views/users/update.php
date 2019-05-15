<?php

use yii\helpers\Html;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title ='Update User: ' . ' ' . $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
        'UserRolesDropdown'=>$UserRolesDropdown,
        'Restaurants' => $Restaurants

    ]) ?>

</div>
