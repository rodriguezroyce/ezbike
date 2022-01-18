<?php
    session_start();

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Ezbike is an Online Bicycle Rental Services that allows users to borrow bicycle to our platform.">
    <meta name="keywords" content="Ezbike | Online Bicycle Rental System | Bicycle Rental">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&family=Padauk&family=Palanquin&display=swap"
        rel="stylesheet">
    <!-- <script src="//code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/themify-icons.css">
    <title>Ezbike | Bicycle Rental</title>
</head>

<body>
    <div class="container-fluid">
        <header class="showcase">
            <div class="showcase-content">
                <div class="container" id="main-container">
                    <nav class="d-flex flex-row align-items-center p-3 border-bottom pb-1">
                        <div class="col-md-3" id="nav-left">
                            <button class="btn">
                                <a class="text-light" href="index.php#howtorent">How to rent</a>
                            </button>
                            <button class="btn searchBtn">
                                <i class="ti-search text-light"></i>
                            </button>
                        </div>
                        <div class="col-md-6 text-light text-center" id="logo_container">
                            <a class="text-light" href="index.php">
                                <img class="logo" src="./assets/img/ezbike_transparent.png" alt="">
                            </a>
                        </div>
                        <div class="col-md-3" id="nav-right">
                            <ul class="main-navbar pt-3">
                                <?php
                                    if(isset($_SESSION["Email"])){
                                        echo "<li> <a class=\"btn-indigo text-light\" href=\"./View/myAccount.php\">" . $_SESSION["FirstName"]. "</a></li>";
                                        echo "<li> <a class=\"text-light fs-13\" href=\"./View/logout.php\"> Logout </a></li>";
                                        if(isset($_SESSION["shopping_cart"])){
                                            echo "<li> <a class=\"text-light fs-13\" href=\"./View/payment.php?bike_id=$bike_id&lessorid=$lessor_id&rate_type=$rate_type&startDate=$pickup_date&returnDate=$end_date&totalAmt=$totalAmt&days=$days&bike_name=$bike_name&bike_type=$bike_type&bike_brand=$bike_brand&bike_img=$bike_img\"> <i class=\"ti-shopping-cart\"> </i> </a></li>";
                                        }else{
                                            echo "<li> <a class=\"text-light\" href=\"./View/payment.php\"> <i class=\"ti-shopping-cart\"> </i> </a> <li>";
                                        }

                                    }else{
                                ?>
                                <li><a id="login" class="text-light" style="border: none;" href="./View/login.php">Log
                                        in</i></a></li>
                                <li><a class="text-light" href="./View/userRegistration.php">Sign up</a></li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </nav>
                    <section class="landing-page">
                        <div class="text-light text-center">
                            <h1 class="display-1">RENT A BIKE</h1>
                            <p class="ff-1 fs-21 ls-1">CRAZY BIKE FOR CRAZY RIDING</p>
                        </div>
                        <div>
                            <form action="./View/search.php" method="GET">
                                <div class="d-flex" id="form-search">
                                    <input name="location" class="form-control" id="location-input" type="text"
                                        placeholder="Where do you want to rent?">
                                    <button name="location_search" type="submit"
                                        class="btn btn-indigo d-flex align-items-center px-4 pt-2 pb-2"> <i
                                            class="fas fa-search"></i>
                                        <p class="mb-0">Search</p>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </header>
        <div class="container" id="howtorent_container">
            <div class="mt-5 mb-4" id="howtorent">
                <h3 id="howtorent_header">How to rent</h3>
            </div>
            <div class="d-flex flex-wrap gx-3">
                <!-- search location box -->
                <div class="col rent-box">
                    <div class="rent-box-icon">
                        <i class="fas fa-search-location fa-2x text-success"></i>
                    </div>
                    <div class="rent-box-content">
                        <h5>Search Location</h5>
                        <p class="text-secondary">Step 1</p>
                        <p>find a location nearby using the search button and locate the store you want to browse in the
                            map.</p>
                    </div>
                </div>
                <!-- bicycle store box -->
                <div class="col rent-box">
                    <div class="rent-box-icon">
                        <i class="far fa-hand-pointer fa-2x text-primary"></i>
                    </div>
                    <div class="rent-box-content">
                        <h5>Select Bicycle Store</h5>
                        <p class="text-secondary">Step 2</p>
                        <p>List of bicycle store will appear upon searching bicycle store nearby upon 8km radius from
                            the center of the map.</p>
                    </div>
                </div>
                <!-- bicycle box -->
                <div class="col rent-box">
                    <div class="rent-box-icon">
                        <i class="fas fa-bicycle fa-2x text-danger"></i>
                    </div>
                    <div class="rent-box-content">
                        <h5>Select Bicycle</h5>
                        <p class="text-secondary">Step 3</p>
                        <p>Select the bicycle of choice by scrolling or filtering the bike by its bicycle type, rates
                            and by the date uploaded.</p>
                    </div>
                </div>
            </div>
            <!-- login signup box -->
            <div class="d-flex mt-3 justify-content-center">
                <div class="col rent-box">
                    <div class="rent-box-icon">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                    <div class="rent-box-content">
                        <h5>Login / Signup</h5>
                        <p class="text-secondary">Step 4</p>
                        <p>To begin the transactions. The user must be logged on to proceed the payment. </p>
                    </div>
                </div>
                <!-- booking box -->
                <div class="col rent-box">
                    <div class="rent-box-icon">
                        <i class="fas fa-book fa-2x text-info"></i>
                    </div>
                    <div class="rent-box-content">
                        <h5>Booking</h5>
                        <p class="text-secondary">Step 5</p>
                        <p>The user must provide the booking information such as rates, pick-up date and valid id of the
                            renter. </p>
                    </div>
                </div>
                <!-- payment box -->
                <div class="col rent-box">
                    <div class="rent-box-icon">
                        <i class="far fa-credit-card text-warning fa-2x"></i>
                    </div>
                    <div class="rent-box-content">
                        <h5>Payment</h5>
                        <p class="text-secondary">Step 6</p>
                        <p>The user must provide the booking information such as rates, pick-up date and valid id of the
                            renter. </p>
                    </div>
                </div>
            </div>
        </div>
        <main class="web-wash p-4 text-center bg-white" id="howItWorks">
            <div class="container">
                <div class="d-flex flex-row align-items-center py-4" id="whyus">
                    <!-- bike image -->
                    <div class="col-md-6">
                        <img class="img-fluid" src="./assets/img/bike-1.jpg" alt="">
                    </div>
                    <!-- accordion -->
                    <div class="col-md-6">
                        <h1 class="ff-1 fw-bolder mb-4">Why Choose Us?</h1>
                        <div class="accordion rounded shadow" id="accordionPanelsStayOpenExample">
                            <!-- 1st accordion item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne">
                                        COST EFFECTIVE SOLUTION
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <p>By renting out for the day. You will be able to use your favorite bicycle
                                            through the </p>
                                    </div>
                                </div>
                                <!-- 2nd accordion items -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            EASY AND QUICK NEARBY FIND STORES
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingTwo">
                                        <div class="accordion-body">
                                            <p>With the help of our map locator. You will be able to find different
                                                bicycle stores in different location upon searching and view their
                                                bicycles information by its specification and price.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- 3rd accordion items -->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-2 text-light" id="places">
                    <h3 class="text-dark mb-4 text-start px-0" id="place_header">Feel free to travel the world</h3>
                    <?php include_once "./ViewModel/Places.php" ?>
                    <!-- 3rd row -->
                </div>
            </div>
        </main>
        <div class="container-fluid mt-4">
            <div class="bg-indigo about_us text-light">
                <div class="container py-4">
                    <div class="d-flex align-items-center" id="about_us">
                        <div class="col text-center">
                            <img class="about_logo" src="./assets/img/ezbike.png" alt="">
                        </div>
                        <div class="col">
                            <h3 id="about_title">About Us</h3>
                            <p id="about_p1">Ezbike is a premier bike rental and sharing service that provides a
                                platform to connect bicycle store owners or entrepreneurial to active people looking to
                                rent or borrow around the Philippines. Through our service, store owners list their
                                bicycles in their page and renters search a bicycle through their store and complete the
                                rental process easily through our website.</p>
                            <p id="about_p2">With Ezbike you can have fun with your friends or love ones and enjoy the
                                ride by renting bikes in our platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer py-3 pb-2 mt-4">
            <div class="container p-0" id="footer-container">
                <div class="row" id="footer-content">
                    <div class="col-4 footer-bg rounded shadow" id="learn_more">
                        <div class="row p-4">
                            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                                <i class="fab fa-youtube fa-2x"></i>
                            </div>
                            <div class="col-8 text-center" id="howitworks">
                                <h5 class="rental_header">Want to know more how bicycle rental works?</h5>
                                <a class="btn btn-primary rounded">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 px-5" id="howtorents">
                        <h6>Explore</h6>
                        <ul class="p-0">
                            <li><a href="./View/faqs.php">How to rent</a></li>
                            <li><a href="./View/faqs.php">Renter FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-3 px-4" id="site">
                        <h6>Site</h6>
                        <ul class="p-0">
                            <li><a href="#">About</a></li>
                            <li><a href="./View/terms.php">Terms & Condition</a></li>
                            <li><a href="./View/terms.php#contact_us">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-2" id="followus">
                        <h6>Follow Us</h6>
                        <ul class="row flex-wrap flex-row p-0 align-items-center" id="social">
                            <li class="mx-2"><a href="#"><i class="fab fa-facebook fa-2x"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fab fa-twitter fa-2x"></i></a></li>
                            <li class="mx-2"><a href="#"><i class="fab fa-instagram fa-2x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- ads -->
                <div class="ads footer-bg mt-5 mb-5 text-secondary text-center p-2 rounded">

                </div>
                <div class="d-flex justify-content-between align-items-center p-2">
                    <a href="#">Legal</a>
                    <p class="mb-0">&copy; 2021 Ezbike All rights reserved</p>
                    <img id="footer-logo" class="logo" src="./assets/img/ezbike_transparent.png" alt="">
                </div>
            </div>
        </footer>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places">
    </script>
    <script>
    $(function() {
        var formcontrol = $('.form-control');
        formcontrol.css("border-radius", "0");

        //autocomplete search
        var input = document.getElementById("location-input");
        var options = ['(cities)'];
        var autoComplete = new google.maps.places.Autocomplete(input, options);
        autoComplete.addListener('place_changed', onPlaceChanged);

        function onPlaceChanged() {
            var place = autoComplete.getPlace();

            var latitude = place.geometry.location.lat();
            var longtitude = place.geometry.location.lng();

            var currLoc = {
                lat: latitude,
                lng: longtitude
            };

        }


        $('.searchBtn').click(() => {
            window.location.href = './View/search.php ';
        });


    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>