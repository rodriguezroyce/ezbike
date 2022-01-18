<?php
    session_start();
    require_once "functions.php";
    require_once "../Model/Database.php";
    require_once "../Model/BusinessModel.php";
    if(isset($_GET["location_search"])){
       $location = $_GET["location"];
       echo $_GET["location_search"];
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
<title>Ezbike | Search Location</title>
</head>

<body>
    <div class="container-fluid">
        <?php
            include_once "navigation.php";
        ?>
    </div>
    <div class="main-section">
        <div class="column-5">
            <!-- map -->
            <div id="map"></div>
            <?php
                    $locationLatLng = new BusinessModel();
                    $alldata = $locationLatLng->getAllShops();
                    $alldata = json_encode($alldata, true);
                    echo '<div id="mydata">' . $alldata .  '</div>';
                ?>
        </div>
        <div class="column-7">
            <div class="column7-inside" id="column7-inside">

            </div>

        </div>
    </div>
    </div>

    <script type="text/javascript">
    $(() => {
        var cityInput = $('#cityInput');

        $('.client-content a > .merchant-photo').css("filter", "blur(1px)");
        $('.top').mouseover(() => {
            $('.merchant-photo').css("filter", "blur(0px)");
            $('.merchant-photo').css("transition", "all 0.5s ease");
        });
        $('.top').mouseout(() => {
            $('.merchant-photo').css("filter", "blur(1px)");
        });
        $('.btn-search').click(() => {
            cityInput.show("fast");

        });
        $('.form-control').css("border-radius", "0");
        if ($(window).innerWidth() <= 414) {
            $('#navbar').removeClass("flex-row");
            $('#navbar').addClass("flex-column");

        }
    });
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places&callback=initMap">
    </script>
    <script src="../assets/js/search.js"></script>
    <?php
        require_once "footer.php";
    ?>