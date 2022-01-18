<?php
    session_start();
    require_once "functions.php";
    if(!isset($_SESSION["lessor_id"])){
        redirectTo("lenderLogin.php?login_attempt=Session Expired!");
    }
    require_once "../Model/Bicycle.php";
    require_once "../Model/BusinessModel.php";
    require_once "header.php";
?>
<title>Ezbike | Lessor Dashboard</title>
</head>

<body>
    <div class="container-fluid web-wash">
        <div class="row">
            <div class="col-md-2 sidenav bg-dark text-light">
                <div class="text-center">
                    <img class="logo" src="../assets/img/ezbike.png" alt="">
                </div>
                <ul class="dashboard-navleft fs-14">
                    <?php
                        require_once "library.php";
                        foreach($nav_elements as $nav_data => $value){   
                            foreach($value as $key => $data_value){                                               
                    ?>
                    <li>
                        <div class="row align-items-center">
                            <div class="col-md-3 px-4">
                                <i class="<?php echo $key;?>"></i>
                            </div>
                            <div class="col-md-9 p-0">
                                <a href="<?php echo $data_value;?>"> <?php echo $nav_data; ?></a>
                            </div>
                        </div>
                    </li>
                    <?php
                            } 
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-10 main">
                <div class="row align-items-center" id="top-main">
                    <div class="col-md-6">
                        <h5 class="mt-1 ff-1">Location</h5>
                    </div>
                    <div class="col-md-6" id="nav_top_right">
                        <ul class="navright_utilities mb-0">
                            <li>
                                <a href="lessor_profile.php"><i class="fas fa-user border p-1 px-2 rounded-circle"></i>
                                    My Profile</a>
                            </li>
                            <li> | </li>
                            <li><a href="logoutLessor.php"> <i class="fas fa-sign-out-alt"></i> Log-out</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 mb-0">
                        <p class="mb-0">Select Your Location by clicking the map and hit the <span
                                class="text-success pt-1 pb-1 px-2 rounded"> 'Confirm location' </span> on the left side
                            of the map.</p>

                    </div>
                    <div class="col-md-12">
                        <?php
                        if(isset($_GET["success_insert"])){
                        ?>
                        <div class="col-md-12 px-2">
                            <div id="success_insert" class="alert alert-success mt-2 fs-13" role="alert">
                                <i class="ti-check px-2"></i>
                                <?php echo $_GET["success_insert"] ?>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <?php
                            if(isset($_GET["failed_insert"])){
                        ?>
                        <div class="col-md-12 px-2">
                            <div id="failed_insert" class="alert alert-danger mt-2 fs-13" role="alert">
                                <i class="ti-close px-2"></i>
                                <?php echo $_GET["failed_insert"] ?>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="pt-3 pb-3 d-flex align-items-center">
                            <i class="fas fa-search btn border"></i>
                            <input class="mx-2 form-control" type="text" id="cityInput">
                        </div>

                        <?php
                            $locationLatLng = new BusinessModel();
                            $lessor_data = $locationLatLng->getAllShops();
                            $lessor_data = json_encode($lessor_data, true);
                            echo '<div id="lessor_data">' . $lessor_data .  '</div>';
                        ?>
                        <div id="lessor_map"> </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(() => {

        $('#success_insert').hide(5000);
    });
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places&callback=initMap">
    </script>
    <script>
    let map;
    var markers = [];

    function cancelLocation() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
    }

    function initMap() {
        var myLatLng = {
            lat: 14.5995,
            lng: 120.9842
        }
        var mapOptions = {
            center: myLatLng,
            zoom: 13,
            mapTypeId: 'roadmap',
            mapId: '60e9ecd14d76dbb3'
        }
        var locLat;
        var locLng;
        var markerLatLng = [];
        var user_id = "<?php echo $_SESSION["lessor_id"] ?>";

        var locationData = {};
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            map = new google.maps.Map(document.getElementById("lessor_map"), mapOptions);
            map.addListener("click", (event) => {
                var contentString =
                    '<div class="p-2"> <h6 class="ff-1"> Confirm Location </h6> <button id="cancelBtn" class="btn btn-danger" onclick="cancelLocation()"> Cancel </button> </div>';
                var infoWindow = new google.maps.InfoWindow({
                    content: contentString,
                    position: myLatLng,
                });


                const markerOptions = {
                    position: event.latLng,
                    map: map
                }
                const marker = new google.maps.Marker(markerOptions);
                locLat = JSON.stringify(event.latLng.toJSON(), null, 2);
                locLng = JSON.parse(locLat);

                locationData.id = user_id;
                locationData.lat = locLng.lat;
                locationData.lng = locLng.lng;
                cancelLocation();
                infoWindow.open(map, marker);
                marker.setMap(map);
                markers.push(marker);

            });
            var lessor_data = JSON.parse(document.getElementById('lessor_data').innerHTML);
            showAllShops(lessor_data);


            function showAllShops(lessor_data) {
                var infoWindow = new google.maps.InfoWindow;

                Array.prototype.forEach.call(lessor_data, function(data) {
                    var content = document.createElement('div');
                    var shopName = document.createElement('h6');
                    var link = document.createElement('a');
                    var element = document.createElement('img');
                    shopName.textContent = data.Name;
                    content.setAttribute("class", "p-0 text-center");
                    link.setAttribute("href", "clientPage.php?lessorid=" + data.lessor_id);
                    element.setAttribute("src", "../assets/img/businessImg/" + data.Banner);
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
                    marker.addListener('mouseover', function() {
                        infoWindow.setContent(content);
                        infoWindow.open(map, marker);
                    });


                });
            }

            const locationButton = document.createElement("button");
            locationButton.setAttribute("class", "btn btn-secondary mx-2 mt-2");
            locationButton.setAttribute("id", "panLocation");
            locationButton.textContent = "Pan to Current Location";
            locationButton.classList.add("custom-map-control-button");

            map.controls[google.maps.ControlPosition.LEFT].push(locationButton);

            const confirmButton = document.createElement("button");
            confirmButton.setAttribute("class", "btn btn-success mx-2 mt-2");
            confirmButton.setAttribute("id", "confirm");
            confirmButton.textContent = "Confirm Location";
            confirmButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.LEFT].push(confirmButton);

            confirmButton.addEventListener("click", () => {
                updateLessorLatLng(locationData);
            });

            locationButton.addEventListener("click", () => {
                getLocation();
            });

            const positionMarker = [];

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                    removeMarkers();
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }

            function showPosition(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                map.setCenter(new google.maps.LatLng(lat, lng));
                map.setZoom(14);
                const marker = new google.maps.Marker({
                    position: {
                        lat: lat,
                        lng: lng
                    },
                    map: map,
                    title: "My Location",
                    animation: google.maps.Animation.BOUNCE
                });
                positionMarker.push(marker);
            }

            function removeMarkers() {
                for (var i = 0; i < positionMarker.length; i++) {
                    positionMarker[i].setMap(null);
                }
            }
        }


        $('#confirmBtn').click(function() {
            updateLessorLatLng(locationData);
        });

        function updateLessorLatLng(LatLng) {
            $.ajax({
                url: "../Model/UpdateLessorLocation.php",
                method: "post",
                data: LatLng,
                success: function(res) {
                    res = "successfully updated your business location";
                    window.location.href = "lessor_location.php?success_insert=" + res;
                },
            });
        }

        var input = document.getElementById("cityInput");
        var options = ['(cities)'];
        var autoComplete = new google.maps.places.Autocomplete(input, options);
        autoComplete.addListener('place_changed', onPlaceChanged);

        // get address value 
        var address = $('#cityInput').val();
        if (address != "") {
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': address
            }, function(results, status) {
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

        function onPlaceChanged() {
            var place = autoComplete.getPlace();
            map.panTo(place.geometry.location);
            map.setZoom(16);
            var latitude = place.geometry.location.lat();
            var longtitude = place.geometry.location.lng();
            // var currLoc = {lat: latitude, lng: longtitude};
        }


    }
    </script>

    <?php
    require_once "footer.php";
?>