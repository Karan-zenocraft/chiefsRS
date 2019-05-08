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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true,'id' =>"autocomplete",'onFocus'=>"geolocate()"]) ?>
<table>
      <tr>
        <td><?= $form->field($model, 'city')->textInput(['maxlength' => true,'id'=>"locality",'disabled'=>"true"]) ?></td>
        <td><?= $form->field($model, 'country')->textInput(['maxlength' => true,'id'=>"country",'disabled'=>"true"]) ?></td>
      <tr>
         <td><?= $form->field($model, 'state')->textInput(['maxlength' => true,'id'=>"administrative_area_level_1",'disabled'=>"true"]) ?></td>
         <td><?= $form->field($model, 'pincode')->textInput(['id'=>"postal_code",'disabled'=>"true"]) ?></td>
      </tr>
      <tr>
          <td> <?= $form->field($model, 'lattitude')->textInput(['id'=>"lattitude",'disabled'=>"true"]) ?></td>
          <td> <?= $form->field($model, 'longitude')->textInput(['id'=>"longitude",'disabled'=>"true"]) ?></td>
      </tr>
    </table>


    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_no')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_stay_time_after_reservation')->textInput(['placeholder'=>'Enter in minutes']) ?>

    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']); ?>


    <div class="form-group form-actions">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['restaurants/index']), ['class' => 'btn default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>

<script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

var componentForm = {
//  street_number: 'short_name',
  //route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }
  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl5jlvnxlXZw-9NUSwnXus4g9uTq3Od4c&libraries=places&callback=initAutocomplete"
        async defer></script>

