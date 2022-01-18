<?php
    session_start();
    require_once "Page.php";
    require_once "header.php";
    require_once "../Model/Registration.php";
    require_once "../Model/Database.php";
    load_view("functions");

    if(isset($_GET['token'])){
        $tokenFromUrl = $_GET['token'];
        if(isset($_GET["reset"])){
            // user input
            $password = validate($_GET["password"]);
            $confirmPassword = validate($_GET["confirmPassword"]);

            // validation
            if(empty($password) || empty($confirmPassword)){
                $_SESSION["message"] = "Password Field should not be empty!";
            }else if($password != $confirmPassword){
                $_SESSION["message"] = "Password does not match";
            }else if(strlen($password) < 8){
                $_SESSION["message"] = "Password is too short";
            }else{
                $register = new Registration();
                $db = new Database();
                // success validation
                $_SESSION["message"] = "";
                $hashPassword = $register->Password_Encryption($password);
                date_default_timezone_set('Asia/Manila');
                $email = new Database();
                $emailQuery = "SELECT `Email`,`FirstName` FROM `tblusers` WHERE `Token`='$tokenFromUrl';";
                $email->query($emailQuery);
                $email->execute();
                $emailRow = $email->fetch();
                

                $query = "UPDATE `tblusers` SET `Password`='$hashPassword' WHERE `Token`='$tokenFromUrl';";
                $db->query($query);
                if($db->execute()){
                    $mailTo = $emailRow["Email"];
                    $subject = "Password Change";
                    $msg = 'Hi '. $emailRow["FirstName"] . ' You have successfully change your password.';
                    $msg .= "Please visit our website for more information. https://www.ezbikeofficial.com";
                    $senderEmail = "FROM: ezbikeofficial@gmail.com"."\r\n";
                    if(mail($mailTo,$subject,$msg,$senderEmail)){
                        redirectTo("login.php?login_success=Password Changed Successfully!");
                    }

                }else{
                    $_SESSION["message"] = "Something Went Wrong!";
                    redirectTo("Reset_Password.php?token=".$tokenFromUrl);
                }
                $db->closeStmt();
            }
        }else{
            
        }
    }else{
        redirectTo("show404.php");
    }
?>

<body>
    <?php
        include_once "messenger.php";
    ?>
    <div class="container-fluid" id="signup-bg">
        <div class="container">
            <?php
                include_once "navigation.php";
            ?>

            <section>
                <form class="signup-form pt-4 pb-4" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                    method="GET">
                    <div class="row" id="signup">
                        <div class="col-md-12">
                            <div class="w-50 mx-auto text-center shadow p-4">
                                <h3 class="text-center ff-2">Reset your password</h3>
                                <?php
                                if(isset($_SESSION["message"])){
                                    echo "<p class=\"text-center text-light bg-danger\">" . $_SESSION["message"] . "</p>";
                                }
                                if(isset($_GET["login_success"])){
                                   echo "<div class=\"alert alert-success text-center\" role=\"alert\">
                                     Successfully Created Account!
                                    </div> ";
                                    header('Refresh: 3; URL=http://localhost/ezbikerental/index.php');
                                }
                            ?>
                                <!-- password -->
                                <div class="col-md-12 d-flex flex-column text-start border-bottom mb-2">
                                    <label for="password" class="p-1">
                                        New Password
                                    </label>
                                    <input type="password" name="password" class="form-control border border-1" />
                                </div>
                                <!-- password -->
                                <div class="col-md-12 d-flex flex-column text-start border-bottom mb-2">
                                    <label for="confirmPassword" class="p-1">
                                        Confirm Password
                                    </label>
                                    <input type="password" name="confirmPassword"
                                        class="form-control border border-1" />
                                    <input type="hidden" name="token" value="<?= $tokenFromUrl; ?>">
                                </div>
                                <!-- submit button -->
                                <div class="col-md-12 pt-3 d-flex align-items-end justify-content-end">
                                    <a class="btn btn-secondary mx-2" href="../index.php">Cancel</a>
                                    <input type="submit" name="reset" class="btn btn-primary text-center"
                                        value="Reset Password" />
                                </div>
                            </div>




                        </div>

                    </div>

                </form>
            </section>
        </div>
        <!-- container end -->
    </div>


    <?php
        load_view("viewFooter");
        load_view("footer");
    ?>