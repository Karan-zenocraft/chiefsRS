<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Restaurants */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurants-form span12">

    <?php $form = ActiveForm::begin(); ?>
<table>
  <tr>
    <td><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
</td>
<td> <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></td>
<td>  <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?></td>
<td> <?= $form->field($model, 'contact_no')->textInput() ?></td>
  </tr>
  <tr>
    <td colspan="4">
      <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
    </td>
  </tr>
  
 <tr>
   <td> <?= $form->field($model, 'address')->textInput(['maxlength' => true,'id' =>"autocomplete"]) ?></td>
     
        <td><?= $form->field($model, 'city')->textInput(['maxlength' => true,'id'=>"city",'disabled'=>"true"]) ?></td>
        <td><?= $form->field($model, 'country')->textInput(['maxlength' => true,'id'=>"country",'disabled'=>"true"]) ?></td>
         <td><?= $form->field($model, 'state')->textInput(['maxlength' => true,'id'=>"state",'disabled'=>"true"]) ?></td>
      </tr>
      <tr>
         <td><?= $form->field($model, 'pincode')->textInput(['id'=>"postal_code",'disabled'=>"true"]) ?></td>
          <td> <?= $form->field($model, 'lattitude')->textInput(['id'=>"lattitude",'disabled'=>"true"]) ?></td>
          <td> <?= $form->field($model, 'longitude')->textInput(['id'=>"longitude",'disabled'=>"true"]) ?></td>
      </tr>
      <tr>
        <td> <?= $form->field($model, 'max_stay_time_after_reservation')->textInput(['placeholder'=>'Enter in minutes']) ?></td>
        <td><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?></td>
      </tr>
    </table>
    
    <div class="form-group form-actions">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['restaurants/index']), ['class' => 'btn default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
google.maps.event.addDomListener(window, 'load', function() 
{
   var places = new google.maps.places.Autocomplete(document
           .getElementById('autocomplete'));
       google.maps.event.addListener(places, 'place_changed', function() {
       var place = places.getPlace();
       var address = place.formatted_address;
       var  value = address.split(",");
       count=value.length;
       country=value[count-1];
       state=value[count-2];
       city=value[count-3];
       var z=state.split(" ");
       document.getElementById("country").value = country;
       var i =z.length;
       document.getElementById("state").value = z[1];
       if(i>2)
       document.getElementById("postal_code").value = z[2];
       document.getElementById("city").value = city;
       var latitude = place.geometry.location.lat();
       var longitude = place.geometry.location.lng();
       var mesg = address;
       document.getElementById("autocomplete").value = mesg;
       var lati = latitude;
       document.getElementById("lattitude").value = lati;
       var longi = longitude;
       document.getElementById("longitude").value = longi; 
       document.getElementById("country").disabled = false; 
       document.getElementById("state").disabled = false;           
       document.getElementById("city").disabled = false;           
       document.getElementById("postal_code").disabled = false;           
       document.getElementById("lattitude").disabled = false;           
       document.getElementById("longitude").disabled = false;           

   });
});

});
</script>
<script src="https://maps.googleapis.com/maps/api/js?components=country:USA&key=AIzaSyBvpANF446OIBFdLaqozAf-lheEZ__oVVg&libraries=places"></script>
    
