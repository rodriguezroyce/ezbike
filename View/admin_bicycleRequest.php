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
        if(isset($_POST["updateBtn"])){
            $bike_id = validate($_POST["bike_id"]);
            $db = new Database();
            $sql = "UPDATE `lessor_bicycle` SET `status`='active' WHERE `bike_id`='$bike_id'";
            $stmt = $db->getConn()->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
        }
        if(isset($_POST["deleteBtn"])){
            $bike_id = validate($_POST["bike_id"]);
            $db = new Database();
            $sql = "UPDATE `lessor_bicycle` SET `status`='rejected' WHERE `bike_id`='$bike_id'";
            $stmt = $db->getConn()->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();
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
                    <a class="active" href="admin_bicycleRequest.php"><i class="fas fa-bicycle"></i> Bicycle Request</a>
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
                <div class="col-md-12">
                    <table class="table table-striped fs-12 align-items-center">
                        <thead class="table-light">
                            <th width="8.33%">lessor_id</th>
                            <th width="3.33%">bike_id</th>
                            <th width="8.33%">bike_name</th>
                            <th width="8.33%">bike_type</th>
                            <th width="8.33%">bike_brand</th>
                            <th width="13.33%">bike_img</th>
                            <th width="8.33%">date_uploaded</th>
                            <th width="8.33%">day Rate</th>
                            <th width="8.33%">status</th>
                            <th width="8.33%">action</th>
                        </thead>
                        <tbody>
                            <?php
                                    $database = new Database();
                                    $sql = "SELECT lessor_bicycle.lessor_id, lessor_bicycle.bike_id, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.bike_img, lessor_bicycle.bike_condition, lessor_bicycle.date_uploaded, lessor_bicycle.status, lessor_bicyclerate.bike_dayRate, lessor_bicyclecomponents.color, lessor_bicyclecomponents.frame, lessor_bicyclecomponents.front_suspension, lessor_bicyclecomponents.rear_derailleur, lessor_bicyclecomponents.brake_levers, lessor_bicyclecomponents.brake_set, lessor_bicyclecomponents.crankset, lessor_bicyclecomponents.cassette, lessor_bicyclecomponents.wheelset FROM lessor_bicyclerate INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_bicyclerate.bike_id INNER JOIN lessor_bicyclecomponents ON lessor_bicycle.bike_id = lessor_bicyclecomponents.bike_id WHERE lessor_bicycle.status= 'pending'";
                                                                    
                                    $stmt = $database->getConn()->prepare($sql);
                                    $stmt->execute();
                                    $count = 0;
                                    while($row = $stmt->fetch() ){  
                                    $count++;                               
                                ?>
                            <tr class="navbar-background border border-2" style="width: 100%;">
                                <td width="8.33%"><?php echo $row["lessor_id"]; ?></td>
                                <td width="3.33%"><?php echo $row["bike_id"]; ?></td>
                                <td class="fw-bold" width="8.33%"><?php echo $row["bike_name"]; ?></td>
                                <td width="8.33%;"><?php echo $row["bike_type"]; ?></td>
                                <td width="8.33%"><?php echo $row["bike_brand"]; ?></td>
                                <td width="13.33%"><img class="bicycle-imgsize img-thumbnail"
                                        src="../assets/img/uploads/<?php echo $row["bike_img"] ?>" alt=""></td>
                                <td width="8.33%"><?php echo $row["date_uploaded"]; ?></td>
                                <td width="8.33%">
                                    <?php echo '₱' . number_format($row["bike_dayRate"],2) ?>
                                </td>
                                <?php
                                        if($row["status"] == "pending"){
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-warning text-dark d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>
                                <?php
                                        }else{
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-success text-light d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>

                                <?php
                                        }
                                    ?>
                                <td width="8.33%">
                                    <button type="button" class="btn btn-success fs-12 p-1" data-bs-toggle="modal"
                                        data-bs-target="#updateRequest<?php echo $row["bike_id"] ?>"
                                        title="update request">
                                        <i class="ti-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger fs-12 p-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteRequest<?php echo $row["bike_id"] ?>"
                                        title="delete request">
                                        <i class="ti-trash"></i>
                                    </button>
                                    <!-- update -->
                                    <div class="modal fade" id="updateRequest<?php echo $row["bike_id"] ?>"
                                        tabindex="-1" aria-labelledby="updateRequestLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-secondary text-light">
                                                    <h6>Confirm</h6>
                                                    <button type="button" class="btn-close text-light   "
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-1 pb-1 fs-16">
                                                    <div class="mt-2 ff-6">
                                                        <div class="modal-flex">
                                                            <div class="l-col-2 text-center">
                                                                <i class="ti-info-alt text-success fs-22"></i>
                                                            </div>
                                                            <div class="l-col-10">
                                                                <p>Are you sure you want to update lessor request?</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <form
                                                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                                method="post">
                                                                <button type="button" class="btn btn-secondary fs-14"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <input type="hidden" name="bike_id"
                                                                    value="<?php echo $row["bike_id"]; ?>">
                                                                <input type="submit" name="updateBtn"
                                                                    class="btn btn-success fs-14" value="Update">
                                                            </form>

                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete -->
                                    <div class="modal fade" id="deleteRequest<?php echo $row["bike_id"]?>" tabindex="-1"
                                        aria-labelledby="deleteRequestLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-secondary text-light">
                                                    <h6>Delete</h6>
                                                    <button type="button" class="btn-close text-light"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-1 pb-1 fs-16">
                                                    <div class="mt-2 ff-6">
                                                        <div class="modal-flex">
                                                            <div class="l-col-2 text-center">
                                                                <i class="ti-trash text-danger fs-22"></i>
                                                            </div>
                                                            <div class="l-col-10">
                                                                <p>Are you sure you want to delete lesor request?</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <form
                                                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                                method="post">
                                                                <button type="button" class="btn btn-secondary fs-14"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <input type="hidden" name="bike_id"
                                                                    value="<?php echo $row["bike_id"]; ?>">
                                                                <input type="submit" name="deleteBtn"
                                                                    class="btn btn-danger fs-14" value="Delete">
                                                            </form>

                                                        </div>

                                                    </div>


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