var App = (function () {

  App.mapsGoogle = function( ){
    'use strict'

    //Basic Map
    var map;

    var mapOptions = {
      zoom: 14,
      center: new google.maps.LatLng(-25.745477 , 28.225937),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);
  };

  return App;
})(App || {});
