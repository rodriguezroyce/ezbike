<?php
    session_start();
    require_once "functions.php";
    require_once "../Model/Database.php";
    require_once "../Model/AdminLogin.php";
    require_once "../Model/BusinessModel.php";
    require_once "../Model/Lessor.php";
    require_once "library.php";
    if(!isset($_SESSION["admin_username"])){
        redirectTo("adminLogin.php?validation_error=SESSION TIMEOUT!");
    }
    $error_msg = null;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["btnAddLessor"])){

            $lessor = new Lessor();
            $lessor->setFirstName(validate($_POST["first_name"]));
            $lessor->setLastName(validate($_POST["last_name"]));
            $lessor->setEmail(validate($_POST["lessor_email"]));
            $lessor->setPhone(validate($_POST["lessor_phone"]));



            try{

                if(!filter_var($lessor->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    throw new Exception($validation_errors[0]);
                }else if(strlen($lessor->getPhone()) !=10){
                    throw new Exception($validation_errors[1]);
                }else if(checkLessorEmailExists($lessor->getEmail())){
                    throw new Exception($validation_errors[2]);
                }else if(checkLessorPhoneExists($lessor->getPhone())){
                    throw new Exception($validation_errors[3]);
                }else{
                    $lessor->insertNewLessor($lessor->getFirstName(),$lessor->getLastName(), $lessor->getEmail(), $lessor->getPhone());
                    
                }
            }catch(Exception $e){
                $error_msg = $e->getMessage();
            }
        }
        if(isset($_POST["adminBtn"])){
            $admin = new AdminLogin();
            $admin->setUsername(validate($_POST["admin_username"]));
            $admin->setPassword(validate($_POST["admin_password"]));
            $admin->setPasswordConfirm(validate($_POST["admin_passwordConfirm"]));
            if(empty($admin->getPassword()) || empty($admin->getPasswordConfirm()) || empty($admin->getUsername())){
                redirectTo("admin_management.php?admin_error=Please fill out all the remaining fields.");
            }else if($admin->passwordMatch()){
                $admin->insertAdmin();
            }else{
                redirectTo("admin_management.php?admin_error=password does not match");
            }
        }

    }
    require_once "admin_header.php";
?>
<div class="container-fluid">
    <main class="row">
        <div class="col-md-2 bg-white shadow rounded">
            <div class="text-center mt-2">
                <a href="adminDashboard.php">
                    <img class="logo" src="../assets/img/ezbike.png" alt="">
                </a>

            </div>
            <ul class="navleft-menu">
                <li>
                    <a href="adminDashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="admin_bicycleList.php"><i class="fas fa-bicycle"></i> Bicycle List</a>
                </li>
                <li>
                    <a href="admin_bicycleRequest.php"><i class="fas fa-bicycle"></i> Bicycle Request</a>
                </li>
                <li>
                    <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a>
                </li>
                <li><a href="revenue.php"><i class="fas fa-money-check-alt"></i> Revenue</a></li>
                <li>
                <li>
                    <!-- <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a> -->
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">

                                <a class="text-secondary fw-light" href="admin_transactions.php" class="collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne"><i class="fas fa-users"></i>&nbsp;Feedback</a>

                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0">
                                    <ul class="px-1">
                                        <li>
                                            <a href="admin_reviews.php"> <i class="fas fa-star"></i> Reviews</a>
                                        </li>
                                        <li>
                                            <a href="admin_reports.php"><i class="fas fa-flag"></i> Reports</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>
                <li>
                    <a class="active" href="admin_location.php"><i class="ti-map-alt"></i>&nbsp; Location</a>
                </li>
                <li>
                    <div class="accordion accordion-flush" id="admin_lessors">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">

                                <a class="text-secondary fw-light" href="#" class="collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseOne"><i class="ti-user"></i>&nbsp;User Management</a>

                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#admin_lessors">
                                <div class="accordion-body p-0">
                                    <ul class="px-1">
                                        <li>
                                            <a href="admin_users.php"> <i class="fas fa-users"></i> Users</a>
                                        </li>
                                        <li>
                                            <a href="admin_lessors.php"><i class="fas fa-user"></i> Lessors</a>
                                        </li>
                                        <li>
                                            <a href="admin.php"><i class="ti-user"></i> Admin</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`

                </li>

            </ul>
        </div>
        <div class="col-md-10 bg-light-strong">
            <div class="row">
                <?php
                        include_once "admin_navbar.php";
                    ?>
                <div class="col-md-12">
                    <h4>Location</h4>
                    <?php
                            $locationLatLng = new BusinessModel();
                            $row = $locationLatLng->getLocationLatLng();

                            $parseData = json_encode($row, true);
                            echo '<div id="data">' . $parseData .  '</div>';

                            $allData = $locationLatLng->getAllShops();
                            $allData = json_encode($allData, true);
                            echo '<div id="alldata">' . $allData .  '</div>';
                        ?>
                    <div id="admin_map"></div>
                </div>
            </div>
        </div>
    </main>
</div>
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places&callback=initMap">
</script>
<script>
let map;
let searchPlace;
var geocorder;

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
    map = new google.maps.Map(document.getElementById("admin_map"), mapOptions);
    marker = new google.maps.Marker({
        position: myLatLng,
        map,

    });
    marker.setMap(map);
    var cdata = JSON.parse(document.getElementById('data').innerHTML);

    // showAllShops
    var allData = JSON.parse(document.getElementById('alldata').innerHTML);
    showAllShops(allData);

    function showAllShops(allData) {
        var infoWindow = new google.maps.InfoWindow;

        Array.prototype.forEach.call(allData, function(data) {
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
    var submit = $('#submit');
    var newValue = "";
    searchPlace = $('#searchPlace').val();
    if (searchPlace != "") {
        fetch('https://maps.googleapis.com/maps/api/geocode/json?address=' + searchPlace +
                '+PH&key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q')
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                console.log(data["results"][0]["geometry"]["location"]);
                var searchLat = data["results"][0]["geometry"]["location"]["lat"];
                var searchLng = data["results"][0]["geometry"]["location"]["lng"];
                var myLatLng = {
                    lat: searchLat,
                    lng: searchLng
                };
                map.setCenter(myLatLng);
                map.setZoom(15);
            })
    } else {
        submit.click(function(e) {
            e.preventDefault();
            searchPlace = $('#searchPlace').val();
            console.log(searchPlace);
            fetch('https://maps.googleapis.com/maps/api/geocode/json?address=' + searchPlace +
                    '+PH&key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q')
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    console.log(data["results"][0]["geometry"]["location"]);
                    var searchLat = data["results"][0]["geometry"]["location"]["lat"];
                    var searchLng = data["results"][0]["geometry"]["location"]["lng"];
                    var myLatLng = {
                        lat: searchLat,
                        lng: searchLng
                    };
                    map.setCenter(myLatLng);
                    map.setZoom(15);
                })

        });
    }



}
</script>

<script>
$(function() {
    var clickCount = 0;
    $('#dropdownMenuButton').click(function() {
        clickCount++;
        if (clickCount % 2 == 0) {
            $('.dropdown-menu').fadeOut("fast");
        } else {
            $('.dropdown-menu').fadeIn("slow");
            $('.dropdown-menu').mouseover(() => {
                $('.dropdown-menu').show("fast");

            });
        }


    });
});
</script>
<?php
    require_once "footer.php";
?>