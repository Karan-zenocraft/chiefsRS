<?php 
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use common\web\js\common;
$this->title = Yii::t('app', 'Update Status: ' .$oModel['name']);

?>
<div class="pages-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
    <div class="block-content">
		<div class="users-form span12">

    		<?php $form = ActiveForm::begin(); ?>
  <?= $form->field($oModel,'status')->dropDownList(Yii::$app->params['milestone_update_status']); ?>
    	
     		<div class="form-group form-actions">
     			<input type='hidden' name="mid" value="<?= $_GET['mid'] ?>">
           		 <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	        	 <?= Html::a(Yii::t('app', 'Cancel'),'javascript:void(0)', ['class' => 'btn default btn-success','onClick'=>'parent.jQuery.colorbox.close();']) ?>

	        </div>
	   		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
