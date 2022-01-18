<?php
  
    session_start();
    require_once "functions.php";
    if(isset($_SESSION["lessor_id"])){
        redirectTo("lessor_dash.php");
    }

    require_once "../Model/Registration.php";
    require_once "../Model/Database.php";
    require_once "../Model/Lessor.php";


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["loginLender"])){
            $lessor = new Lessor();
            $lessor->setEmail(validate($_POST["lessor_email"]));
            $lessor->setPassword(validate($_POST["lessor_password"]));
            
            $lessor->lessorLogin($lessor->getEmail(), $lessor->getPassword());
            // redirectTo("lessor_dash.php");
        }
    }
    require_once "header.php";
?>
<title> Ezbike | Lender Login </title>
</head>

<body>

    <div class="container" style="height: 100vh;">
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
            <div class="col-4 shadow rounded p-4">
                <div class="text-center">
                    <a href="../index.php">
                        <img class="logo" src="../assets/img/ezbike.png" alt="">
                    </a>
                </div>
                <?php
                    if(isset($_GET["login_attempt"])){
                ?>
                <div class="alert alert-danger p-2 text-center fs-13" role="alert">
                    <?php echo $_GET["login_attempt"]; ?>
                </div>
                <?php
                    }

                    if(isset($_GET["login_msg"])){
                    ?>
                <div class="text-center border border-success text-success p-1 mb-1">
                    <?php echo $_GET["login_msg"]; ?>
                </div>

                <?php
                    }
                ?>

                <form class="pt-4 pb-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input class="form-control mt-2" type="text" name="lessor_email" placeholder="Email">
                    <input class="form-control mt-2" type="password" name="lessor_password" placeholder="Password">
                    <input class="form-control btn btn-indigo mt-2" type="submit" name="loginLender" value="Log in">
                    <p class="text-center mt-2"><a href="RecoverLessor.php" class="text-secondary">Forgot password?
                        </a> </p>
                </form>
            </div>

        </div>
    </div>
    <script>
    $(function() {
        $('#btnUser').removeClass("btn-success");
        $('#btnUser').addClass("btn-secondary");
        $('#btnUser').click(function() {
            window.location.href = "login.php";
        });
        $('#btnLender').removeClass('btn-secondary');
        $('#btnLender').addClass('btn-success');


    });
    </script>
    <?php
        require_once "footer.php";
    ?>