<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reservations */

$this->title = Yii::t('app', 'Create Reservations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reservations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
