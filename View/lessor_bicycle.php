<?php
    session_start();
    require_once "functions.php";
    if(!isset($_SESSION["lessor_id"])){
        redirectTo("lenderLogin.php");
    }

    require_once "../Model/Database.php";
    require_once "header.php";
    require_once "../Model/Bicycle.php";
    require_once "../ViewModel/BicycleListModel.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["updateBooking"])){
            $update_status_id = validate($_POST["bike_id"]);
            $bike_update = new Database();
            $bike_update_sql = "UPDATE `lessor_bicycle` SET `status`='in-used' WHERE `bike_id`='$update_status_id'";
            $bike_update_stmt = $bike_update->getConn()->prepare($bike_update_sql);
            $bike_update_stmt->execute();
            $bike_update_stmt->closeCursor();
        }
        if(isset($_POST["returnedBikeBtn"])){
            $in_used_bike_id = validate($_POST["bike_id"]);
            $user_id = validate($_POST["user_id"]);
            $lender_id = validate($_POST["lessor_id"]);
            $user_email = validate($_POST["email"]);
            $user_name = validate($_POST["fullname"]);
            $bike_name = validate($_POST["bike_name"]);
            $token = bin2hex(openssl_random_pseudo_bytes(40));

            $tblbusiness = new Database();
            $tblbusinessSql = "SELECT * FROM `tblbusiness` WHERE lessor_id='$lender_id'";
            $tblbusinessStmt = $tblbusiness->getConn()->prepare($tblbusinessSql);
            $tblbusinessStmt->execute();
            $businessRow = $tblbusinessStmt->fetch();
            $businessName = $businessRow["Name"];
            $businessAddress = $businessRow["Address_Line1"] . ' ' . $businessRow["Address_Line2"];
            
            $updateBicycle = new Database();
            $updateBicycleSql = "UPDATE `lessor_bicycle` SET `status`='active' WHERE `bike_id`='$in_used_bike_id' && `lessor_id`='$lender_id'";
            $updateBicycleStmt = $updateBicycle->getConn()->prepare($updateBicycleSql);
            $updateBicycleStmt->execute();
            $updateBicycleStmt->closeCursor();

            // insert data to tblfeedback
            $feedback = new Database();
            $feedbackSql = "INSERT INTO `tblfeedback` (lessor_id,User_id,Token) VALUES (:LESSOR_ID,:USER_ID,:TOKEN)";
            $feedbackStmt = $feedback->getConn()->prepare($feedbackSql);
            $feedbackStmt->bindValue(':LESSOR_ID', $lender_id, PDO::PARAM_INT);
            $feedbackStmt->bindValue(':USER_ID', $user_id, PDO::PARAM_INT);
            $feedbackStmt->bindValue(':TOKEN', $token, PDO::PARAM_STR);
            if($feedbackStmt->execute()){
                $subject = "Ezbike Payments";
                $msg = '<html>
                <head>
                    <style>
                        .container{
                            max-width: 768px;
                            margin: auto;
                        }
                        .row{
                            width: auto;
                        }
                        .p-1{
                            padding: 0.35em 1rem;
                        }
                        .text-center{
                            text-align: center;
                        }
                        .fs-18{
                            font-size: 18px;
                        }
                        h1,h2,h3,h4,h5,h6{
                            margin: 0;
                        }
                        h1,h2,h3,h4,h5,h6,p{
                            line-height: 1.75em;
                            color: #000000;
                        }
                        p{
                            font-size: 15px;
                            margin: 0;
                        }
                    </style>
                </head>
                <body>';
                $msg .= '
                <div class="container" style="border: 4px solid #414698; padding: 0;">
                        <div class="row" style="padding: 1rem;">
                            <div style="text-align: center;">
                                <img src="https://ezbikeofficial.com/assets/img/ezbike.png" style="width: 95px; height: 95px;">
                            </div>
                            <div style="border: 3px solid #f3f4f6; padding: 1rem;">
                                 <h5 style="font-size: 18px;"> <span style="font-weight: 300;"> Hi </span> '. $user_name .',</h5>
                                <h3> '.$businessName.' </h3>
                                <p> '.$businessAddress. ' </p>
                                <p> Thank you for renting out our bicycles. </p>
                                <div style="text-align: center">
                                <img src="https://ezbikeofficial.com/assets/img/customer_review_banner.png" style="width: 80%; margin: 0 auto; height: 200px;">
                                </div>
                                <p> Give us valuable feedback on your recent rental experience. We will use the feedback to help our bicycle store to deliver better product quality and services. Your experience is our outmost concern! </p>
                                <div style="text-align: center; margin: 1rem;">
                                    <a style="background: #414698; color: #fff; padding: 0.55em 1rem; border-radius: 6px; text-decoration: none;" href="http://localhost/ezbikerental/View/review.php?token='.$token.'&user_id='.$user_id.'&lessor_id='.$lender_id.'">Click to Review </a>
                                </div>

                                <p style="margin-top: 1rem;"> *Share your review to help rental users in your country and ezbike store. </p>
                            </div>
    
    
                        </div>
                </div>
                </body> </html>';
                $senderEmail = "FROM: ezbikeofficial@gmail.com\r\n";
                $senderEmail .="Reply-To: ". $user_email ."\r\n";
                $senderEmail .="MIME-version: 1.0\r\n";
                $senderEmail .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n";
                
                if(mail($user_email,$subject,$msg,$senderEmail)){
                    header("lessor_bicycle.php?success_insert=Successfully returned bicycle in shop.");
                }else{
                    header("lessor_bicycle.php?failed_insert=Successfully returned bicycle in shop.");
                }

            }


            


        }
    }

?>
<title>Ezbike | Lessor Bicycles</title>
</head>

<body>
    <div class="container-fluid web-wash">
        <div class="row">
            <div class="col-md-2 sidenav bg-dark text-light">
                <div class="text-center">
                    <img class="logo" src="../assets/img/ezbike.png" alt="">
                </div>
                <ul class="dashboard-navleft fs-14">
                    <?php
                        require_once "library.php";
                        foreach($nav_elements as $nav_data => $value){   
                            foreach($value as $key => $data_value){                                               
                    ?>
                    <li>
                        <div class="row align-items-center">
                            <div class="col-md-3 px-4">
                                <i class="<?php echo $key;?>"></i>
                            </div>
                            <div class="col-md-9 p-0">
                                <a href="<?php echo $data_value;?>"> <?php echo $nav_data; ?></a>
                            </div>
                        </div>
                    </li>
                    <?php
                            } 
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-10 main">
                <div class="row align-items-center" id="top-main">
                    <div class="col-md-6">
                        <h5 class="mt-1">Bicycle Information</h5>
                    </div>
                    <div class="col-md-6" id="nav_top_right">
                        <ul class="navright_utilities mb-0">
                            <li>
                                <a href="lessor_profile.php"><i class="fas fa-user border p-1 px-2 rounded-circle"></i>
                                    My Profile</a>
                            </li>
                            <li> | </li>
                            <li><a href="logoutLessor.php"> <i class="fas fa-sign-out-alt"></i> Log-out</a></li>
                        </ul>
                    </div>
                    <?php
                        if(isset($_GET["success_insert"])){
                        ?>
                    <div class="col-md-12 px-2">
                        <div id="success_insert" class="alert alert-success mt-2 fs-13" role="alert">
                            <i class="ti-check px-2"></i>
                            <?php echo $_GET["success_insert"] ?>
                        </div>
                    </div>
                    <?php
                            }
                        ?>
                    <?php
                            if(isset($_GET["failed_insert"])){
                        ?>
                    <div class="col-md-12 px-2">
                        <div id="failed_insert" class="alert alert-danger mt-2 fs-13" role="alert">
                            <i class="ti-close px-2"></i>
                            <?php echo $_GET["failed_insert"] ?>
                        </div>
                    </div>
                    <?php
                            }
                        ?>
                </div>
                <!-- Button trigger modal -->
                <div class="col-md-12 navbar-background mt-1 border border-2 p-2 mb-2 rounded " id="bicycle_list">
                    <button type="button" class="btn btn-primary fs-13" data-bs-toggle="modal"
                        data-bs-target="#add_bicycle">
                        <i class="fas fa-plus"></i> Add Bicycle
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="add_bicycle" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title ff-2" id="staticBackdropLabel"><i class="fa fa-plus"></i>
                                        Add New Bicycle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="requestBicycle"
                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="row ff-2">
                                            <div class="col-md-12">
                                                <h5 class="ff-4 fw-bold">Basic Information</h5>
                                                <div class="row">
                                                    <!-- left column -->
                                                    <!-- first row -->
                                                    <div class="col-md-6">
                                                        <label for="bike_name">Name: </label>
                                                        <input class="form-control" type="text" name="bike_name"
                                                            id="bike_name">
                                                        <span class="text-danger px-1" id="bike_name_validation">
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bike_brand">Brand: </label>
                                                        <input class="form-control" type="text" name="bike_brand"
                                                            id="bike_brand">
                                                        <span class="text-danger px-1" id="bike_brand_validation">
                                                        </span>
                                                    </div>
                                                    <!-- second row -->
                                                    <div class="col-md-6">
                                                        <label for="bike_type">Type: </label>
                                                        <select class="form-select" name="bike_type" id="bike_type"
                                                            id="bike_type">
                                                            <?php
                                                        foreach($bike_type as $value){
                                                            echo "<option value=\"$value\">" . $value . "</option>";
                                                        } 
                                                        ?>
                                                        </select>
                                                        <span class="text-danger px-1" id="bike_type_validation">
                                                        </span>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bike_condition">Condition: </label>
                                                        <input class="form-control" type="text" name="bike_condition"
                                                            id="bike_condition">
                                                        <span class="text-danger px-1" id="bike_condition_validation">
                                                        </span>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bike_imgLbl">Picture: </label>
                                                        <input id="bike_img" class="form-control" type="file"
                                                            name="bike_img" onchange="readURL(this)">
                                                        <span class="text-danger px-1" id="bike_img_validation"> </span>
                                                    </div>
                                                    <!-- third row -->
                                                    <div class="col-md-6">

                                                    </div>

                                                    <div class="col-md-6">
                                                        <!-- preview -->
                                                        <div class="text-center" id="bike_preview">

                                                        </div>
                                                    </div>
                                                    <h5 class="ff-4 mt-3 fw-bold">Rates</h5>
                                                    <!-- fourth row -->
                                                    <div class="col-md-6">
                                                        <label for="bike_dayRate">Day Rate</label>
                                                        <input class="form-control" type="number" name="bike_dayRate"
                                                            id="bike_rate">
                                                        <span class="text-danger px-1" id="bike_rate_validation">
                                                        </span>

                                                    </div>
                                                    <!-- sixth row -->


                                                </div>
                                            </div>
                                            <div class="col-md-12 border-start mt-3">
                                                <h5 class="ff-4 m-1 fw-bold">Components</h5>
                                                <span class="text-danger" id="components_validation"> </span>
                                                <div class="row align-items-center">
                                                    <!-- first row -->
                                                    <div class="col-md-6">
                                                        <label for="color">Color: </label>
                                                        <select class="form-select" name="color" id="bike_color">
                                                            <?php
                                                                foreach($bike_color as $value){
                                                                    echo "<option value=\"$value\">" . $value . "</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                        <span class="text-danger px-1" id="bike_color_validation">
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="frame">Frame: </label>
                                                        <input id="frame" class="form-control" type="text" name="frame">
                                                        <span class="text-danger px-1" id="bike_frame_validation">
                                                        </span>
                                                    </div>
                                                    <!-- 2nd row -->
                                                    <div class="col-md-6">
                                                        <label for="front_suspension">Front Suspension: </label>
                                                        <input id="frontsuspension" class="form-control" type="text"
                                                            name="front_suspension">
                                                        <span class="text-danger px-1"
                                                            id="bike_frontsuspension_validation"> </span>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="rear_derailleur">Rear Derailleur: </label>
                                                        <input id="rear_derailleur" class="form-control" type="text"
                                                            name="rear_derailleur">
                                                        <span class="text-danger px-1" id="rear_derailleur_validation">
                                                        </span>
                                                    </div>
                                                    <!-- 3rd row  -->
                                                    <div class="col-md-6">
                                                        <label for="brake_levers">Brake levers: </label>
                                                        <input class="form-control" type="text" name="brake_levers"
                                                            id="brake_levers">
                                                        <span class="text-danger px-1" id="brake_levers_validation">
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="brake_levers">Brakeset: </label>
                                                        <input class="form-control" type="text" name="brakeset"
                                                            id="brakeset">
                                                        <span class="text-danger px-1" id="braketset_validation">
                                                        </span>
                                                    </div>
                                                    <!-- 4th row -->
                                                    <div class="col-md-6">
                                                        <label for="crankset">Crankset: </label>
                                                        <input class="form-control" type="text" name="crankset"
                                                            id="crankset">
                                                        <span class="text-danger px-1" id="crankset_validation"> </span>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="cassette">Cassette: </label>
                                                        <input class="form-control" type="text" name="cassette"
                                                            id="cassette">
                                                        <span class="text-danger px-1" id="cassette_validation"> </span>
                                                    </div>
                                                    <!-- 5th row -->
                                                    <div class="col-md-6">
                                                        <label for="wheelset">Wheel Set: </label>
                                                        <input class="form-control" type="text" name="wheelset"
                                                            id="wheelset">
                                                        <span class="text-danger px-1" id="wheelset_validation"> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <input class="form-control btn btn-success" type="submit" name="submit"
                                                id="submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bicycle_list">


                    <div class="col-md-12">
                        <table class="table table-striped fs-12 align-items-center">
                            <thead class="table-light">
                                <th width="3.33%">bike_id</th>
                                <th width="8.33%">bike_name</th>
                                <th width="8.33%">bike_type</th>
                                <th width="8.33%">bike_brand</th>
                                <th width="13.33%">bike_img</th>
                                <th width="8.33%">bike_condition</th>
                                <th width="8.33%">date_uploaded</th>
                                <th width="8.33%">Bike Rate</th>
                                <th width="8.33%">status</th>
                                <th width="8.33%">others</th>
                                <th width="8.33%">Actions</th>
                            </thead>
                            <tbody>
                                <?php
                                    $database = new Database();
                                    $lessor_id = $_SESSION["lessor_id"];
                                
                                    $sql = "SELECT lessor_bicycle.bike_id, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.bike_img, lessor_bicycle.bike_condition, lessor_bicycle.date_uploaded, lessor_bicycle.status, lessor_bicyclerate.bike_dayRate,lessor_bicyclecomponents.color, lessor_bicyclecomponents.frame, lessor_bicyclecomponents.front_suspension, lessor_bicyclecomponents.rear_derailleur, lessor_bicyclecomponents.brake_levers, lessor_bicyclecomponents.brake_set, lessor_bicyclecomponents.crankset, lessor_bicyclecomponents.cassette, lessor_bicyclecomponents.wheelset FROM lessor_bicyclerate INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_bicyclerate.bike_id INNER JOIN lessor_bicyclecomponents ON lessor_bicycle.bike_id = lessor_bicyclecomponents.bike_id WHERE lessor_bicycle.lessor_id = '$lessor_id' && lessor_bicyclerate.lessor_id = '$lessor_id' && lessor_bicyclecomponents.lessor_id = '$lessor_id'";
                                    $stmt = $database->getConn()->prepare($sql);
                                    $stmt->execute();
                                    $count = 0;
                                    while($row = $stmt->fetch() ){  
                                    $count++;                                  
                                ?>
                                <tr class="navbar-background border border-2" style="width: 100%;">
                                    <td width="3.33%"><?php echo $row["bike_id"]; ?></td>
                                    <td class="fw-bold" width="8.33%"><?php echo $row["bike_name"]; ?></td>
                                    <td width="8.33%;"><?php echo $row["bike_type"]; ?></td>
                                    <td width="8.33%"><?php echo $row["bike_brand"]; ?></td>
                                    <td width="13.33%"><img class="bicycle-imgsize img-thumbnail"
                                            src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" alt=""></td>

                                    <td width="8.33%"><?php echo $row["bike_condition"]; ?></td>
                                    <td width="8.33%"><?php echo $row["date_uploaded"]; ?></td>
                                    <td width="8.33%">
                                        <?php echo '₱' . number_format($row["bike_dayRate"],2) ?>
                                    </td>
                                    <?php
                                        if($row["status"] == "active"){
                                    ?>
                                    <td width="8.33%">
                                        <?php echo "<span class=\"bg-success text-light p-2\"> " . $row["status"] . "</span>" ?>
                                    </td>
                                    <?php
                                        }else if($row["status"] == "booked"){
                                    ?>
                                    <td width="8.33%">
                                        <?php echo "<span class=\"bg-primary text-light p-2\"> " . $row["status"] . "</span>" ?>
                                    </td>
                                    <?php
                                        }else if($row["status"] == "in-used"){
                                    ?>
                                    <td width="8.33%">
                                        <?php echo "<span class=\"bg-dark text-light p-2\"> " . $row["status"] . "</span>" ?>
                                    </td>
                                    <?php
                                        }else if($row["status"] == "pending"){
                                    ?>
                                    <td width="8.33%">
                                        <?php echo "<span class=\"bg-warning text-light p-2\"> " . $row["status"] . "</span>" ?>
                                    </td>

                                    <?php
                                        }else if($row["status"] == "rejected"){
                                    ?>
                                    <td width="8.33%">
                                        <?php echo "<span class=\"bg-danger text-light p-2\"> " . $row["status"] . "</span>" ?>
                                    </td>
                                    <?php
                                        }
                                    ?>

                                    <td width="8.33%">
                                        <button type="button" class="btn btn-secondary fs-11 p-2" data-bs-toggle="modal"
                                            data-bs-target="#modalhere<?php echo $count; ?>">
                                            see more
                                        </button>
                                    </td>
                                    <td width="8.33%">
                                        <?php
                                            if($row["status"] == "booked"){
                                        ?>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#booking<?= $row["bike_id"] ?>"><i
                                                    class="fas fa-pen"></i></button>
                                            <!-- <button class="btn btn-danger mx-1"><i class="fas fa-trash"></i></button> -->
                                        </div>
                                        <div class="modal fade" id="booking<?= $row["bike_id"]?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Bookings
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $booking = new Database();
                                                        $bike_id = $row["bike_id"];
                                                        $bookingSql = "SELECT lessor_payment.* , tblusers.valid_id, tblusers.MobileNos, tblusers.Email, tblusers.FirstName FROM `lessor_payment` INNER JOIN tblusers ON tblusers.User_id = lessor_payment.user_id WHERE `lessor_id`='$lessor_id' && `bike_id`='$bike_id';";
                                                        $bookingStmt = $booking->getConn()->prepare($bookingSql);
                                                        $bookingStmt->execute();
                                                        $bookingRow = $bookingStmt->fetch();
                
                                                    ?>
                                                        <p><i class="fas fa-info-circle"></i> Before check-out. The
                                                            lessor must confirm the identity of the renter before
                                                            handling out the bicycle.</p>
                                                        <table class="table">
                                                            <thead>
                                                                <th>Payment Id</th>
                                                                <th>Name</th>
                                                                <th>Description</th>
                                                                <th>Ordered Bicycle</th>
                                                                <th>Pickup Date</th>
                                                                <th>Return Date</th>
                                                                <th>Email</th>
                                                                <th>Phone</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $bookingRow["payment_id"]; ?></td>
                                                                    <td><?= $bookingRow["FirstName"]; ?></td>
                                                                    <td><?= $bookingRow["bike_description"]?></td>
                                                                    <td><img class="img-thumbnail"
                                                                            src="../assets/img/uploads/<?= $bookingRow["bike_img"] ?>"
                                                                            alt=""></td>
                                                                    <td><?= $bookingRow["pickup_date"]?></td>
                                                                    <td>
                                                                        <p class="bg-danger text-light p-1">
                                                                            <?= $bookingRow["return_date"]?></p>
                                                                    </td>
                                                                    <td><?= $bookingRow["Email"] ?></td>
                                                                    <td><?= $bookingRow["MobileNos"] ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <img class="img-fluid"
                                                            src="../assets/img/valid_id/<?= $bookingRow["valid_id"] ?>"
                                                            alt="">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form
                                                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                            method="POST">
                                                            <input type="hidden" name="bike_id"
                                                                value="<?= $row["bike_id"]?>">
                                                            <button type="submit" name="updateBooking"
                                                                class="btn btn-primary">CheckOut</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }else if($row["status"] == "in-used"){
                                        ?>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#booking<?= $row["bike_id"] ?>"><i
                                                    class="fas fa-pen"></i></button>
                                        </div>
                                        <div class="modal fade" id="booking<?= $row["bike_id"]?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Returning
                                                            Bicycles</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                            $booking = new Database();
                                                            $bike_id = $row["bike_id"];
                                                            $bookingSql = "SELECT lessor_payment.* , tblusers.valid_id, tblusers.MobileNos, tblusers.Email,tblusers.FirstName FROM `lessor_payment` INNER JOIN tblusers ON tblusers.User_id = lessor_payment.user_id WHERE `lessor_id`='$lessor_id' && `bike_id`='$bike_id';";
                                                            $bookingStmt = $booking->getConn()->prepare($bookingSql);
                                                            $bookingStmt->execute();
                                                            $bookingRow = $bookingStmt->fetch();
                    
                                                        ?>
                                                        <table class="table table-stripped w-100">
                                                            <thead>
                                                                <th>Name</th>
                                                                <th>Contact</th>
                                                                <td>Description</td>
                                                                <td>Return Date</td>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $bookingRow["FirstName"] ?></td>
                                                                    <td><?= $bookingRow["MobileNos"] ?></td>
                                                                    <td><?= $bookingRow["bike_description"] ?></td>
                                                                    <td><?= $bookingRow["return_date"] ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-center mt-3">
                                                            <p class="lh-sm"> <i class="fas fa-info-circle"></i> By
                                                                clicking checkout. Your bicycle has been returned by the
                                                                renter and the bike will be available for bookings in
                                                                your shop.</p>
                                                            <p class="lh-sm">Email for store reviews will be sent via
                                                                his email.</p>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form
                                                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                            method="POST">
                                                            <input type="hidden" name="bike_id"
                                                                value="<?= $row["bike_id"]?>">
                                                            <input type="hidden" name="email"
                                                                value="<?= $bookingRow["Email"]?>">
                                                            <input type="hidden" name="fullname"
                                                                value="<?= $bookingRow["Payer_Name"] ?>">
                                                            <input type="hidden" name="bike_name"
                                                                value="<?= $bookingRow["bike_description"]?>">
                                                            <input type="hidden" name="user_id"
                                                                value="<?= $bookingRow["user_id"] ?>">
                                                            <input type="hidden" name="lessor_id"
                                                                value="<?= $bookingRow["lessor_id"] ?>">

                                                            <button type="submit" name="returnedBikeBtn"
                                                                class="btn btn-primary">CheckOut</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalhere<?php echo $count; ?>" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-secondary text-light">
                                                    <h5 class="modal-title" id="exampleModalLabel">Full
                                                        Specification</h5>
                                                    <button type="button" class="text-light btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="moreFeatures">
                                                    <div class="row">
                                                        <!-- color -->
                                                        <div class="col-md-4">
                                                            <label for="color">Color: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["color"]; ?>
                                                        </div>
                                                        <!-- frame -->
                                                        <div class="col-md-4">
                                                            <label for="frame">Frame: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["frame"]; ?>
                                                        </div>
                                                        <!-- front_suspension -->
                                                        <div class="col-md-4">
                                                            <label for="front_suspension">Front Suspension: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["front_suspension"]?>
                                                        </div>
                                                        <!-- rearDerailleur -->
                                                        <div class="col-md-4">
                                                            <label for="rear_derailleur">Rear Derailleur: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["rear_derailleur"] ?>
                                                        </div>
                                                        <!-- brake Levers -->
                                                        <div class="col-md-4">
                                                            <label for="brake_levers">Brake Levers: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["brake_levers"]; ?>
                                                        </div>
                                                        <!-- brakeset -->
                                                        <div class="col-md-4">
                                                            <label for="brakeset">Brake Set</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["brake_set"]; ?>
                                                        </div>
                                                        <!-- crankset -->
                                                        <div class="col-md-4">
                                                            <label for="crankset">Crankset: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["cassette"]; ?>
                                                        </div>
                                                        <!-- rearDerailleur -->
                                                        <div class="col-md-4">
                                                            <label for="wheelset">Wheelset: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php echo $row["wheelset"];?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function readURL(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function(event) {
                $('#bike_preview').html('<img src="' + event.target.result + '" width="200" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
    $(function(e) {


        $("#bike_img").change(function() {
            readURL(this);
        });

        $('table').DataTable({
            dom: 'Bfrtip',
            "searching": true,
            "paging": true,
            "order": [
                [0, "desc"]
            ],
            "ordering": true,
            "columnDefs": [{
                    "targets": [3],
                    /* column index */
                    "orderable": false
                },
                {
                    "targets": [1],
                    "visible": true,
                    "searchable": true
                }
            ],
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],

        });
        $('.buttons-csv').css("background", "#fff");
        $('.buttons-csv span').prepend('<i class="fas fa-file-csv p-1"> </i>');
        $('.buttons-excel').css("background", "green");
        $('.buttons-excel').css("color", "#fff");
        $('.buttons-excel span').prepend('<i class="fas fa-file-excel p-1"> </i>');
        $('.buttons-pdf').css("background", "red");
        $('.buttons-pdf').css('color', "#fff");
        $('.buttons-pdf span').prepend('<i class="fas fa-file-pdf p-1"> </i>');
        $('.buttons-print span').prepend('<i class="fas fa-print p-1"> </i>');
        $('.dataTables_wrapper .dataTables_filter input').addClass("form-control");
        $('label').addClass('d-flex align-items-center mb-2 mx-2');
        $('table tr td').css("vertical-align", "middle");
        $('table tr th').css("vertical-align", "middle");


        $('table tr td').css("vertical-align", "middle");
        $('table tr th').css("vertical-align", "middle");
        $('#success_insert').fadeOut(6000);
        $('#failed_insert').fadeOut(6000);
        $('label').css("font-size", "14px");
        $('#requestBicycle .row .col-md-6 .row > div').css("margin-top", ".75em");
        $("#moreFeatures .row div").css("margin-top", "0.35em");
        $("#moreFeatures .row div label").css("font-weight", "bold");
        $("#moreFeatures .row .col-md-8").addClass("border border-1 p-1");

        let bike_name = $('#bike_name').val();
        let bike_brand = $('#bike_brand').val();
        let bike_type = $('#bike_type').val();
        let bike_condition = $('#bike_condition').val();
        let bike_rate = $('#bike_rate').val();
        let submit = $('#submit');


    });
    </script>
    <?php
    require "footer.php";
?>