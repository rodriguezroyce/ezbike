<?php
    session_start();
    require_once "Page.php";
    load_view("functions");
    load_model("Database");
    load_model("BusinessModel");
    load_model("Lessor");
    load_view("library");
    
    if(isset($_GET["lessorid"]) && isset($_GET["bike_id"])){
        $db = new Database();

        $bike_ids = $_GET["bike_id"];
        $lessor_ids = $_GET["lessorid"];
        $sql = "SELECT lessor_bicycle.lessor_id, lessor_bicycle.bike_id, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.bike_img, lessor_bicycle.bike_condition, lessor_bicyclecomponents.color, lessor_bicyclecomponents.frame, lessor_bicyclecomponents.front_suspension, lessor_bicyclecomponents.rear_derailleur, lessor_bicyclecomponents.brake_levers, lessor_bicyclecomponents.brake_set, lessor_bicyclecomponents.crankset, lessor_bicyclecomponents.cassette, lessor_bicyclecomponents.wheelset, lessor_bicyclerate.bike_dayRate, tblbusiness.Banner FROM lessor_bicycle INNER JOIN lessor_bicyclecomponents ON lessor_bicyclecomponents.bike_id ='$bike_ids' INNER JOIN lessor_bicyclerate ON lessor_bicyclerate.bike_id ='$bike_ids' INNER JOIN tblbusiness ON tblbusiness.lessor_id ='$lessor_ids' WHERE lessor_bicycle.lessor_id ='$lessor_ids' && lessor_bicycle.bike_id ='$bike_ids' && lessor_bicycle.status ='active';";

        $stmt = $db->getConn()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();

        if($stmt->rowCount() == 0){
            redirectTo("show404.php");
        }

    }else{
        redirectTo("search.php");
    }
    if(isset($_GET["requestRideBtn"])){

    
        $bike_id = $_GET["bike_id"];
        $bike_name = $_GET["bike_name"];
        $bike_type = $_GET["bike_type"];
        $bike_brand = $_GET["bike_brand"];
        $bike_img = $_GET["bike_img"];
        $lessor_id = $_GET["lessorid"];
        $rate_type = $_GET["rate_type"];
        $pickup_date = $_GET["startDate"];
        $end_date = $_GET["returnDate"];

        $store_name = $_GET["store_name"];

        date_default_timezone_set('Asia/Manila');
        $start_date = strtotime($pickup_date);
        $return_date = strtotime($end_date);

        $date_input = getDate($start_date);
        $getEndDate = getDate($return_date);


        $parse_start_date = $date_input["year"] . '-' . $date_input["mon"] . '-' . $date_input["mday"];
        $parse_end_date = $getEndDate["year"] . "-" . $getEndDate["mon"] . '-' . $getEndDate["mday"];

        $d1=new DateTime($parse_start_date);
        $d2=new DateTime($parse_end_date);
        $diff=$d1->diff($d2);

        foreach($diff as $key => $values){
            if($key == "days"){
                $totalAmt = $rate_type * $values;
                $days = $values;
                
            }
        }

        if(!empty($pickup_date) && !empty($end_date)){
            redirectTo("payment.php?bike_id=$bike_id&lessorid=$lessor_id&rate_type=$rate_type&startDate=$pickup_date&returnDate=$end_date&totalAmt=$totalAmt&days=$days&bike_name=$bike_name&bike_type=$bike_type&bike_brand=$bike_brand&bike_img=$bike_img&store_name=$store_name");
        }

    }
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
    require_once "header.php";

?>

<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.4/themes/blitzer/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<title> Ezbike | <?= $_GET["store_name"]; ?> </title>
<style>
.start-date {
    background: #000 !important;
    color: #fff !important;
}

.active {
    background: #000 !important;
}

td.today.active {
    background: #000 !important;
}

.end-date {
    background: #FF0000 !important;
    color: #fff !important;
}
</style>
</head>

<body>
    <div class="container">
        <?php
        include_once "navigation.php";
    ?>
    </div>
    <div class="container-fluid">
        <div class="container mt-1 p-2">
            <div class="path text-secondary fs-14 px-4">
                <a class="text-secondary" href="search.php">search</a> / <a class="text-secondary"
                    href="clientPage.php?lessorid=<?= $_GET["lessorid"] ?>"><?= $_GET["store_name"] ?></a> / <a
                    class="text-dark border-bottom border-2"
                    href="productItem.php?lessorid=<?= $_GET["lessorid"]?>&bike_id=<?= $_GET["bike_id"] ?>&store_name=<?= $_GET["store_name"] ?>">
                    <?= $row["bike_name"] ?>
                </a>
            </div>
            <div id="booking-page">
                <div class="col-md-8 p-3" id="product-info">
                    <div class="product_container" id="main-item">
                        <img class="product_item" src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" alt="">
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 text-center">
                            <img class="rounded_item shadow p-1 mt-2"
                                src="../assets/img/businessImg/<?php echo $row["Banner"] ?>" id="shop-banner" alt="">
                        </div>
                        <div class="col-md-7 mt-2" id="bike-brand">
                            <h4 class="ff-1 fw-bold"><?php echo $row["bike_name"] ?> • <?php echo $row["bike_brand"] ?>
                            </h4>
                            <h4 class="ff-1 fw-bold"><?= $row["bike_type"] ?></h4>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-12 mt-4 mx-2 bg-white p-4 fs-13 shadow">
                            <h5 class="ff-6 fw-bold">Full Specifications</h5>
                            <div class="row" id="specification">
                                <div class="col-md-6">
                                    <p><span>Color:</span> <?= $row["color"] ?></p>
                                    <p><span>Frame:</span> <?= $row["frame"] ?></p>
                                    <p><span>Front Suspension:</span> <?= $row["front_suspension"] ?></p>
                                    <p><span>Rear Derailleur:</span> <?= $row["rear_derailleur"] ?></p>
                                    <p><span>Wheelset:</span> <?= $row["wheelset"] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Brake Levers:</span> <?= $row["brake_levers"]?></p>
                                    <p><span>Brake Set:</span> <?= $row["brake_set"] ?></p>
                                    <p><span>Crankset:</span> <?= $row["crankset"] ?></p>
                                    <p><span>Cassette:</span> <?= $row["cassette"]?></p>
                                </div>
                            </div>

                        </div>
                        <!-- map -->
                        <div class="mt-4 mx-2" id="lessormap">

                        </div>
                        <?php
                            $locationLatLng = new BusinessModel();
                            $itemdata = $locationLatLng->getSpecificLocation($_GET["lessorid"]);
                            $itemdata = json_encode($itemdata, true);
                            echo '<div id="itemdata">' . $itemdata .  '</div>';
                        ?>
                    </div>

                </div>
                <div class="col-md-4 pt-4 p-2" id="booking-info">
                    <div class="bg-white p-4 shadow rounded" id="booking-container">
                        <div class="product_container" id="booking-item">
                            <img class="product_item" src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" alt="">
                        </div>
                        <h4>Booking Information</h4>
                        <div class="d-flex justify-content-between align-items-center ff-4">
                            <div>
                                <h5 class="text-indigo">₱ <?= number_format($row["bike_dayRate"],"2")?> <span
                                        class="text-dark fw-lighter fs-14"> Per day </span></h5>
                                <input type="hidden" id="booking_rate" value="<?= $row["bike_dayRate"] ?>">
                            </div>
                        </div>
                        <div>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET"
                                enctype="multipart/form-data">
                                <div>
                                    <label for="setBookings">Dates</label>
                                    <input class="form-control" type="text" id="daterange" readonly="true" value="" />
                                    <div id="date_error">

                                    </div>
                                    <input type="hidden" name="startDate" id="fromDate">
                                    <input type="hidden" name="returnDate" id="returnDate">
                                </div>
                                <div class="mt-3 border-bottom border-2">
                                    <div id="validation_date" class="text-danger">

                                    </div>
                                    <h5 class="ff-2">Booking Overview </h5>
                                    <div class="d-flex justify-content-between border-bottom border-1">
                                        <div class="fw-normal">
                                            Rate
                                        </div>
                                        <div id="rate">
                                            ₱ <?= number_format($row["bike_dayRate"], "2") ?>
                                        </div>
                                    </div>
                                    <div id="days-block"
                                        class="d-flex justify-content-between border-bottom border-1 py-1">
                                        <div class="fw-normal">
                                            Days
                                        </div>
                                        <div id="days">

                                        </div>
                                    </div>
                                    <div id="subtotal-block"
                                        class="d-flex justify-content-between border-bottom border-1 py-1">
                                        <div class="fw-bold">
                                            Subtotal
                                        </div>
                                        <div id="subtotal">

                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <input type="hidden" name="lessorid" value="<?= $lessor_ids ?>">
                                    <input type="hidden" name="bike_id" value="<?= $bike_ids ?>">
                                    <input type="hidden" name="bike_name" value="<?= $row["bike_name"] ?>">
                                    <input type="hidden" name="bike_type" value="<?= $row["bike_type"] ?>">
                                    <input type="hidden" name="bike_brand" value="<?= $row["bike_brand"] ?>">
                                    <input type="hidden" name="bike_img" value="<?= $row["bike_img"] ?>">
                                    <input type="hidden" id="rate_type" name="rate_type"
                                        value="<?= $row["bike_dayRate"] ?>">
                                    <input type="hidden" name="store_name" value="<?= $_GET["store_name"] ?>">


                                    <button id="btnRequest" type="submit" class="btn btn-indigo w-100"
                                        name="requestRideBtn"> Request this ride </button>
                                    <!-- Button trigger modal -->
                                </div>

                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <?php
        require_once "viewFooter.php";
    ?>
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
    $(function() {

        let fromdate;
        let todate;
        let dateRange = $('#daterange');
        let subtotal = $('#subtotal');
        let rateType = $('#rate_type').val();
        let btnRequest = $('#btnRequest');

        let subtotal_block = $('#subtotal-block');
        let days_block = $('#days-block');

        let date_error = $('#date_error');

        // date start and to
        let startDate;
        let endDate;

        btnRequest.prop("disabled", true);


        console.log(rateType);

        var date = new Date();

        function parseDate(str) {
            var mdy = str.split('-');
            return new Date(mdy[2], mdy[0] - 1, mdy[1]);
        }

        function datediff(first, second) {
            // Take the difference between the dates and divide by milliseconds per day.
            // Round to nearest whole number to deal with DST.
            return Math.round((second - first) / (1000 * 60 * 60 * 24));
        }
        $('#daterange').daterangepicker({
            opens: 'left',
            minDate: date
        }, function(start, end, label) {

            let days = datediff(parseDate(start.format('MM-DD-YYYY')), parseDate(end.format(
                'MM-DD-YYYY')));

            startDate = start.format('MM-DD-YYYY');
            endDate = end.format('MM-DD-YYYY');

            if (startDate == endDate && days == 0) {
                btnRequest.prop("disabled", true);
                date_error.html(
                    "<p class=\"text-danger fs-13\"> return date should not be the same as pick-up date </p>"
                    );
                date_error.show();
                let total = (rateType * days);
                if (days > 1) {
                    $dayString = "days";
                } else {
                    $dayString = "day";
                }
                $('#days').html('');
                $('#subtotal').html('');
            } else {
                date_error.hide();
                $('#fromDate').val(start.format('YYYY-MM-DD'));
                $('#returnDate').val(end.format('YYYY-MM-DD'));
                if (dateRange != null) {
                    btnRequest.prop("disabled", false);
                    let total = (rateType * days);
                    console.log(total);
                    if (days > 1) {
                        $dayString = "days";
                    } else {
                        $dayString = "day";
                    }

                    document.getElementById("days").innerHTML = days + ' (' + $dayString + ')';
                    $('#subtotal').html('₱' + addCommas(total));
                }
            }

            function addCommas(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        });





    });
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places&callback=initMap">
    </script>
    <script>
    let map;
    let geocoder;

    function initMap() {
        var itemdata = JSON.parse(document.getElementById('itemdata').innerHTML);
        showAllShops(itemdata);

        var lessorLat = itemdata[0].lat;
        var lessorLng = itemdata[0].lng;
        console.log(lessorLat);
        console.log(lessorLng);

        var myLatLng = {
            lat: +lessorLat,
            lng: +lessorLng
        };
        var mapOptions = {
            center: myLatLng,
            zoom: 13,
            mapTypeId: 'roadmap',
            mapId: '60e9ecd14d76dbb3'

        }
        map = new google.maps.Map(document.getElementById("lessormap"), mapOptions);
        marker = new google.maps.Marker({
            position: myLatLng,
            map,
            title: "our location",
            icon: "../assets/img/ezbike_icon.png"

        });
        marker.setMap(map);
        // showAllShops

        function showAllShops(itemdata) {
            var infoWindow = new google.maps.InfoWindow;

            Array.prototype.forEach.call(itemdata, function(data) {
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
    }
    </script>

    <?php
        require_once "footer.php";
    ?>