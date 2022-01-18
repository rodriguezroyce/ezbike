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
                    <a href="admin_bicycleRequest.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a>

                </li>
                <li><a href="revenue.php"><i class="fas fa-money-check-alt"></i> Revenue</a></li>
                <li>
                <li>
                    <!-- <a href="admin_transactions.php"><i class="fas fa-money-bill-wave-alt"></i> Transactions</a> -->
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">

                                <a class="text-secondary fw-light active" href="admin_transactions.php"
                                    class="collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                    aria-expanded="false" aria-controls="flush-collapseOne"><i
                                        class="fas fa-users"></i>&nbsp;Feedback</a>

                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0">
                                    <ul class="px-1">
                                        <li>
                                            <a href="admin_reviews.php"> <i class="fas fa-star"></i> Reviews</a>
                                        </li>
                                        <li>
                                            <a href="admin_reports.php" class="active"><i class="fas fa-flag"></i>
                                                Reports</a>
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
                            <th>id</th>
                            <th>lessor_id</th>
                            <th>user_id</th>
                            <th>Report</th>
                            <th>Comments</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            <?php
                                    $db = new Database();
                                    $sql = "SELECT * FROM `tblreport`";
                                    $stmt = $db->getConn()->prepare($sql);
                                    $stmt->execute();
                                    while($row = $stmt->fetch()){
                         
                                ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["lessor_id"] ?></td>
                                <td><?= $row["User_id"]?></td>
                                <td><?= $row["CategoryReport"] ?></td>
                                <td><?= $row["Comment"] ?></td>
                                <td><?= $row["Date"] ?></td>
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