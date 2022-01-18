<?php
    session_start();
    require_once "Page.php";

    load_model("Database");
    load_model('Bicycle');
    load_model('Registration');
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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["updateEmailBtn"])){
            $email = validate($_POST["email"]);
            $updateEmail = new Database();
            $dateToday = new Bicycle();
            if(checkEmailExists($email)){
                redirectTo("myAccount.php?msg=email already in use. please choose another email");
            }else{
                $updateSql = "UPDATE `tblusers` SET `Email`=:EMAIL WHERE `User_id`=:USER_ID";
                $stmt = $updateEmail->getConn()->prepare($updateSql);
                $stmt->bindValue(':EMAIL', $email, PDO::PARAM_STR);
                $stmt->bindValue(':USER_ID', $_SESSION["User_id"], PDO::PARAM_INT);
                if($stmt->execute()){
                    
                    $subject = "Ezbike Payments";
                    $msg = '<html><body>';
                    $msg .= '<h1> Security Alert </h1>';
                    $msg .= '<p> Hi '. $_SESSION["FirstName"] .', </p>';
                    $msg .= 'You have successfully updated your email on '. $dateToday->getDateUploaded();
                    $msg .= '<p> For more information about bicycle rental. Please visit https://ezbikeofficial.com </p>';
                    $msg .= '</body> </html>';
    
                    $senderEmail = "FROM: ezbikeofficial@gmail.com\r\n";
                    $senderEmail .="Reply-To: ". $email ."\r\n";
                    $senderEmail .="MIME-version: 1.0\r\n";
                    $senderEmail .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n";
                
                    if(mail($email,$subject,$msg,$senderEmail)){
                       $_SESSION["Email"] = $email;
                       redirectTo('myAccount.php?success=Successfully updated your email!');
                    }
                }else{
                    redirectTo("myAccount.php?msg=Connection Timeout!");
                }
                $stmt->closeCursor();
            }



        }

        if(isset($_POST["updatePasswordBtn"])){
            $currentPassword = validate($_POST["currentPassword"]);
            $newPassword = validate($_POST["newPassword"]);
            $confirmPassword = validate($_POST["confirmPassword"]);

            $dateToday = new Bicycle();

            $password_checker = new Registration();
            if($password_checker->password_check($currentPassword, $_SESSION['Password'])){
               if($newPassword == $confirmPassword){
                   $hashNewPassword = $password_checker->Password_Encryption($newPassword);
                   $db1 = new Database();
                   $updatePasswordSql = "UPDATE `tblusers` SET `Password`=:PASSWORD WHERE `User_id`=:USER_ID";
                   $updateStmt = $db1->getConn()->prepare($updatePasswordSql);
                   $updateStmt->bindValue(':PASSWORD', $hashNewPassword, PDO::PARAM_STR);
                   $updateStmt->bindValue(':USER_ID', $_SESSION["User_id"], PDO::PARAM_STR);
                   if($updateStmt->execute()){

                        $subject = "Password Changed";
                        $msg = '<html><body>';
                        $msg .= '<h1> Security Alert </h1>';
                        $msg .= '<p> Hi '. $_SESSION["FirstName"] .', </p>';
                        $msg .= 'You have successfully updated your password on '. $dateToday->getDateUploaded()  ;
                        $msg .= '<p> For more information about bicycle rental. Please visit https://ezbikeofficial.com </p>';
                        $msg .= '</body> </html>';
        
                        $senderEmail = "FROM: ezbikeofficial@gmail.com\r\n";
                        $senderEmail .="Reply-To: ". $_SESSION["Email"] ."\r\n";
                        $senderEmail .="MIME-version: 1.0\r\n";
                        $senderEmail .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n";
                    
                        if(mail($_SESSION["Email"],$subject,$msg,$senderEmail)){
                           $_SESSION["Password"] = $hashNewPassword;
                           redirectTo('myAccount.php?success=Successfully updated your account!');
                        }
                   }
                   $updateStmt->closeCursor();
               }else{
                    redirectTo('myAccount.php?msg=Password does not match.');
               }
            }else{
                redirectTo('myAccount.php?msg=Password does not match.');

            }
        }
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
                <h3 class="mt-5">Account Settings</h3>
                <span class="text-danger"><?php if(isset($_GET["msg"])){
                        echo $_GET["msg"];
                    }else if(isset($_GET["success"])){
                        echo "<span class=\"text-success\"> {$_GET["success"]} </span>";
                    } ?> </span>
                <div class="row">
                    <!-- email address -->
                    <div class="col-md-12">
                        <h5 class="mt-3">Email Address</h5>
                    </div>
                    <div class="col-md-10">
                        <p>Your email address is <span class="fw-bold"><?= $_SESSION["Email"]; ?></span></p>
                        <form id="changeEmail" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input class="form-control w-50" type="text" name="email"
                                value="<?= $_SESSION["Email"]; ?>">
                            <input class="btn btn-outline-primary mt-3" name="updateEmailBtn" type="submit">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <button class="btn text-primary" id="editEmail" type="button">Edit</button>
                    </div>
                    <!-- password -->
                    <div class="col-md-12">
                        <h5 class="mt-3">Change Password</h5>
                    </div>
                    <div class="col-md-10">
                        <p>It's a good idea to use a strong password that you're not using elsewhere</p>
                        <form id="changePassword" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <label for="currentPassword">Current Password</label>
                            <input class="form-control w-50" type="password" name="currentPassword">
                            <!-- new password -->
                            <label for="newPassword">New Password</label>
                            <input class="form-control w-50" type="password" name="newPassword">

                            <label for="confirmPassword">Confirm Password</label>
                            <input class="form-control w-50" type="password" name="confirmPassword">

                            <input class="btn btn-outline-primary mt-3" name="updatePasswordBtn" type="submit">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <button class="btn text-primary" id="editPassword" type="button">Edit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
    $(function() {
        var changeEmail = $('#changeEmail');
        var changePassword = $('#changePassword');
        var count = 0;
        var count2 = 0;

        changeEmail.hide();
        changePassword.hide();

        var editEmail = $('#editEmail');
        editEmail.click(() => {
            count++;
            if (count % 2 != 0) {
                changeEmail.show("slow");
            } else {
                changeEmail.hide("slow");
            }

        });

        var editPassword = $('#editPassword');
        editPassword.click(() => {
            count2++;
            if (count2 % 2 != 0) {
                changePassword.show("slow");
            } else {
                changePassword.hide("slow");
            }
        });

    });
    </script>
    <?php
    load_view("viewFooter");
    load_view("footer");
?>