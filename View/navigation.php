<nav class="d-flex flex-row align-items-center p-1 border-bottom" id="navbar">
    <div class="col-md-1 text-light">
        <a class="text-light" href="../index.php">
            <img class="logo" src="../assets/img/mainezbike_logo.png" alt="">
        </a>
    </div>
    <div class="col-md-11" id="header-nav">
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
            <button name="location_search" id="searchBtn" type="submit" style="height: 45px;"
                class="btn btn-search border">
                <i class="ti-search"></i>
            </button>
        </form>
        <ul class="main-navbar pt-3">
            <?php
                            if(isset($_SESSION["Email"])){
                                echo "<li> <a href=\"myAccount.php\">" . $_SESSION["FirstName"]. "</a></li>";
                                echo "<li> <a class=\"fs-13\" href=\"logout.php\"> Logout </a></li>";
                                if(isset($_SESSION["shopping_cart"])){
                                    echo "<li> <a class=\"fs-13\" href=\"payment.php?bike_id=$bike_id&lessorid=$lessor_id&rate_type=$rate_type&startDate=$pickup_date&returnDate=$end_date&totalAmt=$totalAmt&days=$days&bike_name=$bike_name&bike_type=$bike_type&bike_brand=$bike_brand&bike_img=$bike_img\"> <i class=\"ti-shopping-cart\"> </i> </a></li>";
                                }else{
                                    echo "<li><a href=\"payment.php\"><i class=\"ti-shopping-cart\"> </i></a></li>";
                                }

                            }else{
                        ?>
            <li><a href="login.php">Log in</a></li>
            <li><a href="userRegistration.php">Sign up</a></li>
            <?php
                            }
                        ?>
        </ul>
    </div>
</nav>