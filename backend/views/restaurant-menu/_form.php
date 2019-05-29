<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMenu */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurant-menu-form span12">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //echo $form->field($model, 'restaurant_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'menu_category_id')->dropDownList($MenuCategoriesDropdown) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'photo')->fileInput(['id'=>'photo','value'=>$model->photo]); ?>
    <div><br>
    <img id="image" width="100px" hieght="100px" src="<?php echo Yii::getAlias('@web')."../../../uploads/".$model->photo; ?>" alt="your image" />
    </div><br>

    <?php //echo $form->field($model, 'created_by')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?>

    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group form-actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>
<script type="text/javascript">
    
     $( document ).ready(function(){
        $("#photo").change(function() {
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
