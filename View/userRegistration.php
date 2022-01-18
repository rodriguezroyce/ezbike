<?php
    session_start();
    require_once "Page.php";
    load_view("functions");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["signup"])){
            // user input
            $policy = $_POST["policy"];
            if(!isset($policy)){
                redirectTo("userRegistration.php?policy_validation=Please agree to our terms and conditions to continue.");
            }
            $fname = validate($_POST["fname"]);
            $lname = validate($_POST["lname"]);
            $email = validate($_POST["email"]);
            $mobile = validate($_POST["mobile"]);
            $password = validate($_POST["password"]);
            $confirmPassword = validate($_POST["confirmPassword"]);
    
            $regex_name = "/^[a-zA-Z\s]+$/";
            $mobileLength = strlen($mobile);
    
            // validation
    
            if(empty($fname) || empty($lname) || empty($email) || empty($mobile) || empty($password) || empty($confirmPassword)){
                redirectTo("userRegistration.php?message=All fields required!");
            }else if(!preg_match($regex_name, $fname) || !preg_match($regex_name, $lname)){
                redirectTo("userRegistration.php?firstname_validation=name should not contain any special characters or digits.");
            }else if(checkEmailExists($email)){
                redirectTo("userRegistration.php?email_validation=Email is already in use.");
            }else if($mobileLength !=10){
                redirectTo("userRegistration.php?phone_validation=Invalid Phone Number.");
            }else if(strlen($password) < 8){
                redirectTo("userRegistration.php?password_validation=Password is too short!");
            }else if($password != $confirmPassword){
                redirectTo("userRegistration.php?confirm_validation=Password does not match!");
            }else if(phoneExists($mobile)){
                redirectTo("userRegistration.php?phone_validation=Phone Number has already registered. Please choose another.");
            }else if(!isset($policy)){
                redirectTo("userRegistration.php?policy_validation=Please agree to our terms & condition to continue.");
            }
            else{
                    $register = new Registration();
                    $db = new Database();
                    // success validation
                    $_SESSION["message"] = "";
                    $hashPassword = $register->Password_Encryption($password);
                    date_default_timezone_set('Asia/Manila');
    
                    $today = date("F j, Y, g:i a");
                    $Token = bin2hex(openssl_random_pseudo_bytes(40));

                    $valid_id = $_FILES["valid_id"];
                    $valid_id_name = $_FILES["valid_id"]["name"];
                    $valid_id_tmp = $_FILES["valid_id"]["tmp_name"];
                    $valid_id_type = $_FILES["valid_id"]["type"];
                    $valid_id_size = $_FILES["valid_id"]["size"];

                    $isValidFile = false;

                    $sql = "INSERT INTO `tblusers` (`FirstName`,`LastName`,`Email`,`MobileNos`,`Password`,`valid_id`,`Token`,`Date_Created`,`Active`) VALUES (:FIRSTNAME,:LASTNAME,:EMAIL,:MOBILENOS,:PASSWORD,:VALID_ID,:TOKEN,:DATE_CREATED,:ACTIVE)";
                    $db->query($sql);
                    $db->bindValues($fname,$lname,$email,$mobile,$hashPassword,$valid_id_name,$Token,$today,"OFF");

                    $allowedTypes = ["image/jpeg","image/png","image/jpg","image/gif","image/tiff","image/psd"];
                    if($valid_id_size > 26214400){
                        echo "file size too high";
                    }else{
                        foreach($allowedTypes as $fileTypes){
                            if($valid_id_type == $fileTypes){
                                $isValidFile = true;
                            }
                        }
                        if($isValidFile){
                            if($db->execute()){
                                $dir = "../assets/img/valid_id";
                                if(!file_exists($dir)){
                                    mkdir($dir);
                                }else{
                                    move_uploaded_file($valid_id_tmp, $dir."/".$valid_id_name);
                                    $mailTo = $email;
                                    $subject = "Confirm Account";
                                    $msg = 'Hi '.$fname . 'Here is the link to confirm your account http://localhost/ezbikerental/View/Activate.php?token='. $Token;
                                    $senderEmail = "FROM: ezbikeofficial@gmail.com";
                                    if(mail($mailTo,$subject,$msg,$senderEmail))
                                    {
                                        redirectTo("login.php?login_msg=Account Confirmation Required!");
                                    }else{
                                        redirectTo("userRegistration.php?message=Something went wrong try again!");
                                    }                                   
                                }
                            }else{
                                redirectTo("userRegistration.php?message=Something went wrong try again!");
                            }
                        }else{
                            redirectTo("userRegistration.php?id_validation=Valid id must be png or jpeg format.");
                        }
                    }
                    $db->closeStmt();
            }
        }
    }
    load_model("Registration");
    load_model("Database");
    load_view("header");



?>
<title> Ezbike | Sign up</title>
</head>

<body>
    <?php
        include_once "messenger.php";
    ?>
    <div class="container-fluid" id="signup">
        <div class="row">
            <div class="col-md-6 d-flex flex-column" id="userRegistrationBg">
                <div class="p-2">
                    <!-- ezbike logo -->
                    <a href="../index.php">
                        <img class="logo" src="../assets/img/ezbike.png" alt="">
                    </a>
                </div>
                <div class="p-5" id="already_member">
                    <div class="text-light text-center">
                        <h5 class="pe-5">Already Signed up?</h5>
                        <p class="fs-12 pe-5">All users in EZBIKE will know that there are millions of people out there.
                            Every day besides so many people joining this community </p>
                        <div style="margin-right: 50px;">
                            <a id="log-in" class="text-light border border-1" href="login.php">Log in</a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-6 p-4" id="signup-page">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div class="pt-4 px-4 pb-1 text-center">
                        <h4>Sign up for an account</h4>
                        <p class="px-4">Let's get you all set up so you can start create your first bicycle rental
                            experience</p>
                        <span class="text-danger">
                            <?php if(isset($_GET["message"])){
                                echo $_GET["message"];
                            }
                       ?>
                        </span>
                    </div>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                        enctype="multipart/form-data">
                        <div class="d-flex">
                            <div class="col mx-1">
                                <!-- firstnamee -->
                                <label for="fname">First Name</label>
                                <input class="form-control" type="text" name="fname" id="fname"
                                    placeholder="Your first name">
                                <span class="firstname_validation error">
                                    <?php 
                                        if(isset($_GET["firstname_validation"])){
                                            echo $_GET["firstname_validation"];
                                        }
                                    ?>
                                </span>
                            </div>
                            <div class="col mx-1">
                                <!-- lastname -->
                                <label for="lname">Last Name</label>
                                <input class="form-control" type="text" name="lname" id="lastname"
                                    placeholder="Your last name">
                                <span class="lastname_validation error">
                                    <?php 
                                        if(isset($_GET["lastname_validation"])){
                                            echo $_GET["lastname_validation"];
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-1">
                            <!-- email -->
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email" id="email"
                                placeholder="Enter your email">
                            <span class="email_validation error">
                                <?php 
                                    if(isset($_GET["email_validation"])){
                                        echo $_GET["email_validation"];
                                    }
                                ?>
                            </span>
                        </div>
                        <div class="d-flex">
                            <!-- password -->
                            <div class="col mx-1">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password"
                                    placeholder="Password">
                                <span class="password_validation error">
                                    <?php 
                                    if(isset($_GET["password_validation"])){
                                        echo $_GET["password_validation"];
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="col mx-1">
                                <!-- confirm password -->
                                <label for="confirmPassword">Confirm Password</label>
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword">
                                <span class="confirm_validation error">
                                    <?php 
                                    if(isset($_GET["confirm_validation"])){
                                        echo $_GET["confirm_validation"];
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-1">
                            <label for="phone">Phone</label>
                            <input class="form-control" oninput="maxLengthCheck(this)" maxlength="10" max="9999999999"
                                type="tel" name="mobile" id="mobile" placeholder="935-XXX-XXX">
                            <span class="phone_validation error">
                                <?php 
                                    if(isset($_GET["phone_validation"])){
                                        echo $_GET["phone_validation"];
                                    }
                                    ?>
                            </span>
                        </div>
                        <div class="p-1">
                            <label for="valid_id">Valid Id</label>
                            <input class="form-control" type="file" name="valid_id" required>
                            <span class="id_validation error">
                                <?php 
                                    if(isset($_GET["id_validation"])){
                                        echo $_GET["id_validation"];
                                    }
                                ?>
                        </span>
                        </div>
                        <div class="p-1">
                            <input type="checkbox" name="policy">
                            <label class="ff-2" for="policy"> I accept Ezbike <a href="terms.php">terms & conditions</a>
                            </label>
                        </div>
                        <span class="policy_validation px-1 error">
                            <?php 
                                if(isset($_GET["policy_validation"])){
                                    echo $_GET["policy_validation"];
                                }
                            ?>
                        </span>

                        <div class="p-1">
                            <input class="btn btn-indigo text-light w-100" type="submit" name="signup" value="SIGN UP">
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
    $('.error').css("font-size", "13px");
    $('.error').addClass("text-danger");

    function maxLengthCheck(object) {
        if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
    }

    function isNumeric(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    $(function() {
        $('#log-in').css("padding", "0.55em 3rem");
        $('label').css("font-size", "15px");
    });
    </script>
    <?php
        require_once "footer.php";
    ?>