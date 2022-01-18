<?php
    session_start();
    require_once "../Model/Registration.php";
    require_once "../Model/Database.php";
    require_once "functions.php";
    require_once "header.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["login"])){
       
            // user inpu
            $email = validate($_POST["email"]);
            $password = validate($_POST["password"]);

            date_default_timezone_set('Asia/Manila');
            if(empty($email) || empty($password)){
                redirectTo("login.php?login_msg=Username or Password must not be empty!");
            }else{
                if(!confirmingAccountActiveStatus($email)){
                    if(login_attempt($email, $password)){                        
                        if(isset($_SESSION["shopping_cart"])){
                            $store_name = $_SESSION["shopping_cart"]["shop_name"];
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

                            redirectTo("payment.php?bike_id=$bike_id&lessorid=$lessor_id&rate_type=$rate_type&startDate=$pickup_date&returnDate=$end_date&totalAmt=$totalAmt&days=$days&bike_name=$bike_name&bike_type=$bike_type&bike_brand=$bike_brand&bike_img=$bike_img&store_name=$store_name");
                        }else{
                            redirectTo("search.php");
                        }
                    // login attempt end line
                    }else{
                        
                        redirectTo("login.php?login_msg=Invalid username or password!");
                    }
                }else{
                    redirectTo("login.php?login_msg=Activation link has been already sent to your email.");
                    
                }
            }
        }
    }
    if(isset($_SESSION['User_id'])){
        redirectTo("search.php");
    }

?>
<title> Ezbike | User Login </title>
</head>

<body>
    <!-- <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0&appId=541066676918939&autoLogAppEvents=1"
        nonce="wh0XOB7J"></script> -->

    <div class="container-fluid">
        <div class="row" id="login_page">
            <div class="col-md-6 text-center">
                <a href="../index.php"><img id="ezbike_logo" class="img-fluid" src="../assets/img/mainezbike_logo.png" alt=""></a>
                <h2 class="ff-3" id="hop-ride">Hop and ride with your love ones!</h2>

            </div>
            <div class="col-md-6 p-4" id="login-container">
                <form class="p-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <h4 id="login-title">Log in</h4>
                    <?php
                        if(isset($_GET["login_msg"])){
                            ?>
                    <div class="alert alert-danger p-2 text-center fs-13" role="alert">
                        <?php echo $_GET["login_msg"]; ?>
                    </div>
                    <?php
                                }

                        if(isset($_GET["login_success"])){
                                ?>
                    <div class="text-center border border-success text-success p-1 mb-1">
                        <?php echo $_GET["login_success"]; ?>
                    </div>

                    <?php
                                }
                        ?>
                    <div class="mt-3 mb-1">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter your email address">
                    </div>
                    <div class="mt-3 mb-1">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password">
                    </div>
                    <div class="mt-4 mb-1">
                        <input type="submit" name="login" class="btn btn-indigo w-100" value="Log in">
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-around">
                            <a href="RecoverAccount.php">Can't Log in?</a>
                            <a href="userRegistration.php">Sign up for an account</a>
                        </div>
                    </div>
                    <div class="mt-5 mb-1">
                        <div class="d-flex">
                            <div class="col">
                                <a class="btn btn-indigo-outline mx-1" href="lenderLogin.php">Log in as Lessor</a>
                            </div>
                            <div class="col text-end">
                                <a class="btn btn-indigo-outline mx-1" href="adminLogin.php">Log in as Administrator</a>
                            </div>
                        </div>
                    </div>

                    <!-- <div>
                        <div class="fb-login-button text-center w-100" data-width="" data-size="large" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false"></div> 
                    </div> -->

                </form>
            </div>
        </div>
    </div>

    <!-- <script>
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
    </script> -->
    <?php
        require_once "footer.php";
    ?>