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
                    <a class="active" href="admin_bicycleList.php"><i class="fas fa-bicycle"></i> Bicycle List</a>
                </li>
                <li>
                    <a href="admin_bicycleRequest.php"><i class="fas fa-bicycle"></i> Bicycle Request</a>
                </li>
                <li>
                    <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a>
                </li>
                <li><a href="revenue.php"><i class="fas fa-money-check-alt"></i> Revenue</a></li>
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
        <div class="col-md-10 fs-12 bg-light-strong overflow-hidden">
            <div class="row">
                <?php
                        include_once "admin_navbar.php";
                    ?>
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
                            <th width="8.33%">day Rate</th>
                            <th width="8.33%">status</th>
                            <th width="8.33%">others</th>
                        </thead>
                        <tbody>
                            <?php
                                    $database = new Database();
                                    $sql = "SELECT lessor_bicycle.bike_id, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.bike_img, lessor_bicycle.bike_condition, lessor_bicycle.date_uploaded, lessor_bicycle.status, lessor_bicyclerate.bike_dayRate,lessor_bicyclecomponents.color, lessor_bicyclecomponents.frame, lessor_bicyclecomponents.front_suspension, lessor_bicyclecomponents.rear_derailleur, lessor_bicyclecomponents.brake_levers, lessor_bicyclecomponents.brake_set, lessor_bicyclecomponents.crankset, lessor_bicyclecomponents.cassette, lessor_bicyclecomponents.wheelset FROM lessor_bicyclerate INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_bicyclerate.bike_id INNER JOIN lessor_bicyclecomponents ON lessor_bicycle.bike_id = lessor_bicyclecomponents.bike_id";
                                                                    
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
                                        if($row["status"] == "pending"){
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-warning text-dark d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>
                                <?php
                                        }else if($row["status"] == "booked"){
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-primary text-light d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>
                                <?php
                                        }else if($row["status"] == "in-used"){
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-dark text-light d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>

                                <?php
                                        }else if($row["status"] == "active"){
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-success text-light d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>
                                <?php
                                        
                                        }else if($row["status"] == "rejected"){
                                    ?>
                                <td width="8.33%">
                                    <?php echo "<span class=\"bg-danger text-light d-block text-center rounded p-2\"> " . $row["status"] . "</span>" ?>
                                </td>
                                <?php
                                        }
                                    ?>
                                <td width="8.33%">
                                    <button type="button" class="btn btn-secondary fs-12 p-2" data-bs-toggle="modal"
                                        data-bs-target="#modalhere<?php echo $count; ?>">
                                        view
                                    </button>
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
});
</script>
<?php
    require_once "footer.php";
?>