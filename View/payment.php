<?php
session_start();
require_once "Page.php";
load_model("Database");
load_model("BusinessModel");
load_model("Lessor");

load_view("functions");
require_once "library.php";

if(!isset($_SESSION["User_id"])){
    $db = new Database();
    $lessor_id = $_GET['lessorid'];
    $sql = "SELECT * FROM `tblbusiness` WHERE `lessor_id`='$lessor_id'";
    $stmt = $db->getConn()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();

    foreach($region as $key => $values){
        if($row['Region'] == $key){
            $store_region = $values;
        }
    }
    foreach($province as $key => $values){
        if($row['Province'] == $key){
            $store_province = $values;
        }
    }
    foreach($city as $key => $values){
        if($row['City'] == $key){
            $store_city = $values;
        }
    }

    $address = $row['Address_Line1'] . ' ' . $row['Address_Line2'] . ' ' . $store_region;
    $location =  $store_city . ' ' .$store_province;   

    $_SESSION["shopping_cart"]["shop_name"] = $row['Name'];
    $_SESSION["shopping_cart"]["lessor_address"] = $address;
    $_SESSION["shopping_cart"]["lessor_location"] = $location;
    $_SESSION["shopping_cart"]["bike_id"] = $_GET["bike_id"];
    $_SESSION["shopping_cart"]["bike_name"] = $_GET["bike_name"];
    $_SESSION["shopping_cart"]["bike_type"] = $_GET["bike_type"];
    $_SESSION["shopping_cart"]["bike_brand"] = $_GET["bike_brand"];
    $_SESSION["shopping_cart"]["bike_img"] = $_GET["bike_img"];
    $_SESSION["shopping_cart"]["lessorid"] = $_GET["lessorid"];
    $_SESSION["shopping_cart"]["rate_type"] = $_GET["rate_type"];
    $_SESSION["shopping_cart"]["days"] = $_GET["days"];
    $_SESSION["shopping_cart"]["startDate"] = $_GET["startDate"];
    $_SESSION["shopping_cart"]["returnDate"] = $_GET["returnDate"];
    $_SESSION["shopping_cart"]["totalAmt"] = $_GET["totalAmt"];

    redirectTo("login.php?login_msg=Please Log in to continue");
  
}else{
    $user_id = $_SESSION["User_id"];


    if(isset($_GET["lessorid"]) && isset($_GET["bike_id"]) && isset($_GET["startDate"]) && isset($_GET["returnDate"])){
        $db = new Database();
        $lessor_id = $_GET['lessorid'];
        $sql = "SELECT * FROM `tblbusiness` WHERE `lessor_id`='$lessor_id'";
        $stmt = $db->getConn()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();


        foreach($region as $key => $values){
            if($row['Region'] == $key){
                $store_region = $values;
            }
        }
        foreach($province as $key => $values){
            if($row['Province'] == $key){
                $store_province = $values;
            }
        }
        foreach($city as $key => $values){
            if($row['City'] == $key){
                $store_city = $values;
            }
        }

        $address = $row['Address_Line1'] . ' ' . $row['Address_Line2'] . ' ' . $store_region;
        $location =  $store_city . ' ' .$store_province;   
    


        $bike_id = $_GET["bike_id"];
        $bike_name = $_GET["bike_name"];
        $bike_type = $_GET["bike_type"];
        $bike_brand = $_GET["bike_brand"];
        $bike_img = $_GET["bike_img"];
        $lessor_id = $_GET["lessorid"];
    
 
    
        $rate_type = $_GET["rate_type"];
    
        $days = $_GET["days"];
        $pickup_date = $_GET["startDate"];
        $return_date = $_GET["returnDate"];
        $totalAmt = $_GET["totalAmt"];

        $_SESSION["shopping_cart"]["shop_name"] = $row['Name'];
        $_SESSION["shopping_cart"]["lessor_address"] = $address;
        $_SESSION["shopping_cart"]["lessor_location"] = $location;
        $_SESSION["shopping_cart"]["bike_id"] = $_GET["bike_id"];
        $_SESSION["shopping_cart"]["bike_name"] = $_GET["bike_name"];
        $_SESSION["shopping_cart"]["bike_type"] = $_GET["bike_type"];
        $_SESSION["shopping_cart"]["bike_brand"] = $_GET["bike_brand"];
        $_SESSION["shopping_cart"]["bike_img"] = $_GET["bike_img"];
        $_SESSION["shopping_cart"]["lessorid"] = $_GET["lessorid"];
        $_SESSION["shopping_cart"]["rate_type"] = $_GET["rate_type"];
        $_SESSION["shopping_cart"]["days"] = $_GET["days"];
        $_SESSION["shopping_cart"]["startDate"] = $_GET["startDate"];
        $_SESSION["shopping_cart"]["returnDate"] = $_GET["returnDate"];
        $_SESSION["shopping_cart"]["totalAmt"] = $_GET["totalAmt"];
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

load_view("header");

?>

<title> Ezbike | Payment Page </title>
</head>

<body>
    <?php
        include_once "messenger.php";
    ?>

    <div class="container">
        <?php
        include_once "navigation.php";
    ?>
    </div>
    <div class="container pt-3 pb-2">
        <?php
        if(!isset($_GET["store_name"])){
    ?>

        <?php
        }else{
    ?>
        <div class="path text-secondary fs-14 px-4">
            <a class="text-secondary" href="search.php">search</a> / <a class="text-secondary"
                href="clientPage.php?lessorid=<?= $_GET["lessorid"] ?>"><?= $_GET["store_name"] ?></a> / <a
                class="text-secondary"
                href="productItem.php?lessorid=<?= $_GET["lessorid"]?>&bike_id=<?= $_GET["bike_id"] ?>&store_name=<?= $_SESSION["shopping_cart"]["shop_name"] ?>">
                <?= $_GET["bike_name"] ?> / <a class="text-dark border-bottom border-2"
                    href="payment.php?bike_id=<?= $_GET["bike_id"]?>&lessorid=<?= $_GET["lessorid"] ?>&rate_type=<?= $_GET["rate_type"] ?>&startDate=<?= $_GET["startDate"] ?>&returnDate=<?= $_GET["returnDate"] ?>&totalAmt=<?= $_GET["totalAmt"] ?>&days=<?= $_GET["days"] ?>&bike_name=<?= $_GET["bike_name"] ?>&bike_type=<?= $_GET["bike_type"] ?>&bike_brand=<?= $_GET["bike_brand"] ?>&bike_img=<?= $_GET["bike_img"] ?>&store_name=<?= $_GET["store_name"] ?>">Payment</a>
            </a>
        </div>
        <?php
        }
    ?>

    </div>

    <?php
    if(!empty($_GET["bike_id"])){
?>
    <div class="container p-5 mt-5 mb-5" id="payment-cart">

        <div class="row">
            <div class="col-md-8">
                <h3><i class="fas fa-shopping-cart"></i> Shopping Cart</h3>
                <table class="table table-light" id="shopping-cart">
                    <thead>
                        <th>Item Id</th>
                        <th>Bike to rent</th>
                        <th>Description</th>
                        <th>Rental Price</th>
                        <th>Nos Days</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <td><?= $bike_id ?></td>
                        <td><img class="logo" src="../assets/img/uploads/<?php echo $bike_img ?>" alt=""></td>
                        <td><?= $bike_name . "<br><div class=\"text-secondary fs-13 mb-0\"> " . $bike_brand . "</div><br><div class=\"bg-indigo text-light fs-13 p-1 d-inline\">" . $bike_type . "</div>"  ?>
                        </td>
                        <td>
                            <p>₱ <?= number_format($rate_type,"2") ?></p>
                        </td>
                        <td>
                            <p><?= $days; ?></p>
                        </td>
                        <td>
                            <p>₱<?= number_format($totalAmt,"2") ?></p>
                        </td>
                    </tbody>
                </table>
                <div class="text-end">
                    <a class="btn btn-outline-danger" href="emptyCart.php">Empty Cart</a>
                </div>
                <div>
                    <p class="fs-14">By continuing, I hereby accept Ezbike <a href="terms.php">Terms & Condition </a> and agree to the collection, processing, and use of my personal data as further described in the <a href="terms.php">Privacy Policy</a></p>
                </div>
            </div>
            <div class="col-md-4">
                <!-- start -->
                <div class="px-2">
                    <h3>Payment Details</h3>


                </div>
                <div class="px-2">
                    <div class="d-flex justify-content-between ff-1 mt-4">
                        <p>Pick-up Date</p>
                        <p class="text-secondary fs-14"> <?= $pickup_date ?></p>
                    </div>
                    <div class="d-flex justify-content-between ff-1 border-bottom mb-2">
                        <p>Return Date</p>
                        <p class="text-dark fs-14"> <?= $return_date;    ?></p>
                    </div>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="d-flex justify-content-between ff-1">

                        <p>Total</p>
                        <p>₱ <?= number_format($totalAmt,"2") ?></p>
                        <!-- lessor information -->
                        <input type="hidden" name="lessor_id" id="lessor_id" value="<?= $lessor_id ?>">
                        <input type="hidden" name="bike_id" id="bike_id" value="<?= $bike_id ?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?= $user_id?>">
                        <!-- bicycle information -->
                        <input type="hidden" name="bike_name" id="bike_name" value="<?= $bike_name ?>">
                        <input type="hidden" name="bike_type" id="bike_type" value="<?= $bike_type ?>">
                        <input type="hidden" name="bike_brand" id="bike_brand" value="<?= $bike_brand ?>">
                        <input type="hidden" name="bike_img" id="bike_img" value="<?= $bike_img ?>">
                        <!-- booking dates -->
                        <input type="hidden" name="pickup_date" id="pickup_date" value="<?= $pickup_date ?>">
                        <input type="hidden" name="return_date" id="return_date" value="<?= $return_date ?>">
                        <!-- payment info -->
                        <input type="hidden" name="rental_price" id="rental_price" value="<?= $rate_type ?>">
                        <input type="hidden" name="days" id="days" value="<?= $days ?>">
                        <input type="hidden" name="totalamt" id="totalamt" value="<?= $totalAmt ?>">
                        <input type="hidden" name="email" id="email" value="<?= $_SESSION["Email"]?>">

                        <!-- store information -->
                        <input type="hidden" name="store_name" id="store_name"
                            value="<?= $_SESSION["shopping_cart"]['shop_name'] ?>">
                        <input type="hidden" name="store_address" id="store_address"
                            value="<?= $_SESSION["shopping_cart"]['lessor_address'] ?>">
                        <input type="hidden" name="store_location" id="store_location"
                            value="<?= $_SESSION["shopping_cart"]['lessor_location'] ?>">
                        <input type="hidden" name="barangay" id="barangay" value="<?= $row["Barangay"] ?>">      
                        <input type="hidden" name="fname" id="fname">   
                            
                        </div>
                        <input class="btn btn-primary w-100" id="payBtn" type="button" name="payBtn" value="Cash on Pick Up">

                    </form>

                </div>
                <!-- end -->

                <!-- <div id="paypal-payment-button">

                </div> -->
            </div>

        </div>


    </div>
    <?php
 }else{
     echo "<div class=\"p-5\"> <h1 class=\"text-center\"> Shopping Cart is empty. </h1> <p class=\"text-center\"> <a class=\"btn btn-outline-success\" href=\"search.php\"> Search Bicycle Store </a> </p> </div>";
 }
?>
    <!-- endline -->
    <div id="results" class="col-md-12">

    </div>



    <!-- <script
        src="https://www.paypal.com/sdk/js?client-id=AaMOsMw2Jun7eGqh8xsI9aatWGxjsxNmzLIMUslUxIUl49Fp3WM5jhl871ZKaTy0zwoWXtSXUSimH7AR&currency=PHP&disable-funding=credit,card">
    </script>

    ! -->
    <script>
    // lessor information
    var name = $('#fname').val();
    var email = $('#email').val();

    var lessor_id = $('#lessor_id').val();
    var lessor_email = $('#lessor_email').val();
    var bike_id = $('#bike_id').val();
    var user_id = $('#user_id').val();
    // bicycle information
    var bike_name = $('#bike_name').val();
    var bike_type = $('#bike_type').val();
    var bike_brand = $('#bike_brand').val();
    var bike_img = $('#bike_img').val();
    // booking dates
    var pickup_date = $('#pickup_date').val();
    var return_date = $('#return_date').val();
    // payment info
    var rental_price = $('#rental_price').val();
    var days = $('#days').val();
    var totalAmt = $('#totalamt').val();

    // shop info
    var shop_name = $('#store_name').val();
    var shop_address = $('#store_address').val();
    var shop_location = $('#store_location').val();
    var barangay = $('#barangay').val();
    var myData;

    // payBtn
    var payBtn = $('#payBtn');

    console.log(return_date);

    // convert ph to usd

    var data = document.getElementById("results").innerHTML;


    fetch('../assets/js/barangay.json')
        .then(res => res.json())
        .then(data => {

            // console.log(data["Sheet1"]["10203"]["UACS"]);

            var count = Object.keys(data["Sheet1"]).length;



            for (var i = 0; i < count; i++) {
                if (data["Sheet1"][i]["UACS"] == barangay) {
                    console.log(data["Sheet1"][i]["UACS"] + ' ' + data["Sheet1"][i]["Barangay"]);
                    myData = data["Sheet1"][i]["Barangay"];
                } else {
                    var rawData = data["Sheet1"][i]["UACS"];
                    var zeroValue = "0" + rawData;

                    if (zeroValue == barangay) {
                        myData = data["Sheet1"][i]["Barangay"];
                    }


                }
            }
            console.log(myData);

        })
        // pay click
        payBtn.click(()=>{
            var payment = {};
            payment.name = name;
            payment.email = email;

            payment.lessor_id = lessor_id;
            payment.user_id = user_id;
            payment.bike_id = bike_id;
            payment.bike_description = bike_name;
            payment.bike_img = bike_img;
            payment.pickup_date = pickup_date;
            payment.return_date = return_date;
            payment.days = days;
            payment.bike_rate = rental_price;
            payment.total_amt = totalAmt;
            // store info
            payment.shop_name = shop_name;
            payment.shop_address = shop_address;
            payment.shop_location = shop_location;
            payment.barangay = barangay;
            insertPayment(payment);
        });

        function insertPayment(payment) {
        $.ajax({
            url: "../Model/InsertPayment.php",
            method: "post",
            data: payment,
            success: function(res) {
                window.location.replace("http://localhost:8080/ezbikerental/View/success.php");

            },
        });

    // paypal buttons
    // paypal.Buttons({
    //     style: {
    //         color: 'black',
    //         shape: 'pill',
    //         label: 'pay',

    //     },
    //     createOrder: function(data, actions) {
    //         return actions.order.create({
    //             purchase_units: [{
    //                 amount: {
    //                     value: totalAmt
    //                 },
    //             }],

    //         });
    //     },
    //     onApprove: function(data, actions) {
    //         return actions.order.capture().then(function(details) {
    //             console.log(details);
    //             var name = details["payer"]["name"]["given_name"] + " " + details["payer"]["name"][
    //                 "surname"
    //             ];
    //             var payer_email_address = details["payer"]["email_address"];
    //             var payer_id = details["payer"]["payer_id"];

    //             // store in payment object
    //             var payment = {};
    //             payment.lessor_email = lessor_email;

    //             payment.shop_name = shop_name;
    //             payment.shop_address = shop_address;
    //             payment.shop_location = shop_location;
    //             payment.barangay = myData;

    //             payment.name = name;
    //             payment.payer_email_address = payer_email_address;
    //             payment.payer_id = payer_id;

    //             payment.lessor_id = lessor_id;
    //             payment.user_id = user_id;
    //             payment.bike_id = bike_id;
    //             payment.bike_description = bike_name + " " + bike_type + " " + bike_brand;
    //             payment.bike_img = bike_img;
    //             payment.pickup_date = pickup_date;
    //             payment.return_date = return_date;
    //             payment.rental_price = rental_price;
    //             payment.days = days;
    //             payment.total_amt = totalAmt;

    //             insertPayment(payment);
    //         })
    //     }
    // }).render('#paypal-payment-button');


    }
    </script> -->

    <script>
    $(function() {
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
    </script>
    <?php
    require_once "viewFooter.php";
?>
    <script>

    </script>
    <?php
    require_once "footer.php";
?>