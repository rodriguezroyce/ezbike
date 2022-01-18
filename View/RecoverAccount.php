<?php
    session_start();
    require_once "header.php";
    require_once "../Model/Registration.php";
    require_once "../Model/Database.php";
    require_once "functions.php";

    if(isset($_POST["recover"])){
        $email = validate($_POST["email"]);

        if(empty($email)){
            redirectTo("RecoverAccount.php?message=Email Should not be empty!");
        }else if(!checkEmailExists($email)){
            redirectTo("RecoverAccount.php?message=Email does not exists.");
            
        }else{
            $query = "SELECT * FROM `tblusers` WHERE `Email`='$email'";
            $db = new Database();
            $db->query($query);
            if($row = $db->fetchSingle()){
                $mailTo = $email;
                $subject = "Reset your Password";
                $msg = 'Hi '. $row["FirstName"] . ' Here is the link to reset your password http://localhost/ezbikerental/View/Reset_Password.php?token='. $row["Token"];
                $senderEmail = "FROM: ezbikeofficial@gmail.com";

                if(mail($mailTo,$subject,$msg,$senderEmail))
                {
                    $_SESSION["login_msg"] = "Reset Password Link has been successfully send!";
                    redirectTo("login.php?login_success=Reset Password Link has been successfully send!");
                }else{

                    redirectTo("login.php?login_msg=Something Went Wrong try again!");
                }
                
            }
        }
    }

?>
<title> Ezbike | Recover Account </title>
</head>

<body>
    <?php
        include_once "messenger.php";
    ?>
    <div class="container" id="signup-bg">
        <?php
            include_once "navigation.php";
        ?>
        <section class="container">
            <form class="signup-form pt-4 pb-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                method="POST">
                <div class="row" id="signup">
                    <div class="col-md-12">
                        <div class="recover_account text-center shadow p-4">
                            <h3 class="text-center ff-2">Find You Account</h3>
                            <?php
                                if(isset($_GET["message"])){
                                    echo "<p class=\"text-center text-light bg-danger\">" . $_GET["message"] . "</p>";
                                }
                                if(isset($_GET["success"])){
                                   echo "<div class=\"alert alert-success text-center\" role=\"alert\">
                                     Successfully Created Account!
                                    </div> ";
                                    header('Refresh: 3; URL=http://localhost/ezbikerental/index.php');
                                }
                            ?>
                            <!-- email -->
                            <div class="col-md-12 d-flex flex-column text-start border-bottom mb-2">
                                <label for="email" class="p-1">
                                    Please Enter your email to search for your account
                                </label>
                                <input type="email" name="email" class="form-control border border-1" />
                            </div>
                            <!-- submit button -->
                            <div class="col-md-12 pt-3 d-flex align-items-end justify-content-end">
                                <a class="btn btn-secondary mx-2" href="../index.php">Cancel</a>
                                <input type="submit" name="recover" class="btn btn-primary text-center"
                                    value="Send Email Confirmation" />
                            </div>
                        </div>




                    </div>

                </div>

            </form>
        </section>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places">
    </script>

    <script src="../assets/js/autoComplete.js"></script>
    <?php
        require_once "viewFooter.php";
        require_once "footer.php";
    ?>