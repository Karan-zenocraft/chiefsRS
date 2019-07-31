<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="tags-form span12 common_search">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
<div class="row">
    <div class="span3"><?=$form->field($model, 'name')->textInput(['maxlength' => true])?></div></div>
 <div class="row">
    <div class="span3"><?=$form->field($model, 'description')->textarea(['rows' => 2, 'style' => "width:94%"])?></div></div>
  <div class="row">
    <div class="span3"><?=$form->field($model, 'image')->fileInput(['id' => 'image_name', 'value' => $model->image]);?></div></div>
<div class="row">
<div class="span3">
    <img id="image" width="32px" hieght="32px" src="<?php echo Yii::getAlias('@web') . "/../uploads/" . $model->image; ?>" alt="" />
    </div>
</div>
  <div class="row">
    <div class="span3"><?=$form->field($model, 'status')->dropDownList(Yii::$app->params['status']);?>
</div></div>


    <div class="form-group form-actions">
         <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
    </div>
</div>
<script type="text/javascript">

     $( document ).ready(function(){
        $("#image_name").change(function() {
        readURL(this);
});
    });

    function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

</script>
