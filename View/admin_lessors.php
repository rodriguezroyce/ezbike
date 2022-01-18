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

                                <a class="text-secondary fw-light active" href="admin_transactions.php"
                                    class="collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                    aria-expanded="false" aria-controls="flush-collapseOne"><i
                                        class="ti-user"></i>&nbsp;User Management</a>

                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#admin_lessors">
                                <div class="accordion-body p-0">
                                    <ul class="px-1">
                                        <li>
                                            <a href="admin_users.php"> <i class="fas fa-users"></i> Users</a>
                                        </li>
                                        <li>
                                            <a href="admin_lessors.php" class="active"><i class="fas fa-user"></i>
                                                Lessors</a>
                                        </li>
                                        <li>
                                            <a href="admin.php"><i class="fas fa-user"></i> Admin</a>
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
                    <div class="mb-2">
                        <h4 class="p-2">User Management</h4>
                        <?php 
                                if(isset($_GET["success_insert"])){
                                    echo "<div class=\"bg-success text-light rounded shadow p-1 fs-13 mt-3\"> " . $_GET["success_insert"] . "</div>";
                                }
                                if(isset($_GET["failed_insert"])){
                                    echo "<div class=\"bg-danger text-light rounded shadow p-1 fs-13 mt-3\"> " . $_GET["failed_insert"] . "</div>";
                                }

                                if(!is_null($error_msg)){
                                ?>
                        <div id="alertMsg" class="alert alert-danger fs-13" role="alert">
                            <i class="ti-info-alt"></i>
                            <?php echo $error_msg; ?>
                        </div>
                        <?php
                                }else{
                                ?>
                        <script>
                        $(function() {
                            $('#alertMsg').hide();
                        });
                        </script>
                        <?php
                                }
                            ?>
                    </div>
                    <!-- Button trigger modal -->
                    <div id="user_buttons">
                        <button id="btn-1" type="button" class="btn btn-light fs-13" data-bs-toggle="modal"
                            data-bs-target="#addLessor">
                            <i class="ti-plus"></i> New Lessor
                        </button>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="addLessor" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="ti-plus"></i> Add New
                                        Lessor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                        <div class="row fs-13 align-items-center">
                                            <div class="col-md-3 mt-1">
                                                <label for="first_name">First Name: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="text" name="first_name"
                                                    id="first_name" required>
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label for="last_name">Last Name: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="text" name="last_name" id="last_name"
                                                    required>
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label for="lessor_email">Email: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="email" name="lessor_email" id="email"
                                                    required>
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label for="lessor_phone">Phone: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="number" name="lessor_phone"
                                                    id="lessor_phone" required>
                                            </div>
                                            <div class="modal-footer mt-2">
                                                <input class="btn btn-success fs-13" name="btnAddLessor" type="submit"
                                                    value="Add Lessor">
                                                <button type="button" class="btn btn-secondary fs-13"
                                                    data-bs-dismiss="modal" style="padding: 0.50em 4rem;">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2" id="table_id">
                    <div class="" id="user_lessor">
                        <table id="tableLessor"
                            class="table shadow overflow-hidden table-responsive mt-2 fs-13 rounded">
                            <caption>List of Lessors</caption>
                            <thead class="table-light">
                                <th>lessor_id</th>
                                <th>first_name</th>
                                <th>last_name</th>
                                <th>lessor_email</th>
                                <th>lessor_phone</th>
                                <th>status</th>
                            </thead>
                            <tbody class="bg-white">
                                <?php
                                        $mylessor = new Database();
                                        $lessor_query = "SELECT lessor_id,first_name,last_name,lessor_email,lessor_phone,status FROM `tbllessor`";
                                        $lessor_stmt = $mylessor->getConn()->prepare($lessor_query);
                                        $lessor_stmt->execute();
                                        while($lessor_row = $lessor_stmt->fetch()){
                                            echo "<tr>";
                                            echo "<td>" . $lessor_row["lessor_id"] . "</td>";
                                            echo "<td>" . $lessor_row["first_name"] . "</td>";
                                            echo "<td>" . $lessor_row["last_name"] . "</td>";
                                            echo "<td>" . $lessor_row["lessor_email"] . "</td>";
                                            echo "<td>" . $lessor_row["lessor_phone"] . "</td>";
                                            if($lessor_row["status"] == "ON"){
                                                echo "<td> <p class=\"bg-success text-light mb-0 text-center\"> ON  </p> </td>";
                                            }else{
                                                echo "<td> <p class=\"bg-danger text-light mb-0 text-center\"> OFF  </p> </td>";
                                            }
                                            echo "</tr>";
                                        }

                                    ?>
                            </tbody>
                        </table>


                    </div>
                </div>


            </div>



        </div>
    </main>
</div>
<script>
$(function() {
    var count = 0;
    var count1 = 0;
    $('#btn3').click(function() {
        count1++;
        if (count1 % 2 != 0) {
            $('#tableLessor').hide();
            $(this).html("Show Table Lessor");
        } else {
            $('#tableLessor').show();
            $(this).html("Hide Table Lessor");
        }
    });

    $('#btn4').click(function() {
        count++;
        if (count % 2 != 0) {
            $('#tableAdmin').hide();
            $(this).html('Show Table Admin');
        } else {
            $('#tableAdmin').show();
            $(this).html('Hide Table Admin');
        }
    });
    if ($(window).innerWidth() <= 765) {
        $('#table_id').removeClass("d-flex flex-row justify-content-between");
        $('#table_id').addClass("flex-col justify-content-center");
        $('#user_buttons').addClass("text-center");
    }
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