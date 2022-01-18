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
                redirectTo("admin.php?admin_error=password does not match");
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
                                            <a href="admin_lessors.php"><i class="fas fa-user"></i> Lessors</a>
                                        </li>
                                        <li>
                                            <a href="admin.php" class="active"><i class="ti-user"></i> Admin</a>
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
                        <button id="btn2" class="btn btn-light fs-13" data-bs-toggle="modal" data-bs-target="#addAdmin">
                            <i class="ti-plus"></i> New Admin</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="ti-plus"></i> Add New Admin
                                    </h5>
                                    <button type="button" id="closeModal2" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if(isset($_GET["admin_error"])){
                                ?>
                                    <script>
                                    $(function() {
                                        var mymodal = new bootstrap.Modal(document.getElementById(
                                            "addAdmin"), {})
                                        mymodal.show()
                                    });
                                    </script>
                                    <?php
                                        echo "<p class=\"text-danger text-center fs-13 border border-danger rounded p-1\">" . $_GET["admin_error"] . "</p>";

                                    }
                                ?>
                                    <form class="fs-13" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                        enctype="multipart/form-data" method="POST">
                                        <div class="row align-items-center">
                                            <div class="col-md-3 mt-1">
                                                <label for="admin_username">Username: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="text" name="admin_username">
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label for="admin_password">Password: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="password" name="admin_password">
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label for="admin_passwordConfirm">Password Confirm: </label>
                                            </div>
                                            <div class="col-md-9 mt-1">
                                                <input class="form-control" type="password"
                                                    name="admin_passwordConfirm">
                                            </div>
                                        </div>
                                        <div class="modal-footer mt-2">
                                            <input id="btn_admin" class="btn btn-success fs-13" type="submit"
                                                name="adminBtn" value="Create new admin">
                                            <button type="button" class="btn btn-secondary fs-13"
                                                data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="p-2" id="table_id">
                    <div id="user_admin">
                        <table id="tableAdmin" class="table shadow overflow-hidden table-responsive mt-2 fs-13 rounded">
                            <caption>List of Admin</caption>
                            <thead class="bg-light">
                                <th>admin_id</th>
                                <th>admin_username</th>
                                <th>Last logged in</th>
                            </thead>
                            <tbody class="bg-white">
                                <?php 
                                            $myadmin = new Database();
                                            $query = "SELECT * FROM `tbladmin` ORDER BY `admin_id` DESC";
                                            $stmt = $myadmin->getConn()->prepare($query);
                                            $stmt->execute();
                                            while($row = $stmt->fetch()){
                                                echo "<tr>";
                                                echo "<td>" .$row["admin_id"] . "</td>";
                                                echo "<td>" .$row["admin_username"] . "</td>";
                                                echo "<td>" .$row["logged_in"] . "</td>";
                                                echo "</tr>";
                                            }
                                            $stmt->closeCursor();
                                            
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