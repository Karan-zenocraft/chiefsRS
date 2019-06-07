
function initialize(){
  
    var lat = $("#lat").val();
    var long = $("#long").val();
    console.log(lat);
    console.log(long);
    var myLatlng = new google.maps.LatLng(lat, long);
    // var myLatlng = new google.maps.LatLng(-25.363882,131.044922);
     var myOptions = {
         zoom: 4,
         center: myLatlng,
         mapTypeId: google.maps.MapTypeId.ROADMAP
         }
      map = new google.maps.Map(document.getElementById("map"), myOptions);
      var marker = new google.maps.Marker({
          position: myLatlng, 
          map: map,
      title:"Fast marker"
     });
} 

google.maps.event.addDomListener(window,'load', initialize);