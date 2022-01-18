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

                                <a class="text-secondary fw-light active" href="#" class="collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseOne"><i class="ti-user"></i>&nbsp;User Management</a>

                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#admin_lessors">
                                <div class="accordion-body p-0">
                                    <ul class="px-1">
                                        <li>
                                            <a href="admin_users.php" class="active"> <i class="fas fa-users"></i>
                                                Users</a>
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

                    </div>
                    <!-- Modal -->

                </div>
                <div class="p-2" id="table_id">
                    <div class="" id="user_lessor">
                        <table id="tableLessor"
                            class="table shadow overflow-hidden table-responsive mt-2 fs-13 rounded">
                            <caption>List of Users</caption>
                            <thead class="table-light">
                                <th>User id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Valid id</th>
                                <th>Status</th>
                            </thead>
                            <tbody class="bg-white">
                                <?php
                                        $mylessor = new Database();
                                        $lessor_query = "SELECT * FROM `tblusers`";
                                        $lessor_stmt = $mylessor->getConn()->prepare($lessor_query);
                                        $lessor_stmt->execute();
                                        while($lessor_row = $lessor_stmt->fetch()){
                                            echo "<tr>";
                                            echo "<td>" . $lessor_row["User_id"] . "</td>";
                                            echo "<td>" . $lessor_row["FirstName"] . "</td>";
                                            echo "<td>" . $lessor_row["LastName"] . "</td>";
                                            echo "<td>" . $lessor_row["Email"] . "</td>";
                                            echo "<td>" . $lessor_row["MobileNos"] . "</td>";
                                            echo "<td> <img class=\"bicycle-imgsize\" src=\"../assets/img/valid_id/".$lessor_row["valid_id"]."\" >  </td>";
                                            if($lessor_row["Active"] == "ON"){
                                                echo "<td> <p class=\"bg-success p-1 text-light mb-0\">". $lessor_row["Active"]." </p></td>"; 
                                            }else{
                                                echo "<td> <p class=\"bg-secondary p-1 text-light mb-0\">". $lessor_row["Active"]." </p></td>"; 
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