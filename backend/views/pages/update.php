<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Page',
        ]) . ' ' . $model->page_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="email-format-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
