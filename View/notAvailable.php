<?php
    session_start();
    require_once "header.php";
    require_once "../Model/Database.php";
    require_once "functions.php";

?>

<body>
    <div class="container">
        <nav class="d-flex flex-row align-items-center p-1 border-bottom">
            <div class="col-md-3 text-light">
                <a class="text-light" href="../index.php">
                    <img class="logo" src="../assets/img/mainezbike_logo.png" alt="">
                </a>
            </div>
            <div class="col-md-9" id="nav-right">
                <form action="search.php" class="d-flex align-items-center">
                    <?php
                            if(isset($_GET["location_search"])){
                        ?>
                    <input style="height: 45px;" class="form-control" name="location" type="text" id="cityInput"
                        value="<?= $location ?>" placeholder="search">
                    <?php
                            }else{
                        ?>
                    <input style="height: 45px;" class="form-control" name="location" type="text" id="cityInput"
                        placeholder="search">
                    <?php
                            }
                        ?>
                    <button name="location_search" type="submit" style="height: 45px;" class="btn btn-search border">
                        <i class="ti-search"></i>
                    </button>
                </form>
                <ul class="main-navbar pt-3">
                    <?php
                                if(isset($_SESSION["Email"])){
                                    echo "<li> <a href=\"myRentals.php\">" . $_SESSION["FirstName"]. "</a></li>";
                                    echo "<li> <a class=\"fs-13\" href=\"logout.php\"> Logout </a></li>";
                                }else{
                            ?>
                    <li><a href="login.php">Log in</a></li>
                    </li>
                    <li><a href="userRegistration.php">Sign up</a></li>
                    </li>
                    <li><a href="login.php"><i class="ti-shopping-cart"></i></a></li>
                    </li>
                    <?php
                                }
                            ?>
                </ul>
            </div>
        </nav>
        <div class="show404 text-center p-5">
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle fa-4x text-danger"></i>
            </div>

            <h1> Ooops! 404. That's an error </h1>
            <p>The requested URL / badpage was not found on this server. Please select bicycle shop -> bicylce to rent &
                fill up the remaining fields</p>
            <a href="search.php">Search Store</a>
        </div>
    </div>
    <?php
        require_once "viewFooter.php";
    ?>
    <script>
    $(function() {
        $('label').css("font-size", "14px");
        // $('#filters').click(function (){
        //     $('#formFilters').fadeOut("slow");
        // });            
    });
    </script>
    <?php
        require_once "footer.php";
    ?>