let map;
var geocorder;
var infoWindow;
function initMap(){
    var myLatLng = {lat: 14.5995, lng: 120.9842}
    var mapOptions = {
        center: myLatLng,
        zoom: 13,
        mapTypeId: 'roadmap',
        mapId: '60e9ecd14d76dbb3'

    }
    map = new google.maps.Map(document.getElementById("map"),mapOptions);
    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: "default location"
        
    });
    map.addListener("center_changed", function(){
        var center = this.getCenter();
        var latitude = center.lat();
        var longtitude = center.lng();
        // data store
        var arrData = {};
        arrData.lat = latitude;
        arrData.lng = longtitude;

        getLatLng(arrData);
    });

    // get Lat Lng post in jsondata.php
    function getLatLng(latLng){
        $.ajax({
            url: "jsondata.php",
            method: "POST",
            data: latLng,
            success: function(response){
                document.getElementById("column7-inside").innerHTML = response;

            }

        });
    }
    // harvesine formula | calculate distance in kilometers
    function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
        var R = 6371; // Radius of the earth in km
        var dLat = deg2rad(lat2-lat1);  // deg2rad below
        var dLon = deg2rad(lon2-lon1); 
        var a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2)
            ; 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c; // Distance in km
        return d;
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180)
    }
    // harvesine formula end

    // autocomplete function
    var input = document.getElementById("cityInput");
    var options = ['(cities)'];
    var autoComplete = new google.maps.places.Autocomplete(input, options);
    autoComplete.addListener('place_changed',onPlaceChanged);

    // get address value 
    var address = $('#cityInput').val();
    if(address != ""){
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'address': address
        }, function(results, status){
            var latitude = results[0].geometry.location.lat();
            var longtitude = results[0].geometry.location.lng();

            var pos = {
                lat: latitude,
                lng: longtitude
            };
            // map pan to latLng value
            map.setCenter(pos);
        });
    }

    function onPlaceChanged(){
        var place = autoComplete.getPlace();
        map.panTo(place.geometry.location);
        map.setZoom(16);
        var latitude = place.geometry.location.lat();
        var longtitude = place.geometry.location.lng();
        // var currLoc = {lat: latitude, lng: longtitude};
    } 

    marker.setMap(map);
    // showAllShops
    var allData = JSON.parse(document.getElementById('mydata').innerHTML);
    showAllShops(allData);

    function showAllShops(allData){
        var infoWindow = new google.maps.InfoWindow;

        Array.prototype.forEach.call(allData, function(data){
            var content = document.createElement('div');
            var shopName = document.createElement('h6');
            var link = document.createElement('a');
            var element = document.createElement('img');
            shopName.textContent = data.Name;
            shopName.setAttribute("class", "mt-1 p-1");
            content.setAttribute("class","p-1 pe-3 text-center");
            link.setAttribute("href","clientPage.php?lessorid="+data.lessor_id);
            element.setAttribute("src","../assets/img/businessImg/"+data.Banner);
            element.setAttribute("class","rounded");
            element.setAttribute("height", "100px");
            element.setAttribute("width", "100%");
            
            // var strong = document.createElement('strong');
            // strong.textContent = data.Name;
            content.appendChild(link);
            content.appendChild(shopName);
            link.appendChild(element);


            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(data.lat, data.lng),
                icon: "../assets/img/ezbike_icon.png",
                map: map

            });
            marker.addListener('mouseover', function(){
                infoWindow.setContent(content);
                infoWindow.open(map, marker);

            });



        });
    }

    // current location
    const locationButton = document.createElement("button");
    locationButton.setAttribute("class","btn btn-secondary mx-2 mt-2");
    locationButton.setAttribute("id","panLocation");
    locationButton.textContent = "Pan to Nearest Location";
    locationButton.classList.add("custom-map-control-button");

    map.controls[google.maps.ControlPosition.LEFT].push(locationButton);

    locationButton.addEventListener("click", ()=>{
        getLocation();
    });

    const positionMarker = [];

    function getLocation() {
        var options = {
            enableHighAccuracy: true,
            timeout: 30000,
            maximumAge: 0
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition,errorPostion,options);
            removeMarkers();
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    function showPosition(position) {
        var lat=position.coords.latitude;
        var lng=position.coords.longitude; 
        var point = new google.maps.LatLng(lat,lng);

        map.setCenter(point);
        map.setZoom(14);
        findAddress(point);

        const marker = new google.maps.Marker({
            position: point,
            map: map,
            title: "My Location",
            animation: google.maps.Animation.BOUNCE
        });
        positionMarker.push(marker);
    }
    function removeMarkers(){
        for(var i =0; i<positionMarker.length; i++){
            positionMarker[i].setMap(null);
        }
    }
    function errorPostion(error) { 
        switch(error.code) {
           case error.PERMISSION_DENIED:
               errorMessage = "User denied the request for Geolocation."
               break;
           case error.POSITION_UNAVAILABLE:
               errorMessage = "Location information is unavailable."
               break;
           case error.TIMEOUT:
               errorMessage = "The request to get user location timed out."
               break;
           case error.UNKNOWN_ERROR:
               errorMessage = "An unknown error occurred."
               break;
       }
       alert("Error : " + errorMessage);
   }

    function findAddress(point) {
        var geocoder = new google.maps.Geocoder();
            geocoder.geocode({latLng: point}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        console.log(results[0].formatted_address);
                        console.log(point); 
                    }
                }
            });
        } 


}