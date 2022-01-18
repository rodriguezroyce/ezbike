<?php
    session_start();
    require_once "functions.php";
    require_once "../Model/Database.php";
    require_once "../Model/AdminLogin.php";
    require_once "../Model/Lessor.php";
    require_once "library.php";
    if(!isset($_SESSION["admin_username"])){
        redirectTo("adminLogin.php?validation_error=SESSION TIMEOUT!");
    }
    $error_msg = null;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["btnAddLessor"])){

            $lessor = new Lessor();
            $lessor->setFirstName(validate($_POST["first_name"]));
            $lessor->setLastName(validate($_POST["last_name"]));
            $lessor->setEmail(validate($_POST["lessor_email"]));
            $lessor->setPhone(validate($_POST["lessor_phone"]));



            try{

                if(!filter_var($lessor->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    throw new Exception($validation_errors[0]);
                }else if(strlen($lessor->getPhone()) !=10){
                    throw new Exception($validation_errors[1]);
                }else if(checkLessorEmailExists($lessor->getEmail())){
                    throw new Exception($validation_errors[2]);
                }else if(checkLessorPhoneExists($lessor->getPhone())){
                    throw new Exception($validation_errors[3]);
                }else{
                    $lessor->insertNewLessor($lessor->getFirstName(),$lessor->getLastName(), $lessor->getEmail(), $lessor->getPhone());
                    
                }
            }catch(Exception $e){
                $error_msg = $e->getMessage();
            }
        }
        if(isset($_POST["adminBtn"])){
            $admin = new AdminLogin();
            $admin->setUsername(validate($_POST["admin_username"]));
            $admin->setPassword(validate($_POST["admin_password"]));
            $admin->setPasswordConfirm(validate($_POST["admin_passwordConfirm"]));
            if(empty($admin->getPassword()) || empty($admin->getPasswordConfirm()) || empty($admin->getUsername())){
                redirectTo("admin_management.php?admin_error=Please fill out all the remaining fields.");
            }else if($admin->passwordMatch()){
                $admin->insertAdmin();
            }else{
                redirectTo("admin_management.php?admin_error=password does not match");
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&family=Padauk&family=Palanquin&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">



    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/admin.css">
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" />




    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    

    <title>Dashboard | Ezbike </title>
</head>

<body>
<div class="container-fluid">
    <main class="row">
        <div class="col-md-2 bg-white shadow rounded">
            <div class="text-center mt-2">
                <a href="adminDashboard.php">
                    <img class="logo" src="../assets/img/ezbike.png" alt="">
                </a>

            </div>
            <ul class="navleft-menu">
                <li>
                    <a href="adminDashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="admin_bicycleList.php"><i class="fas fa-bicycle"></i> Bicycle List</a>
                </li>
                <li>
                    <a href="admin_bicycleRequest.php"><i class="fas fa-bicycle"></i> Bicycle Request</a>
                </li>
                <li>
                    <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i>
                        Transactions</a>
                </li>
                <li><a href="revenue.php" class="active"><i class="fas fa-money-check-alt"></i> Revenue</a></li>
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
        <div class="col-md-10 bg-light-strong">
            <div class="row">
                <?php
                        include_once "admin_navbar.php";
                    ?>
                <div class="col-md-12">
                    <h3>
                        Revenue Report
                    </h3>
                        <input type="text" id="daterange" readonly="true" value="" />
                        <button class="btn btn-success" type="button" onclick="printTable()">Print</button>
                </div>
                <div id="date_input" class="p-1">

                </div>

            </div>
        </div>
    </main>
</div>

<script src="https://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript">
    function printTable(){
        var printme = document.getElementById("table");
        var wme = window.open("","","width=900, height=700");
  
        wme.document.write("<h1 style=\"text-align: center;\"> Ezbike Revenue </h1>"+printme.outerHTML);
        wme.document.close();
        wme.focus();
        wme.print();
    }
    $(function() {
        

        $('#daterange').daterangepicker({
        opens: 'left'
        }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('MM-DD-YYYY') + ' to ' + end.format('MM-DD-YYYY'));
        console.log(convertDate(start.format('MM-DD-YYYY')));
        console.log(convertDate(end.format('MM-DD-YYYY')));
        var request_date = {};
        request_date.fromDate = convertDate(start.format('MM-DD-YYYY'));
        request_date.toDate = convertDate(end.format('MM-DD-YYYY'));

        getRevenue(request_date);
        
    });
        function getRevenue(date){
            $.ajax({
                url: '../Model/Revenue.php',
                method: "GET",
                data: date,
                success: function(res){
                    document.getElementById("date_input").innerHTML = res;
                }
            });
        }
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function convertDate(date_str) {
        temp_date = date_str.split("-");
        return months[Number(temp_date[0]) - 1] + " " + temp_date[1] + ", " + temp_date[2];
        }

    });
</script>

<?php
    require_once "footer.php";
?>