<?php
    session_start();
    require_once "functions.php";
    if(!isset($_SESSION["lessor_id"])){
        redirectTo("lenderLogin.php?login_attempt=Session Expired!");
    }
    require_once "../Model/Bicycle.php";
    require_once "header.php";
?>
<title>Ezbike | Lessor Dashboard</title>
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
                        <h5 class="mt-1 ff-1">Dashboard</h5>
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
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex" id="dashboard-box">
                                    <div class="col dash-box shadow">
                                        <?php
                                            $db = new Database();
                                            $sql = "SELECT COUNT(bike_id) AS 'Bike_List' FROM `lessor_bicycle` WHERE lessor_id=:LESSOR_ID;";
                                            $stmt = $db->getConn()->prepare($sql);
                                            $stmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"]);
                                            $stmt->execute();
                                            $row = $stmt->fetch();
                                            $stmt->closeCursor();
                                        ?>
                                        <h4><?= $row["Bike_List"] ?></h4>
                                        <p>Bicycle Listed</p>
                                    </div>
                                    <?php
                                                $bookings = new Database();
                                                $bookingsSql = "SELECT `total_amt` FROM `lessor_payment` WHERE `lessor_id`=:LESSOR_ID;";
                                                $bookingStmt = $bookings->getConn()->prepare($bookingsSql);
                                                $bookingStmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"]);
                                                $bookingStmt->execute();
                                                $bookingTotal = 0;
                                                while($bookingRow = $bookingStmt->fetch()){
                                                    $bookingTotal += $bookingRow["total_amt"];
                                                }
                                            ?>
                                    <div class="col dash-box shadow">
                                        <h4>₱<?= number_format($bookingTotal,"2") ?></h4>
                                        <p>Total Sales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex" id="dashboard-box">
                                    <div class="col dash-box shadow">
                                        <?php
                                                $bookingList = new Database();
                                                $bookingListSql = "SELECT COUNT(payment_id) AS 'booking_list' FROM `lessor_payment` WHERE `lessor_id`=:LESSOR_ID;";
                                                $bookingListStmt = $bookingList->getConn()->prepare($bookingListSql);
                                                $bookingListStmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"]);
                                                $bookingListStmt->execute();
                                                $bookingListRow = $bookingListStmt->fetch();
                                                
                                            ?>
                                        <h4><?= $bookingListRow["booking_list"] ?></h4>
                                        <p>Bookings</p>
                                    </div>
                                    <div class="col dash-box shadow">
                                        <?php
                                            $pendingBike = new Database();
                                            $pendingBikeSql = "SELECT COUNT(status) AS 'pending_list' FROM `lessor_bicycle` WHERE `lessor_id`=:LESSOR_ID && `status`='pending'";
                                            $pendingBikeStmt = $pendingBike->getConn()->prepare($pendingBikeSql);
                                            $pendingBikeStmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"]);
                                            $pendingBikeStmt->execute();
                                            $pendingBikeRow = $pendingBikeStmt->fetch();
                                        ?>
                                        <h4><?= $pendingBikeRow["pending_list"] ?></h4>
                                        <p>Pending Bicycle</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once "footer.php";
?>