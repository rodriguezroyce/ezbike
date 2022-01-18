<?php
    session_start();
    require_once "functions.php";
    require_once "../Model/Database.php";
    if(!isset($_SESSION["admin_username"])){
        redirectTo("adminLogin.php?validation_error=SESSION TIMEOUT!");
    }
    require_once "admin_header.php";
?>
<main class="row">
    <div class="col-md-2 border-end shadow">
        <div class="text-center mt-2">
            <a href="adminDashboard.png">
                <img class="logo" src="../assets/img/ezbike.png" alt="">
            </a>
        </div>
        <ul class="navleft-menu">
            <li>
                <a class="active" href="adminDashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li>
                <a href="admin_bicycleList.php"><i class="fas fa-bicycle"></i> Bicycle List</a>
            </li>
            <li>
                <a href="admin_bicycleRequest.php"><i class="fas fa-bicycle"></i> Bicycle Request</a>
            </li>
            <li>
                <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a>
            </li>
            <li><a href="revenue.php"><i class="fas fa-money-check-alt"></i> Revenue</a></li>
            <li>
            <li>
                <!-- <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a> -->
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">

                            <a class="text-secondary fw-light" href="admin_transactions.php" class="collapsed"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne"><i class="fas fa-users"></i>&nbsp;Feedback</a>

                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body p-0">
                                <ul class="px-1">
                                    <li>
                                        <a href="admin_reviews.php"> <i class="fas fa-star"></i> Reviews</a>
                                    </li>
                                    <li>
                                        <a href="admin_reports.php"><i class="fas fa-flag"></i> Reports</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </li>
            <li>
                <a href="admin_location.php"><i class="ti-map-alt"></i>&nbsp; Location</a>
            </li>
            <li>
                <div class="accordion accordion-flush" id="admin_lessors">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">

                            <a class="text-secondary fw-light" href="#" class="collapsed" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseOne"><i class="ti-user"></i>&nbsp;User Management</a>

                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#admin_lessors">
                            <div class="accordion-body p-0">
                                <ul class="px-1">
                                    <li>
                                        <a href="admin_users.php"> <i class="fas fa-users"></i> Users</a>
                                    </li>
                                    <li>
                                        <a href="admin_lessors.php"><i class="fas fa-user"></i> Lessors</a>
                                    </li>
                                    <li>
                                        <a href="admin.php"><i class="ti-user"></i> Admin</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>
    <div class="col-md-10 bg-light-strong overflow-hidden">
        <div class="row">
            <?php
                include_once "admin_navbar.php";
            ?>
        </div>

        <div class="container-sm overflow-hidden">
            <div id="dash-row" class="d-flex align-items-center justify-content-between fs-13 lh-sm">
                <div class="dashbox bg-white">
                    <div class="content-left">
                        <?php
                            $db = new Database();
                            $sql = "SELECT COUNT(`User_id`) as 'RowCount' FROM `tblusers`";
                            $stmt = $db->getConn()->prepare($sql);

                            $sql2 = "SELECT COUNT(`lessor_id`) AS 'LessorCount' FROM `tbllessor`";
                            $stmt2 = $db->getConn()->prepare($sql2);

                            $sql3 = "SELECT COUNT(`bike_id`) AS 'TotalBicycles' FROM `lessor_bicycle`";
                            $stmt3 = $db->getConn()->prepare($sql3);

                            $sql4 = "SELECT `total_amt` FROM `lessor_payment`";
                            $stmt4 = $db->getConn()->prepare($sql4);

                        ?>
                        <p>Total users</p>
                        <h5><?php 
                            if($stmt->execute()){
                                $row = $stmt->fetch();
                                echo $row['RowCount'];    
                            } 
                            ?>
                        </h5>
                    </div>
                    <div class="content-right">
                        <!-- <img class="img-fluid" src="../assets/img/analytics.png" alt=""> -->
                        <i class="fas fa-users fa-4x text-primary"></i>
                    </div>
                </div>
                <div class="dashbox bg-white">
                    <div class="content-left">
                        <p>Total lessors</p>
                        <h5><?php if($stmt2->execute()){
                            $row2 = $stmt2->fetch();
                            echo $row2["LessorCount"];
                        } ?></h5>
                    </div>
                    <div class="content-right">
                        <!-- <img class="img-fluid" src="../assets/img/analytics.png" alt=""> -->
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                </div>
                <div class="dashbox bg-white">
                    <div class="content-left">
                        <p>Total bicycles</p>
                        <h5><?php if($stmt3->execute()){
                            $row3 = $stmt3->fetch();
                            echo $row3["TotalBicycles"];
                        } ?></h5>
                    </div>
                    <div class="content-right">
                        <!-- <img class="img-fluid" src="../assets/img/analytics.png" alt=""> -->
                        <i class="fas fa-bicycle text-danger fa-4x"></i>
                    </div>
                </div>
                <div class="dashbox bg-white">
                    <div class="content-left">
                        <p>Total Income</p>
                        <h6>
                            <?php
                                $stmt4->execute();
                                $total = null;
                                while($row4 = $stmt4->fetch()){
                                    $total = $total + $row4["total_amt"];
                                }
                                echo "₱ " . number_format($total);
                            ?>

                        </h6>
                    </div>
                    <div class="content-right">
                        <!-- <img class="img-fluid" src="../assets/img/analytics.png" alt=""> -->
                        <i class="ti-money fa-4x text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-md-12">
                    <div id="chart_div" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
            <?php
                $storeLocation = new Database();
                $locationSql = "SELECT Region  FROM `tblbusiness`;";
                $locationStmt = $storeLocation->getConn()->prepare($locationSql);
                $locationStmt->execute();
                $locationRows = $locationStmt->fetchAll(PDO::FETCH_OBJ);
                $placeData = json_encode($locationRows, true);
            ?>
            <div id="placeData" style="display: none;"><?php echo $placeData; ?></div>
            <div>

            </div>
        </div>
    </div>
</main>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {
    'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawVisualization);


function drawVisualization() {

    var locationData = document.getElementById("placeData").innerHTML;
    var myData = JSON.parse(locationData, true);
    var region1 = 0;
    var region2 = 0;
    var region3 = 0;
    var region4a = 0;
    var region4b = 0;
    var region5 = 0;
    var region6 = 0;
    var region7 = 0;
    var region8 = 0;
    var region9 = 0;
    var region10 = 0;
    var region11 = 0;
    var region12 = 0;
    var region13 = 0;
    var ncr = 0;
    var car = 0;
    var armm = 0;
    var negrosregion = 0;
    for (var i = 0; i < myData.length; i++) {
        switch (myData[i]["Region"]) {
            case '01':
                region1++;
                break;
            case '02':
                region2++;
                break;
            case '03':
                region3++;
                break;
            case '04':
                region4a++;
                break;
            case '17':
                region4b++;
                break;
            case '05':
                region5++;
                break;
            case '06':
                region6++;
                break;
            case '07':
                region7++;
                break;
            case '08':
                region8++;
                break;
            case '09':
                region9++;
                break;
            case '10':
                region10++;
                break;
            case '11':
                region11++;
                break;
            case '12':
                region12++;
                break;
            case '13':
                ncr++;
                break;
            case '14':
                car++;
                break;
            case '15':
                armm++;
                break;
            case '16':
                region13++;
                break;
            case '17':
                region4b++;
                break;
            case '18':
                negrosregion++;
                break;
            default:
                console.log("invalid data");
                break;
        }

    }
    // get month for table
    var d = new Date();
    let month = d.getMonth() + 1;
    let year = d.getFullYear();
    let concat = month + "/" + d.getDate() + "/" + year;
    console.log(concat);

    var data = google.visualization.arrayToDataTable([
        ['Month', 'Region I', 'Region II', 'Region III', 'Region IV-A', 'Region IV-B', 'Region V', 'Region VI',
            'Region VII', 'Region VIII', 'Region IX', 'Region X', 'Region XI', 'Region XII', 'Region XIII',
            'NCR', 'CAR', 'ARMM', 'Negros Region'
        ],
        [concat, region1, region2, region3, region4a, region4b, region5, region6, region7, region8, region9,
            region10, region11, region12, region13, ncr, car, armm, negrosregion
        ],

    ]);

    var options = {
        title: 'Ezbike Stores',
        vAxis: {
            title: 'No of stores'
        },
        hAxis: {
            title: 'As of today'
        },
        seriesType: 'bars',
        series: {
            5: {
                type: 'line'
            }
        }
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
</script>


<script>
$(() => {
    if (window.matchMedia('(max-width: 765px)').matches) {

    }
});
</script>
<?php
    require_once "footer.php";
?>