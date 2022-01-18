<?php
    session_start();
    require_once "Page.php";
    require_once "../Model/Database.php";
    require_once "../Model/BusinessModel.php";
    require_once "../Model/Lessor.php";
    require_once "library.php";
    require_once "barangay.php";
    require_once "functions.php";
    
    if(isset($_GET["lessorid"])){
            $my_id = $_GET["lessorid"];
            $db = new Database();
            $sql = "SELECT tblbusiness.Name, tblbusiness.Banner, CONCAT(tblbusiness.Address_Line1, tblbusiness.Address_Line2) AS 'Business_Address', tblbusiness.Zip_Code, tbllessor.lessor_phone, tblbusiness.Region, tblbusiness.Province, tblbusiness.City, tblbusiness.Barangay FROM tblbusiness INNER JOIN tbllessor ON tblbusiness.lessor_id = tbllessor.lessor_id WHERE tblbusiness.lessor_id = '$my_id' ";
            $db->query($sql);
            $db->execute();
            if($db->rowCount() == 0){
                redirectTo("show404.php");
            }

            $row = $db->statement()->fetch();
            if($row){
                $businessInfo = new BusinessModel();
                $businessInfo->setBusinessAddress($row["Business_Address"]);
                $businessInfo->setStoreName($row["Name"]);
                $businessInfo->setBanner($row["Banner"]);
                $businessInfo->setZipCode($row["Zip_Code"]);
                $businessInfo->setPhone($row["lessor_phone"]);
                // 
                foreach($region as $key => $values){
                    if($key == $row["Region"]){
                        $businessInfo->setRegion($values);
                    }
                }
                foreach($province as $key => $values){
                    if($key == $row["Province"]){
                        $businessInfo->setProvince($values);
                    }
                }
                foreach($city as $key => $values){
                    if($key == $row["City"]){
                        $businessInfo->setCity($values);
                    }
                }
                foreach($barangay as $key => $values){
                    if($key == $row["Barangay"]){
                        $businessInfo->setBarangay($values);
                    }
                }


            }
    }else{
        redirectTo("show404.php");
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
        $bike_types = $_SESSION["shopping_cart"]["bike_type"];
        $bike_brand = $_SESSION["shopping_cart"]["bike_brand"];
        $bike_img = $_SESSION["shopping_cart"]["bike_img"];
    }
    if(isset($_GET["reportBtn"])){
        if(isset($_GET["reportContent"]) && isset($_GET["additionalComments"])){
            $reportContent = $_GET["reportContent"];
            $additionalComments = $_GET["additionalComments"];
            $tblreport = new Database();
            $tblreportSql = "INSERT INTO `tblreport` (`lessor_id`,`User_id`,`CategoryReport`,`Comment`) VALUES (:LESSOR_ID,:USER_ID,:CATEGORY_REPORT,:COMMENT)";
            $tblreportStmt = $tblreport->getConn()->prepare($tblreportSql);
            $tblreportStmt->bindValue(':LESSOR_ID', $_GET["lessorid"], PDO::PARAM_INT);
            $tblreportStmt->bindValue(':USER_ID', $_SESSION['User_id'], PDO::PARAM_INT);
            $tblreportStmt->bindValue(':CATEGORY_REPORT', $reportContent, PDO::PARAM_STR);
            $tblreportStmt->bindValue(':COMMENT', $additionalComments, PDO::PARAM_STR);
            $myid = $_GET["lessorid"];
            if($tblreportStmt->execute()){
                redirectTo("clientPage.php?lessorid=$myid&success_report=Report has been successfully made.");
            }
            $tblreportStmt->closeCursor();
        }


    }


    require_once "header.php";

?>
<title> Ezbike | <?= $businessInfo->getStoreName() ?> </title>
</head>

<body>
    <div class="container">
        <nav class="d-flex flex-row align-items-center p-1 border-bottom" id="navbar">
            <div class="col-md-1 text-light">
                <a class="text-light" href="../index.php">
                    <img class="logo" src="../assets/img/mainezbike_logo.png" alt="">
                </a>
            </div>
            <!-- end -->
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
                    <button name="location_search" type="submit" style="height: 45px;" class="btn btn-search border"
                        id="searchBtn">
                        <i class="ti-search"></i>
                    </button>
                </form>
                <ul class="main-navbar pt-3">
                    <?php
                                if(isset($_SESSION["Email"])){
                                    echo "<li> <a href=\"myAccount.php\">" . $_SESSION["FirstName"]. "</a></li>";
                                    echo "<li> <a class=\"fs-13\" href=\"logout.php\"> Logout </a></li>";
                                    if(isset($_SESSION["shopping_cart"])){
                                        echo "<li> <a class=\"fs-13\" href=\"payment.php?bike_id=$bike_id&lessorid=$lessor_id&rate_type=$rate_type&startDate=$pickup_date&returnDate=$end_date&totalAmt=$totalAmt&days=$days&bike_name=$bike_name&bike_type=$bike_types&bike_brand=$bike_brand&bike_img=$bike_img\"> <i class=\"ti-shopping-cart\"> </i> </a></li>";
                                    }else{
                                        echo "<li><a href=\"payment.php\"><i class=\"ti-shopping-cart\"></i></a></li>";
                                    }

                                }else{
                            ?>
                    <li><a href="../View/login.php">Log in</a></li>
                    <li><a href="userRegistration.php">Sign up</a></li>

                    <?php
                                }
                            ?>
                </ul>
            </div>
            <!-- end inside nav -->
        </nav>
        <!-- nav end -->
    </div>
    <!-- container end -->
    <div class="container-fluid">
        <?php
            if(isset($_GET["ratings"])){

        ?>
        <input type="hidden" id="ratings" value="<?= $_GET["ratings"] ?>">
        <div id="feedbacks" class="ratings-message rounded shadow">
            <?= $_GET["ratings"]?>
        </div>
        <?php
            }
        ?>

        <div class="container mt-1 p-2">
            <div class="cover-page">
                <div class="path text-secondary fs-14 px-4">
                    <a class="text-secondary" href="search.php">search</a> / <a class="text-dark border-bottom border-2"
                        href="clientPage.php?lessorid=<?= $_GET["lessor_id"] ?>"><?= $businessInfo->getStoreName() ?></a>
                </div>
                <!-- store name end -->
                <div class="row p-3 aling-items-center">
                    <div class="col-md-12 pt-3 pb-3 bg-white">
                        <div class="row justify-content-center" id="shop-info">
                            <div class="col-md-2 text-center">
                                <img class="shadow border border-1 p-1"
                                    style="width: 120px; height: 120px; border-radius: 50%;"
                                    src="../assets/img/businessImg/<?php echo $businessInfo->getBanner() ?>" alt="">
                            </div>
                            <!-- col-md-2 end -->
                            <div class="col-md-10">
                                <h3 class="mt-1 mb-1 ff-7 fw-bold"> <?php echo $businessInfo->getStoreName(); ?> </h3>
                                <p class="pe-5 mb-1 ff-7 fs-15" style="color: #888B9B;">Bicycle Rental Service • </p>
                                <div class="d-flex" style="color: #888B9B;" id="address">
                                    <div class="d-flex align-items-center">
                                        <i class="ti-location-pin"></i>
                                        <p class="mb-0 mx-1 fs-14">
                                            <?= $businessInfo->getProvince() . " , " . $businessInfo->getCity() . ' ' . $businessInfo->getBarangay() ?>
                                        </p>
                                    </div>


                                </div>
                                <!-- d-flex end -->
                                <div class="ratings mt-1 ff-7 fs-14">
                                    <?php
                                            $feedbackDb = new Database();
                                            $feedBacksql = "SELECT * FROM `tblfeedback` WHERE `lessor_id`='$my_id'";
                                            $feedbackStmt = $feedbackDb->getConn()->prepare($feedBacksql);
                                            $feedbackStmt->execute();
                                            $score = 0;
                                            $scoreTotal = 0;
                                            $rowCount = $feedbackStmt->rowCount();
                                            if($rowCount != 0){
                                                while($feedbackRow = $feedbackStmt->fetch()){
                                                
                                                    $score+= $feedbackRow["Score"];
                                                    $scoreTotal = $scoreTotal + 5;
                                                }
                                                    // ratings score
                                                    $totalRatings = $score / $scoreTotal;
                                                    echo "<span class=\"text-secondary\">(".$rowCount .")</span>";
                                                    if($totalRatings > 0.80){   
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';

                                                    }else if($totalRatings > 0.60){
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                                    }else if($totalRatings > 0.40){
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                                    }else if($totalRatings > 0.20){
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                                    }else if($totalRatings > 0){
                                                        echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                                        echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                                    }else{
                                                        echo "no reviews";
                                                    }

                                            }else{
                                                echo "<span> 0 </span>";
                                                echo "<span class=\"text-secondary\"> No reviews</span>";

                                            }
                                        ?>


                                </div>
                                <!-- ratings end -->
                                <div class="mt-1">
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"> <i class="fas fa-flag"></i> Report</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><i
                                                            class="fas fa-flag"></i> Reason for report</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body bg-light">
                                                    <?php
                                                    if(isset($_SESSION["User_id"])){
                                                ?>
                                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                        method="GET">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between m-1 p-1">
                                                            <label for="label_1">Innapropriate Content</label>
                                                            <input type="hidden" name="lessorid"
                                                                value="<?= $_GET["lessorid"]; ?>">
                                                            <input type="radio" class="form-check-input"
                                                                name="reportContent" value="Innapropriate Content">
                                                        </div>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between m-1 p-1">
                                                            <label for="label_2">Incorrect Information</label>
                                                            <input type="radio" class="form-check-input"
                                                                name="reportContent" value="Incorrect Information">
                                                        </div>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between m-1 p-1">
                                                            <label for="label_3">Abusive Language</label>
                                                            <input type="radio" class="form-check-input"
                                                                name="reportContent" value="Abusive Language">
                                                        </div>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between m-1 p-1">
                                                            <label for="label_3">Poor rental experience</label>
                                                            <input type="radio" class="form-check-input"
                                                                name="reportContent" value="Poor rental experience">
                                                        </div>
                                                        <div class="form-floating border border-bottom">
                                                            <textarea
                                                                style="resize: none; height: 125px; overflow: auto;"
                                                                class="form-control" placeholder="Leave a comment here"
                                                                name="additionalComments"
                                                                id="floatingTextarea"></textarea>
                                                            <label for="floatingTextarea">Additional Comments</label>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="reportBtn"
                                                                class="btn btn-danger">Report</button>
                                                        </div>
                                                    </form>
                                                    <?php
                                                    }else{
                                                ?>
                                                    <p class="text-center p-1">Please <a
                                                            href="login.php?redirect=<?= $_GET["lessorid"] ?>">Log
                                                            in</a> to continue</p>
                                                    <?php
                                                    }
                                                ?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                if(isset($_GET["success_report"])){
                                            ?>
                                    <div class="col-md-12 px-2">
                                        <div id="success_report" class="alert alert-success mt-2 fs-13" role="alert">
                                            <i class="ti-check px-2"></i>
                                            <?php echo $_GET["success_report"] ?>
                                        </div>
                                    </div>
                                    <?php
                                                }
                                                ?>

                                </div>


                            </div>
                            <!-- col-md-10 end -->
                        </div>
                        <!-- row end -->
                    </div>
                    <!-- col-md-12 end -->
                    <div class="col-md-12 pt-3 mt-2 pb-3 bg-white">
                        <!-- d-flex start -->
                        <div class="d-flex flex-row justify-content-between" id="setfilters">
                            <div>
                                <h3 class="mt-2 mb-1">Set your rental filters</h3>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary mx-2 p-2 py-2"
                                    id="filters">Filters <i class="fas fa-bars"></i> </button>
                            </div>
                        </div>
                        <!-- d-flex end -->
                        <form id="formFilters" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="GET">
                            <div id="row_filter">
                                <div class="col me-3">
                                    <h5 class="mt-2">Bike Type</h5>
                                    <input type="hidden" name="lessorid" value="<?php echo $_GET["lessorid"]; ?>">
                                    <select class="form-select" name="bike_type" id="bike_type">
                                        <?php
                                                $count_bike_types =  count($bike_type);
                                                for($i=0; $i < $count_bike_types; $i++){
                                                    if(isset($_GET["bike_type"])){
                                                        if($_GET["bike_type"] == $bike_type[$i]){
                                            ?>
                                        <option selected value="<?php echo $bike_type[$i]; ?>">
                                            <?php echo $bike_type[$i]; ?></option>
                                        <?php
                                                        }else{
                                            ?>
                                        <option value="<?php echo $bike_type[$i]; ?>"><?php echo $bike_type[$i]; ?>
                                        </option>

                                        <?php
                                                        }
                                                    }else{
                                            ?>
                                        <option value="<?php echo $bike_type[$i]; ?>"><?php echo $bike_type[$i]; ?>
                                        </option>

                                        <?php
                                                    }
                                                    
                                            ?>
                                        <?php
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="col me-3">
                                    <h5 class="mt-2">Availability</h5>
                                    <select class="form-select" name="status" id="availability">
                                        <?php
                                                if(isset($_GET["status"])){
                                                    switch($_GET["status"]){
                                                        case "active":
                                                            echo '<option selected value="active"> Available </option>';
                                                            echo '<option value="booked">Booked</option>';
                                                            echo '<option value="in-used">Currently In-used</option>';
                                                            break;
                                                        case "booked":
                                                            echo '<option value="active"> Available </option>';
                                                            echo '<option selected value="booked"> Booked </option>';
                                                            echo '<option value="in-used">Currently In-used</option>';
                                                            break;
                                                        case "in-used":
                                                            echo '<option value="active"> Available </option>';
                                                            echo '<option value="booked"> Booked </option>';
                                                            echo '<option selected value="in-used"> Currently In-used </option>';
                                                            break;
                                                        default:
                                                            echo '<option value="active"> Available </option>';
                                                            echo '<option value="booked"> Booked </option>';
                                                            echo '<option value="in-used"> Currently In-used </option>';
                                                            break;
                                                    }
                                                }else{
                                            ?>
                                        <option value="active">Available</option>
                                        <option value="booked">Booked</option>
                                        <option value="in-used">Currently In-used</option>
                                        <?php
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="col me-3">
                                    <h5 class="mt-2">Sort By</h5>
                                    <select class="form-select" name="sortby" id="sortby">
                                        <?php
                                                if(isset($_GET["sortby"])){
                                                    switch($_GET["sortby"]){
                                                        case "DESC":
                                                                echo '<option selected value="DESC"> Most Recent </option>';
                                                                echo '<option value="ASC"> Upload Date </option>';
                                                                break;
                                                        case "ASC":
                                                                echo '<option value="DESC"> Most Recent </option>';
                                                                echo '<option selected value="ASC"> Upload Date </option>';
                                                                break;
                                                        default:
                                                                echo '<option value="DESC"> Most Recent </option>';
                                                                echo '<option value="ASC"> Upload Date </option>';
                                                                break;
                                                    }
                                                }else{
                                                ?>
                                        <option value="DESC">Most Recent</option>
                                        <option value="ASC">Upload Date</option>
                                        <?php

                                                }

                                            ?>

                                    </select>
                                </div>
                                <div class="col me-3">
                                    <div class="text-center mt-3">
                                        <label for=""></label>
                                        <input class="btn btn-indigo form-control" name="applyFilter" type="submit"
                                            value="Apply Filter">
                                    </div>
                                </div>
                            </div>

                        </form>
                        <!-- form end -->
                    </div>
                    <!-- col-md-12 end -->
                    <div class="col-md-12 p-2">
                        <div class="row p-1">
                            <?php 
                                $bicycleRetrieve = new Database();
                                if(isset($_GET["lessorid"])){
                                    if(isset($_GET["applyFilter"])){
                                        $bike_type = $_GET["bike_type"];
                                        $status = $_GET["status"];
                                        $sortby = $_GET["sortby"];

                                        $bicycleSql = sortBy($my_id,$bike_type,$status,$sortby);
                                    }else{
                                        $bicycleSql = bicycleListSql($my_id);
                                    }
                                }
                                
                                $bicycleStmt = $bicycleRetrieve->getConn()->prepare($bicycleSql);
                                $bicycleStmt->execute();
                                if($bicycleStmt->rowCount() == 0){
                                    echo "<div class=\"text-center p-4\"> <i class=\"fas fa-box fa-4x text-yellow\"> </i> <h2> No items found </h2> <p> Please refresh the page and try again! </p> </div>";
                                }
                                while($row = $bicycleStmt->fetch()){
                            ?>

                            <?php
                                        if($row["status"] == "booked"){
                                    ?>
                            <div class="col-md-3 p-1">
                                <div class="card round">
                                    <img src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" class="card-img-top"
                                        alt="...">
                                    <div class="card-body">
                                        <div>
                                            <p class="mb-0">
                                                <span class="fw-bold"><?php echo $row["bike_name"] ?>
                                                </span>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <small class="text-secondary rounded fs-12 bike_types">
                                                        <?php echo $row["bike_type"] ?>
                                                    </small>
                                                    <p class="text-light fs-12 mb-0">
                                                        <?php
                                                            if($row["status"] == "booked" || $row["status"] == "in-used"){
                                                                echo "<span class=\"bg-danger p-1\"> booked </span>";
                                                            }else{
                                                                echo "<span class=\"bg-indigo p-1\"> available </span>";
                                                            }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="fs-16 fw-bold p-1 mb-0">
                                                    ₱<?= number_format($row["bike_dayRate"],"2")?> / day
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php   
                                        }else if($row["status"] == "in-used"){
                                ?>
                            <div class="col-md-3 p-1">
                                <div class="card round">
                                    <img src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" class="card-img-top"
                                        alt="...">
                                    <div class="card-body">
                                        <div>
                                            <p class="mb-0">
                                                <span class="fw-bold"><?php echo $row["bike_name"] ?>
                                                </span>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <small class="text-secondary rounded fs-12 bike_types">
                                                        <?php echo $row["bike_type"] ?>
                                                    </small>
                                                    <p class="text-light fs-12 mb-0">
                                                        <?php
                                                                if($row["status"] == "in-used"){
                                                                    echo "<span class=\"bg-dark text-light p-1\"> in-used </span>";
                                                                }
                                                            ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="fs-16 fw-bold p-1 mb-0">
                                                    ₱<?= number_format($row["bike_dayRate"],"2")?> / day
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                
                                        }else if($row["status"] == "pending" || $row["status"] == "rejected"){
                                            continue;
                                        }else{
                                    ?>
                            <div class="col-md-3 p-1">
                                <a class="text-dark"
                                    href="productItem.php?lessorid=<?php echo $my_id; ?>&bike_id=<?php echo $row["bike_id"] ?>&store_name=<?= $businessInfo->getStoreName() ?>">
                                    <div class="card round">
                                        <img src="../assets/img/uploads/<?php echo $row["bike_img"] ?>"
                                            class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <div>
                                                <p class="mb-0">
                                                    <span class="fw-bold"><?php echo $row["bike_name"] ?>
                                                    </span>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-secondary rounded fs-12 bike_types">
                                                            <?php echo $row["bike_type"] ?>
                                                        </small>
                                                        <p class="bg-indigo text-light fs-12 p-1 mb-0">
                                                            <?php
                                                               if($row["status"] == "booked" || $row["status"] == "in-used"){
                                                                    echo "not available";
                                                                }else{
                                                                    echo "available";
                                                                }
                                                                ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="fs-16 fw-bold p-1 mb-0">
                                                        ₱<?= number_format($row["bike_dayRate"],"2")?> / day
                                                    </p>

                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </a>
                            </div>
                                <?php
                                    }
                                    ?>

                            <!-- col-md-3 end -->
                            <?php
                                }
                                // bike loop end
                            ?>
                        </div>
                    </div>
                    <!-- col-md-12 end -->

                </div>
                <!-- reviews & comments -->
                <div class="mt-5">
                    <?php
                                $feedback = new Database();
                                $feedbackSql = "SELECT tblfeedback.* , tblusers.FirstName  FROM `tblfeedback` INNER JOIN tblusers ON tblusers.User_id = tblfeedback.User_id WHERE `lessor_id`=:LESSORID && `status`='ON';";
                                $reviewStmt = $feedback->getConn()->prepare($feedbackSql);
                                $reviewStmt->bindValue(':LESSORID', $_GET["lessorid"], PDO::PARAM_INT);
                                $reviewStmt->execute();
                            ?>
                    <table class="table">
                        <thead>
                            <th> Reviews & Comments </th>
                            <th> </th>
                        </thead>
                        <tbody>

                            <?php
                                while($reviewRows = $reviewStmt->fetch()){
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex py-2" id="user_img">
                                        <div class="col-md-1 p-0">
                                            <div>
                                                <img class="img-fluid rounded-circle" src="../assets/img/avatar.png"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-11">
                                            <p class="mb-0 mt-3"><?= $reviewRows["FirstName"] ?></p>
                                            <p class="fst-italic fs-11 mb-0"><?= $reviewRows["Date_Reviewed"] ?></p>

                                            <div class="user_ratings">
                                                <?php
                                        if($reviewRows["Score"] == 1){
                                    ?>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <?php
                                        }else if($reviewRows["Score"] == 2){
                                    ?>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <?php
                                        }else if($reviewRows["Score"] == 3){
                                    ?>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <?php
                                        }else if($reviewRows["Score"] == 4){
                                    ?>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-light"></i>
                                                <?php
                                        }else{
                                    ?>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <i class="fas fa-star text-yellow"></i>
                                                <?php
                                        }
                                    ?>
                                            </div>
                                            <!-- user ratings end -->
                                            <div class="comments">
                                                <p><?= $reviewRows["Comment"] ?> </p>
                                            </div>
                                            <!-- comments end -->
                                        </div>
                                        <!-- col-md-11 end -->
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">

                                </td>
                            </tr>
                            <!-- d-flex end -->
                            <?php
                                }   
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- row end -->
            </div>
            <!-- cover page end -->
        </div>
        <!-- container end -->
    </div>
    <!-- container fluid end -->
    <script>
    $(function() {
        $('table').DataTable({
            dom: 'Bfrtip',
            "searching": false,
            "paging": true,
            "order": [
                [0, "desc"]
            ],
            "ordering": true,
            "columnDefs": [{
                    "targets": [0],
                    /* column index */
                    "orderable": false
                },
                {
                    "targets": [0],
                    "visible": true,
                    "searchable": true
                }
            ],
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ]
        });
        $('.dt-buttons').hide();
        $('.dataTables_info').hide();
        $('#DataTables_Table_0_filter').hide();
        $('#feedbacks').hide();
        $('.dataTables_empty').html("no reviews found");
        $('#success_report').fadeOut(5000);

        var filter = $('#filters');
        var row_filter = $('#formFilters');
        var count = 0;

        var poorRatings = $('#poor-ratings');
        var weekRatings = $('#weak-ratings');
        var goodRatings = $('#good-ratings');
        var veryGoodRatings = $('#verygood-ratings');
        var excellentRatings = $('#excellent-ratings');

        var lessorid = $('#lessorid').val();
        var userid = $('#User_id').val();

        var ratings = $('#ratings').val();
        if (ratings != null) {
            $('#feedbacks').show("slow");
            $('#feedbacks').fadeOut(5000);
        }



        poorRatings.hide();
        weekRatings.hide();
        goodRatings.hide();
        veryGoodRatings.hide();
        excellentRatings.hide();


        $('.searchBtn').click(() => {
            window.location.href = "search.php";
        });
        var one_star = $('#one-star');
        var two_star = $('#two-star');
        var three_star = $('#three-star');
        var four_star = $('#four-star');
        var five_star = $('#five-star');

        var ratings;

        one_star.click(function() {
            poorRatings.show();
            weekRatings.hide();
            goodRatings.hide();
            veryGoodRatings.hide();
            excellentRatings.hide();
            console.log(lessorid);
            console.log(userid);
            var data = {};
            data.lessorid = lessorid;
            data.userid = userid;
            data.ratings = 1;
            feedback(data);
        });

        two_star.click(function() {
            poorRatings.hide();
            weekRatings.show();
            goodRatings.hide();
            veryGoodRatings.hide();
            excellentRatings.hide();
            var data = {};
            data.lessorid = lessorid;
            data.userid = userid;
            data.ratings = 2;
            feedback(data);
        });

        three_star.click(function() {
            poorRatings.hide();
            weekRatings.hide();
            goodRatings.show();
            veryGoodRatings.hide();
            excellentRatings.hide();
            var data = {};
            data.lessorid = lessorid;
            data.userid = userid;
            data.ratings = 3;
            feedback(data);
        });

        four_star.click(function() {
            poorRatings.hide();
            weekRatings.hide();
            goodRatings.hide();
            veryGoodRatings.show();
            excellentRatings.hide();
            var data = {};
            data.lessorid = lessorid;
            data.userid = userid;
            data.ratings = 4;
            feedback(data);
        });
        five_star.click(function() {
            poorRatings.hide();
            weekRatings.hide();
            goodRatings.hide();
            veryGoodRatings.hide();
            excellentRatings.show();
            var data = {};
            data.lessorid = lessorid;
            data.userid = userid;
            data.ratings = 5;
            feedback(data);
        });
        filter.click(() => {
            count++;
            if (count % 2 != 0) {
                row_filter.show("fast");
            } else {
                row_filter.hide("fast");
            }

        });
    });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places">
    </script>
    <script src="../assets/js/autoComplete.js"></script>
    <?php
       load_view("viewFooter");
       load_view("footer");
    ?>