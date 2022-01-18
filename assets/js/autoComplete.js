//autocomplete search
var input = document.getElementById("cityInput");
var options = ['(cities)'];
var autoComplete = new google.maps.places.Autocomplete(input, options);
autoComplete.addListener('place_changed', onPlaceChanged);

function onPlaceChanged() {
    var place = autoComplete.getPlace();

    var latitude = place.geometry.location.lat();
    var longtitude = place.geometry.location.lng();

    var currLoc = { lat: latitude, lng: longtitude };

}

