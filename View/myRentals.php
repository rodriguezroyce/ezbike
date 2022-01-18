<?php
    session_start();

    require_once "Page.php";

    load_model("Database");
    load_model('Bicycle');
    load_model('Registration');

    require_once "library.php";
    require_once "barangay.php";
    load_view("functions");

    if(!isset($_SESSION["User_id"])){
        redirectTo("../index.php");
    }
    load_view("header");

    if(isset($_SESSION["shopping_cart"])){
        $bike_id = $_SESSION["shopping_cart"]["bike_id"];
        $lessor_id = $_SESSION["shopping_cart"]["lessorid"];
        $rate_type = $_SESSION["shopping_cart"]["rate_type"];
        $pickup_date = $_SESSION["shopping_cart"]["startDate"];
        $end_date = $_SESSION["shopping_cart"]["returnDate"];
        $totalAmt = $_SESSION["shopping_cart"]["totalAmt"];
        $days = $_SESSION["shopping_cart"]["days"];
        $bike_name = $_SESSION["shopping_cart"]["bike_name"];
        $bike_type = $_SESSION["shopping_cart"]["bike_type"];
        $bike_brand = $_SESSION["shopping_cart"]["bike_brand"];
        $bike_img = $_SESSION["shopping_cart"]["bike_img"];
    }

?>
<title> My Account | Ezbike </title>
</head>

<body>
    <?php
        include_once "messenger.php";
    ?>
    <div class="container">
        <?php
            include_once "navigation.php";
        ?>
        <div class="row p-4 mb-5">
            <div class="col-md-3 p-5 border-end">
                <h3 class="mb-4"><i class="fas fa-cog"></i> Settings</h3>
                <ul class="p-0">
                    <li class="mt-1 mb-2"><a href="myAccount.php"><i class="fas fa-shield-alt"></i> Account Settings</a>
                    </li>
                    <li class="mt-1 mb-2"><a href="myRentals.php"><i class="fas fa-book-open"></i> My Rentals</a></li>
                </ul>
            </div>
            <div class="col-md-9 p-5">
                <h3 class="mt-5">My Rentals</h3>
                <span class="text-danger"><?php if(isset($_GET["msg"])){
                        echo $_GET["msg"];
                    }else if(isset($_GET["success"])){
                        echo "<span class=\"text-success\"> {$_GET["success"]} </span>";
                    } ?> </span>
                <div class="row">
                    <!-- table -->
                    <table class="table fs-11">
                        <thead>
                            <th width="10%">Payment Id</th>
                            <th width="10%">Bike Id</th>
                            <th width="10%">Bike Description</th>
                            <th width="10%">Bike Img</th>
                            <th width="10%">Pick-up Date</th>
                            <th width="10%">Return Date</th>
                            <th width="10%">Status</th>
                            <th width="10%">Total Amount</th>
                            <th width="10%">Date</th>
                            <th width="10%">Shop Info</th>
                        </thead>
                        <tbody>
                            <?php
                                    $db = new Database();
                                    $sql = "SELECT lessor_payment.payment_id,lessor_payment.bike_id, lessor_payment.lessor_id ,lessor_payment.bike_description, lessor_payment.bike_img, lessor_payment.pickup_date, lessor_payment.return_date, lessor_payment.total_amt, lessor_payment.date, lessor_bicycle.status, tblbusiness.lessor_id,tblbusiness.Name,tblbusiness.Banner, tblbusiness.Address_Line1,tblbusiness.Address_Line2,tblbusiness.Region,tblbusiness.Province,tblbusiness.City,tblbusiness.Barangay,tblbusiness.Zip_Code,tblbusiness.lat,tblbusiness.lng FROM `lessor_payment` INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_payment.bike_id INNER JOIN `tblbusiness` ON tblbusiness.lessor_id = lessor_payment.lessor_id WHERE `user_id`=:USER_ID";
                                    $stmt = $db->getConn()->prepare($sql);
                                    $stmt->bindValue(':USER_ID', $_SESSION["User_id"], PDO::PARAM_INT);
                                    $stmt->execute();
    
                                    while($row = $stmt->fetch()){   
                                ?>
                            <tr>
                                <td width="11%"><?= $row["payment_id"] ?></td>
                                <td width="11%"><?= $row["bike_id"] ?></td>
                                <td width="11%"><?= $row["bike_description"] ?></td>
                                <td width="11%"><img class="logo" src="../assets/img/uploads/<?= $row["bike_img"] ?>"
                                        alt=""></td>
                                <td width="11%"><?= $row["pickup_date"]?></td>
                                <td width="11%" nowrap>
                                    <p class="bg-danger text-light rounded p-1"><?= $row["return_date"]?></p>
                                </td>
                                <?php
                                        if($row["status"] == "booked"){
                                    ?>
                                <td width="11%">
                                    <p class="bg-dark text-light p-1"><?= $row["status"] ?></p>
                                </td>

                                <?php
                                        }else if($row["status"] == "in-used"){
                                    ?>
                                <td width="11%">
                                    <p class="bg-primary text-light p-1"><?= $row["status"] ?></p>
                                </td>

                                <?php
                                        }else{
                                    ?>
                                <td width="11%">
                                    <p class="bg-success text-light p-1"> Returned</p>
                                </td>
                                <?php
                                        }
                                    ?>
                                <td width="11%">₱<?= number_format($row["total_amt"],"2") ?></td>
                                <td width="11%"><?= $row["date"]?></td>
                                <td nowrap>
                                    <button class="btn btn-light fs-10" data-bs-toggle="modal"
                                        data-bs-target="#shopId<?= $row["payment_id"]?>">View info</button>
                                    <div class="modal" id="shopId<?= $row["payment_id"] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Shop Information</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php                                                           
                                                            $db2_row = [];
                                                            $db2_row["lat"] = $row["lat"];
                                                            $db2_row["lng"] = $row["lng"];
                                                            $db2_row["Name"] = $row["Name"];
                                                            $db2_row["Banner"] = $row["Banner"];
                                                            $db2_row["lessor_id"] = $row["lessor_id"];
                                                            $db2_row["payment_id"] = $row["payment_id"];

                                                            $pid = $row["payment_id"];
                                                            foreach($barangay as $key => $value){
                                                                if($key == $row["Barangay"]){
                                                                    $mybarangay = $value;
                                                                }
                                                            }
           
                                                            $itemdata = json_encode($db2_row, true);
                                                            echo "<div id=\"rentdata\" class=\"rentdata\"> $itemdata </div>";
                                                        ?>
                                                    <div class="row pb-1 mb-2">
                                                        <div class="col-md-3">
                                                            <img src="../assets/img/businessImg/<?= $row["Banner"]?>"
                                                                alt="" class="img-fluid">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <h6><?= $row["Name"] ?></h6>
                                                            <p class="mb-0">
                                                                <?= $row["Address_Line1"] . " " . $row["Address_Line2"] ?>
                                                            </p>
                                                            <?php


                                                                        foreach($province as $key => $value){
                                                                            if($key == $row["Province"]){
                                                                                $prov = $value;
                                                                            }
                                                                        }
                                                                        foreach($city as $key => $value){
                                                                            if($key == $row["City"]){
                                                                                $store_city = $value;
                                                                            }
                                                                        }
                                                    
                                                            
                                                                    ?>
                                                            <p> <?= "<span class=\"fw-bolder\">" .  $prov . ",</span> " . $store_city . " " .$mybarangay ?>
                                                            </p>
                                                            <!-- <button class="btn btn-success" onclick="calcRoute()">Directions</button> -->

                                                        </div>

                                                    </div>
                                                    <div id="rentmap<?=$pid?>" class="rentmaps"> </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <a class="btn btn-primary"
                                                        href="clientPage.php?lessorid=<?= $row["lessor_id"] ?>">Visit
                                                        Shop</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                    }
                                ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <script>
    $(function() {
        $('table').DataTable({
            dom: 'Bfrtip',
            "searching": true,
            "paging": true,
            "order": [
                [0, "desc"]
            ],
            "ordering": true,
            "columnDefs": [{
                    "targets": [3],
                    /* column index */
                    "orderable": false
                },
                {
                    "targets": [1],
                    "visible": true,
                    "searchable": true
                }
            ],
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ]
        });
        $('.buttons-csv').css("background", "#fff");
        $('.buttons-csv span').prepend('<i class="fas fa-file-csv p-1"> </i>');
        $('.buttons-excel').css("background", "green");
        $('.buttons-excel').css("color", "#fff");
        $('.buttons-excel span').prepend('<i class="fas fa-file-excel p-1"> </i>');
        $('.buttons-pdf').css("background", "red");
        $('.buttons-pdf').css('color', "#fff");
        $('.buttons-pdf span').prepend('<i class="fas fa-file-pdf p-1"> </i>');
        $('.buttons-print span').prepend('<i class="fas fa-print p-1"> </i>');
        $('.dataTables_wrapper .dataTables_filter input').addClass("form-control");
        $('label').addClass('d-flex align-items-center mb-2 mx-2');
        $('table tr td').css("vertical-align", "middle");
        $('table tr th').css("vertical-align", "middle");


    });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places">
    </script>

    <script type="text/javascript">
    let map;
    let geocoder;
    let arrData = {};
    let mapData = {};
    let myLocation = {};
    let directionsDisplay;
    let maps;
    // function initMap(){
    var itemdata = JSON.parse(document.getElementById("rentdata").innerHTML);
    $('.rentdata').each(function(index) {
        arrData[index] = JSON.parse($(this).html());
        mapData[index] = "rentmap" + arrData[index].payment_id;
    });
    // autocomplete function
    var input = document.getElementById("cityInput");
    var options = ['(cities)'];
    var autoComplete = new google.maps.places.Autocomplete(input, options);
    autoComplete.addListener('place_changed', onPlaceChanged);

    function onPlaceChanged() {
        for (var i = 0; i < Object.keys(arrData).length; i++) {
            var place = autoComplete.getPlace();
            mapData[i].panTo(place.geometry.location);
            mapData[i].setZoom(16);
            var latitude = place.geometry.location.lat();
            var longtitude = place.geometry.location.lng();
        }

        // var currLoc = {lat: latitude, lng: longtitude};
    }


    for (var i = 0; i < Object.keys(arrData).length; i++) {
        var latLngs = {
            lat: +arrData[i].lat,
            lng: +arrData[i].lng
        };
        var mapOptions = {
            center: latLngs,
            zoom: 13,
            mapTypeId: 'terrain',
            mapId: '60e9ecd14d76dbb3'

        }


        mapData[i] = new google.maps.Map(document.getElementById(mapData[i]), mapOptions);
        mapData[i].addListener("click", function(mapsMouseEvent) {
            const markers = new google.maps.Marker({
                position: mapsMouseEvent.latLng,
                map: mapData[i]
            });
            myLocation.lat = mapsMouseEvent.latLng.lat();
            myLocation.lng = mapsMouseEvent.latLng.lng();
            console.log(myLocation);
        });


        const shopdata = '<div class="p-1 fw-bolder">' + arrData[i].Name +
            ' </div> <div class="p-0"> <img style="width: 100%; height: 120px;" src=../assets/img/businessImg/' +
            arrData[i].Banner + '> </div>';
        const infoWindow = new google.maps.InfoWindow({
            content: shopdata
        });
        const myMarker = new google.maps.Marker({
            position: latLngs,
            map: mapData[i],
            title: arrData[i].Name,
            icon: "../assets/img/ezbike_icon.png"
        });
        myMarker.addListener("mouseover", () => {
            infoWindow.open({
                anchor: myMarker,
                map: mapData[i],
                shouldFocus: false
            });
        });

        var directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        directionsDisplay.setMap(mapData[i]);

        function calcRoute() {
            var request = {
                origin: myLocation,
                destination: latLngs,
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC
            }

            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    console.log(result);
                    directionsDisplay.setDirections(result);

                    window.alert(result.routes[0].legs[0].distance.text);
                }
            });

        }
    }


    // }
    </script>
    <?php
    load_view("viewFooter");
    load_view("footer");
?>