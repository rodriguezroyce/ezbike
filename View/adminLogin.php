<?php
    session_start();
    require_once "../Model/AdminLogin.php";
    include_once "functions.php";
    $adminLogin = new AdminLogin();
    if(isset($_SESSION["admin_id"])){
        redirectTo("adminDashboard.php");
    }

    if(isset($_POST["submit"])){
        $adminLogin->setUsername(validate($_POST["admin_username"]));
        $adminLogin->setPassword(validate($_POST["admin_password"]));
    
        if($adminLogin->isNotEmpty($adminLogin->getUsername(), $adminLogin->getPassword())){
            $adminLogin->authenticate($adminLogin->getUsername(), $adminLogin->getPassword());
        }else{
            redirectTo("adminLogin.php?validation_error=The email or password you entered is not connected to an account.");
        }
    }


    require_once "header.php";

?>
<link rel="stylesheet" href="../assets/css/admin.css">
<title> Login | EzbikeOfficial </title>
</head>

<body>
    <div class="container" style="height: 100vh;">
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
            <div class="col-4 shadow rounded p-4" id="admin_form">
                <div class="text-center">
                    <a href="../index.php">
                        <img class="logo" src="../assets/img/ezbike.png" alt="">
                    </a>
                </div>
                <?php
                        if(isset($_GET["validation_error"])){
                    ?>
                <div class="text-danger text-center p-2 fs-12 mb-0" role="alert">
                    <?php echo $_GET["validation_error"]; ?>
                </div>
                <?php
                        };
                    ?>
                <form class="pt-1 pb-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input class="form-control mt-2" type="text" name="admin_username" placeholder="Email">
                    <input class="form-control mt-2" type="password" name="admin_password" placeholder="Password">
                    <input class="form-control btn btn-indigo mt-2" type="submit" name="submit" value="Log in">
                    <p class="text-center mt-2"><a href="RecoverAccount.php" class="text-secondary">Forgot password?
                        </a> </p>
                </form>
            </div>

        </div>
    </div>


    <script>
    if ($(window).innerWidth() <= 414) {
        $('#admin_form').removeClass("col-4");
        $('#admin_form').addClass("col-12");
    }
    </script>
    <?php
    require_once "footer.php";
?>