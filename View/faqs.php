<?php
    session_start();
    require_once "Page.php";
    load_view("functions");
    if(isset($_SESSION["shopping_cart"])){
        $bike_id = $_SESSION["shopping_cart"]["bike_id"];
        $lessor_id = $_SESSION["shopping_cart"]["lessorid"];
        $rate_type = $_SESSION["shopping_cart"]["rate_type"];
        $pickup_date = $_SESSION["shopping_cart"]["startDate"];
        $end_date = $_SESSION["shopping_cart"]["returnDate"];
        $totalAmt = $_SESSION["shopping_cart"]["totalAmt"];
        $days = $_SESSION["shopping_cart"]["days"];
        $bike_name = $_SESSION["shopping_cart"]["bike_name"];
        $bike_types = $_SESSION["shopping_cart"]["bike_type"];
        $bike_brand = $_SESSION["shopping_cart"]["bike_brand"];
        $bike_img = $_SESSION["shopping_cart"]["bike_img"];
    }
    load_view("header");    

?>
<title>
    Frequently Ask Questions | Ezbike
</title>
</head>

<body class="bg-white">
    <?php
        include_once "messenger.php";
    ?>
    <div class="container">
        <?php
            include_once "navigation.php";
        ?>
    </div>
    <div class="container-fluid web-wash">
        <div class="container p-4">
            <div class="p-4 text-center">
                <h2>Frequently Ask Questions</h2>

            </div>
            <div class="row">
                <button id="gettingstarted-btn" class="col faqs-box">
                    <div class="top">
                        <i class="fas fa-play-circle fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Getting Started</h6>
                    </div>
                </button>
                <button id="renting-out-bikes-btn" class="col faqs-box">
                    <div class="top">
                        <i class="fas fa-hand-holding fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Renting out your bikes</h6>
                    </div>
                </button>
                <button id="rentingABikeBtn" class="col faqs-box">
                    <div class="top">
                        <i class="fas fa-bicycle fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Renting a bike</h6>
                    </div>
                </button>
                <button id="paymentsBtn" class="col faqs-box">
                    <div class="top">
                        <i class="fab fa-paypal fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Payment & Service Fees</h6>
                    </div>
                </button>
                <button id="bikeProtectionBtn" class="col faqs-box">
                    <div class="top">
                        <i class="fas fa-shield-alt fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Bike Protection</h6>
                    </div>
                </button>
                <button id="bookingBtn" class="col faqs-box">
                    <div class="top">
                        <i class="far fa-handshake fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Booking & Cancellation</h6>
                    </div>
                </button>
                <button id="ratingBtn" class="col faqs-box">
                    <div class="top">
                        <i class="fas fa-star fa-3x"></i>
                    </div>
                    <div class="bottom">
                        <h6>Ratings & Feedback</h6>

                    </div>
                </button>
            </div>
            <div class="results">
                <div id="getting-started">
                    <h3>Getting Started</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    How do I search for a bike
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Type the city, district or place you want to rent a bike in the search bar. Our
                                    search engine will show you all results including a map view with locations. You can
                                    add filters for the bike types after you chose a bicycle store and view the
                                    information of the bicycle and pay to rent available bicycle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    Why should I use bicycle filters?
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">The search results will show you the bike that you
                                    preferred. To narrow your search results, you can use filters: "Bike Type",
                                    "Availability" and "Sort By" date</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    How do i create an account?
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">On the header of the page. Click the button <span
                                        class="text-indigo"> "Sign up" </span> and fill up all the required fields. Once
                                    the fields are already filled up, A confirmation link will be sent to your email.
                                    Click the link to activate your account to allow users to proceed with their booking
                                    of bicycles. </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFour" aria-expanded="false"
                                    aria-controls="flush-collapseFour">
                                    Can I change my email or password?
                                </button>
                            </h2>
                            <div id="flush-collapseFour" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Yes, you can. Click your name on the navigation bar to see
                                    your account settings and click the edit button. </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFive" aria-expanded="false"
                                    aria-controls="flush-collapseFive">
                                    Can I see my previous rentals?
                                </button>
                            </h2>
                            <div id="flush-collapseFive" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">You can see it along with you account settings, just click
                                    the My Rental. </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSix" aria-expanded="false"
                                    aria-controls="flush-collapseSix">
                                    Can I double my reservation?
                                </button>
                            </h2>
                            <div id="flush-collapseSix" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">No. We have a one at a time policy, only one bike per rider.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- renting out bikes -->
                <div id="renting-out-your-bikes" class="mt-2">
                    <h3>Renting out your bikes</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSeven" aria-expanded="false"
                                    aria-controls="flush-collapseSeven">
                                    How can I be a lessor or renter?
                                </button>
                            </h2>
                            <div id="flush-collapseSeven" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    We only accommodate bicycle shops to be a renter for much more secured transaction
                                    for riders. If you are an owner of bicycle shop and want to be our partner, please
                                    e-mail us at <a
                                        href="mailto:ezbike@ezbikeofficial.com">ezbike@ezbikeofficial.com</a>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseEight" aria-expanded="false"
                                    aria-controls="flush-collapseEight">
                                    How can I enlist my bike?
                                </button>
                            </h2>
                            <div id="flush-collapseEight" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">You need to be a lessor in order to enlist a bike. After
                                    becoming a lessor, go to Bicycle Information in Lessor Dashboard. Then click the Add
                                    bicycle and put all the requirements to enlist a bike.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseNine" aria-expanded="false"
                                    aria-controls="flush-collapseNine">
                                    Can I edit my bike shop information?
                                </button>
                            </h2>
                            <div id="flush-collapseNine" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Yes you, we highly recommend that you put truthful
                                    information and exact address in order for them to find you easily! </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTen" aria-expanded="false"
                                    aria-controls="flush-collapseTen">
                                    Can I modify my bicycle information?
                                </button>
                            </h2>
                            <div id="flush-collapseTen  " class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">You can modify the specification of your bicycle/s if you
                                    changed some parts. But you cannot delete your bicycle on the list, you must request
                                    to admin if you want the bicycle to be removed. </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEleven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseEleven" aria-expanded="false"
                                    aria-controls="flush-collapseEleven">
                                    How can I put my exact address?
                                </button>
                            </h2>
                            <div id="flush-collapseEleven" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingEleven" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">At the Lessor Dashboard, go to Location and find your
                                    current address using the map, pinpoint it and confirm after selecting. For the
                                    basic information of the location, go to account settings and click setup business
                                    and fill in the information needed. to modify you will see business information.
                                    click then select <span class="btn btn-outline-primary"> edit </span> button to
                                    enable editing information then click <span
                                        class="bg-primary text-light p-1 rounded"> update</span>. </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwelve">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwelve" aria-expanded="false"
                                    aria-controls="flush-collapseTwelve">
                                    How can they can find my shop?
                                </button>
                            </h2>
                            <div id="flush-collapseTwelve" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwelve" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">The client can find your shop when clients search for nearby
                                    bicycle stores or using the map locator with a marker of EZ when they were searching
                                    for a particular store nearby their area.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- renting a bike -->
                <div id="renting-a-bike">
                    <h3>Renting A Bike</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThirteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThirteen" aria-expanded="false"
                                    aria-controls="flush-collapseThirteen">
                                    How can I rent a bike?
                                </button>
                            </h2>
                            <div id="flush-collapseThirteen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThirteen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    In the homepage use the search bar and put your current location in order to search
                                    a nearby bicycle shops. After selecting a desired bicycle shop, you can now choose
                                    available bicycle.

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseEight" aria-expanded="false"
                                    aria-controls="flush-collapseEight">
                                    Can I cancel my booking?
                                </button>
                            </h2>
                            <div id="flush-collapseEight" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Yes, as long you didn’t pay yet. But once you already pay;
                                    cancellation is not allowed.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- payments & services fee -->
                <div id="payments">
                    <h3>Payments & Service Fee</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFourteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFourteen" aria-expanded="false"
                                    aria-controls="flush-collapseFourteen">
                                    How can I pay after selecting bicycle?
                                </button>
                            </h2>
                            <div id="flush-collapseFourteen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFourteen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    We can only accommodate online transaction using PayPal for secured payments.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFifteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFifteen" aria-expanded="false"
                                    aria-controls="flush-collapseFifteen">
                                    Is there a limit or cost to list my bike?
                                </button>
                            </h2>
                            <div id="flush-collapseFifteen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFifteen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">No, it is free and you can list any number of bikes.

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bike protection -->
                <div id="bike-protection">
                    <h3>Bike Protection</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSixteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSixteen" aria-expanded="false"
                                    aria-controls="flush-collapseSixteen">
                                    How can I make sure that my bicycle is safe and not stolen?
                                </button>
                            </h2>
                            <div id="flush-collapseSixteen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingSixteen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    The Ezbike will provide you their basic information such as their valid id, name,
                                    address. And the payment information to assure that even if the bike was stolen. We
                                    might be able to find them by their information that allows us to report them to
                                    police.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSeventeen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSeventeen" aria-expanded="false"
                                    aria-controls="flush-collapseSeventeen">
                                    What if my bike got dents or damage?
                                </button>
                            </h2>
                            <div id="flush-collapseSeventeen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingSeventeen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Ezbike will not shoulder any loss or damages for the
                                    bicycle. But we will provide you their phone and e-mail. If the case still unsolved
                                    please contact us at ezbike@ezbikeofficial.com.

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bookings &  Cancellation -->
                <div id="booking">
                    <h3>Booking & Cancellation</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEighteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseEighteen" aria-expanded="false"
                                    aria-controls="flush-collapseEighteen">
                                    How can I cancel my booking/rental?
                                </button>
                            </h2>
                            <div id="flush-collapseEighteen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingEighteen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Unfortunately, No. Prior payment we recommend you to double check or think twice
                                    about booking your ride. Booking Cancellation is not allowed to avoid fraud, scam
                                    and fake bookings.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Bookings &  Cancellation -->
                <div id="ratings">
                    <h3>Ratings & Feedback</h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingNineteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseNineteen" aria-expanded="false"
                                    aria-controls="flush-collapseNineteen">
                                    How can I rate and feedback the bike shop?
                                </button>
                            </h2>
                            <div id="flush-collapseNineteen" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingNineteen" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    You can rate and feedback your desired bike shop after checking out their bicycle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwenty">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwenty" aria-expanded="false"
                                    aria-controls="flush-collapseTwenty">
                                    Can I report the bike shop?
                                </button>
                            </h2>
                            <div id="flush-collapseTwenty" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwenty" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Yes, you can but please don’t be toxic about something. We all just want to ride a
                                    bike!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ratings end -->
            </div>

        </div>
    </div>

    <script type="text/javascript">
    $(function() {
        let gettingstarted = $('#getting-started');
        let renting_out_your_bikes = $('#renting-out-your-bikes');
        let renting_a_bike = $('#renting-a-bike');
        let payments = $('#payments');
        let bikeProtection = $('#bike-protection');
        let booking = $('#booking');
        let ratings = $('#ratings');
        //buttons
        let gettingstartedBtn = $('#gettingstarted-btn');
        let rentingOutBikesBtn = $('#renting-out-bikes-btn');
        let rentingABikeBtn = $('#rentingABikeBtn');
        let paymentsBtn = $('#paymentsBtn');
        let bikeProtectionBtn = $('#bikeProtectionBtn');
        let bookingBtn = $('#bookingBtn');
        let ratingsBtn = $('#ratingBtn');

        gettingstarted.hide();
        renting_out_your_bikes.hide();
        renting_a_bike.hide();
        payments.hide();
        bikeProtection.hide();
        booking.hide();
        ratings.hide();

        gettingstartedBtn.click(function() {
            gettingstarted.show("slow");
            renting_out_your_bikes.hide();
            renting_a_bike.hide();
            payments.hide();
            bikeProtection.hide();
            booking.hide();
            ratings.hide();
        });
        rentingOutBikesBtn.click(function() {
            gettingstarted.hide();
            renting_out_your_bikes.show("slow");
            renting_a_bike.hide();
            payments.hide();
            bikeProtection.hide();
            booking.hide();
            ratings.hide();
        });
        rentingABikeBtn.click(function() {
            gettingstarted.hide();
            renting_out_your_bikes.hide();
            renting_a_bike.show("slow");
            payments.hide();
            bikeProtection.hide();
            booking.hide();
            ratings.hide();
        });
        paymentsBtn.click(function() {
            gettingstarted.hide();
            renting_out_your_bikes.hide();
            renting_a_bike.hide();
            payments.show("slow");
            bikeProtection.hide();
            booking.hide();
            ratings.hide();
        });
        bikeProtectionBtn.click(function() {
            gettingstarted.hide();
            renting_out_your_bikes.hide();
            renting_a_bike.hide();
            payments.hide();
            bikeProtection.show("slow");
            booking.hide();
            ratings.hide();
        });
        bookingBtn.click(function() {
            gettingstarted.hide();
            renting_out_your_bikes.hide();
            renting_a_bike.hide();
            payments.hide();
            bikeProtection.hide();
            booking.show("slow");
            ratings.hide();
        });
        ratingsBtn.click(function() {
            gettingstarted.hide();
            renting_out_your_bikes.hide();
            renting_a_bike.hide();
            payments.hide();
            bikeProtection.hide();
            booking.hide();
            ratings.show("slow");
        });

    });
    </script>
    <?php
    load_view("viewFooter");
    load_view("footer");
?>