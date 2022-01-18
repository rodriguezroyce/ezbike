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
    require_once "admin_header.php";
?>
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
                    <a class="active" href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i>
                        Transactions</a>
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
        <div class="col-md-10 bg-light-strong">
            <div class="row">
                <?php
                        include_once "admin_navbar.php";
                    ?>
                <div class="col-md-12">
                    <table class="table table-striped fs-12 align-items-center">
                        <thead>
                            <th width="7.1%">Payment Id</th>
                            <th width="7.1%">Lessor Id</th>
                            <th width="7.1%">User Id</th>
                            <th width="7.1%">Bike Id</th>
                            <th width="7.1%">Payer Name</th>
                            <th width="7.1%">Payer Email</th>
                            <th width="7.1%">Payer Id</th>
                            <th width="7.1%">Bike Rented</th>
                            <th width="7.1%">Bike Img</th>
                            <th width="7.1%">Pick-up Date</th>
                            <th width="7.1%">Return Date</th>
                            <th width="7.1%">Duration</th>
                            <th width="7.1%">Total</th>
                            <th width="7.1%">Date</th>
                        </thead>
                        <tbody>
                            <?php
                                $db = new Database();
                                $sql = "SELECT lessor_payment.lessor_id, lessor_payment.lessor_id, lessor_payment.payment_id, lessor_payment.user_id, lessor_payment.bike_id, lessor_payment.Payer_Name, lessor_payment.Payer_Email, lessor_payment.Payer_Id, lessor_payment.bike_description, lessor_payment.bike_img, lessor_payment.pickup_date, lessor_payment.return_date, lessor_payment.days, lessor_payment.bike_rate, lessor_payment.total_amt, lessor_payment.date, tblusers.valid_id FROM `lessor_payment` INNER JOIN tblusers ON tblusers.User_id = lessor_payment.user_id;";
                                $stmt = $db->getConn()->prepare($sql);
                                $stmt->execute();
                                while($row = $stmt->fetch()){
                            ?>

                            <tr>
                                <td width="7.1%"><?= $row["payment_id"] ?></td>
                                <td width="7.1%"><?= $row["lessor_id"] ?></td>
                                <td width="7.1%"><?= $row["user_id"] ?></td>
                                <td width="7.1%"><?= $row["bike_id"] ?></td>
                                <td width="7.1%"><?= $row["Payer_Name"] ?></td>
                                <td width="7.1%"><?= $row["Payer_Email"] ?></td>
                                <td width="7.1%"><?= $row["Payer_Id"]?></td>
                                <td width="7.1%"><?= $row["bike_description"] ?></td>
                                <td width="7.1%"><img class="bicycle-imgsize img-thumbnail"
                                        src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" alt=""></td>
                                <td width="7.1%"><?= $row["pickup_date"] ?></td>
                                <td width="7.1%"><?= $row["return_date"]?></td>
                                <td width="7.1%"><?= $row["days"] ?></td>
                                <td width="7.1%"><?= $row["total_amt"] ?></td>
                                <td width="7.1%"><?= $row["date"] ?></td>

                            </tr>
                            <?php 
                                }
                                ?>

                        </tbody>
                    </table>
                </div>




            </div>



        </div>
    </main>
</div>
<script>
$(function() {
    var clickCount = 0;
    $('#dropdownMenuButton').click(function() {
        clickCount++;
        if (clickCount % 2 == 0) {
            $('.dropdown-menu').fadeOut("fast");
        } else {
            $('.dropdown-menu').fadeIn("slow");
            $('.dropdown-menu').mouseover(() => {
                $('.dropdown-menu').show("fast");

            });
        }


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
                "targets": [0],
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
    $('.dataTables_wrapper .dataTables_paginate .paginate_button').addClass("fs-12");
    $('#DataTables_Table_0_info').addClass("fs-12");
    $('button.dt-button').css("font-size", "10px");
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

});
</script>
<?php
    require_once "footer.php";
?>