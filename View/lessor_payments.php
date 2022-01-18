<?php
    session_start();
    require_once "../Model/Database.php";
    require_once "header.php";
    $id = $_SESSION["lessor_id"];
    $db = new Database();
    $sql = "SELECT tblbusiness.lessor_id, tblbusiness.Name , tbllessor.first_name, tbllessor.last_name FROM `tblbusiness` INNER JOIN `tbllessor` ON tbllessor.lessor_id = tblbusiness.lessor_id WHERE tblbusiness.lessor_id = '$id'";
    $stmt = $db->getConn()->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
?>
<title>Payment Transaction | <?= $row["Name"] ?></title>
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
                        <h5 class="mt-1 ff-1">Payments</h5>
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
                </div>
                <div class="row">
                    <div class="col-md-12 bg-white p-2">
                        <table class="table table-stripped fs-11">
                            <thead>
                                <th width="7.6%">Payment Id</th>
                                <th width="7.6%">Lessor Id</th>
                                <th width="7.6%">User Id</th>
                                <th width="7.6%">Client Name</th>
                                <th width="7.6%">Email</th>
                                <th width="7.6%">Phone</th>
                                <th width="7.6%">Description</th>
                                <th width="7.6%">Pick-up</th>
                                <th width="7.6%">Return</th>
                                <th width="7.6%">Valid Id</th>
                                <th width="7.6%">Total</th>
                                <th width="7.6%">Date</th>
                            </thead>
                            <tbody>
                                <?php
                                            $booking = new Database();
                                            $lessor_id = $_SESSION["lessor_id"];

                                            $bookingSql = "SELECT lessor_payment.* , tblusers.valid_id, tblusers.MobileNos, tblusers.Email, tblusers.FirstName FROM `lessor_payment` INNER JOIN tblusers ON tblusers.User_id = lessor_payment.user_id WHERE `lessor_id`='$lessor_id';";
                                            $bookingStmt = $booking->getConn()->prepare($bookingSql);
                                            $bookingStmt->execute();
                                            while($bookingRow = $bookingStmt->fetch()){
                                        ?>
                                <tr>
                                    <td><?= $bookingRow["payment_id"] ?></td>
                                    <td><?= $bookingRow["lessor_id"] ?></td>
                                    <td><?= $bookingRow["user_id"] ?></td>
                                    <td><?= $bookingRow["FirstName"] ?></td>
                                    <td><?= $bookingRow["Email"] ?></td>
                                    <td><?= $bookingRow["MobileNos"] ?></td>
                                    <td><?= $bookingRow["bike_description"] ?></td>
                                    <td><?= $bookingRow["pickup_date"] ?></td>
                                    <td><?= $bookingRow["return_date"] ?></td>
                                    <td><img class="img-fluid"
                                            src="../assets/img/uploads/<?= $bookingRow["bike_img"] ?>" alt=""></td>
                                    <td>₱ <?= number_format($bookingRow["total_amt"],"2") ?></td>
                                    <td><?= $bookingRow["date"] ?></td>

                                </tr>
                                <?php
                                            }
                    
                                        ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="lessorname" value="<?= $row["first_name"] . ' ' . $row["last_name"] ?>">
    </div>
    <script>
        var name = $('#lessorname').val();
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
                'csv', 'excel', 'pdf', 'print',
                {
                    extend: 'print',
                    customize: function(win){
                        $(win.document.body)
                        .css('font-size','16px')
                        .append('<p style="text-align: right; margin: 12px 0px 0px 0px; padding-bottom: 0px;">'+name +'</p>')
                        .append('<p style="text-align: right; margin: 0;"> ____________________ </p>')
                        .append('<p style="text-align: right; margin: 0;"> Store Owner </p>')
                    }
                }
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


        $('table tr td').css("vertical-align", "middle");
        $('table tr th').css("vertical-align", "middle");
        $('#success_insert').fadeOut(6000);
        $('#failed_insert').fadeOut(6000);
        $('label').css("font-size", "14px");
        $('#requestBicycle .row .col-md-6 .row > div').css("margin-top", ".75em");
        $("#moreFeatures .row div").css("margin-top", "0.35em");
        $("#moreFeatures .row div label").css("font-weight", "bold");
        $("#moreFeatures .row .col-md-8").addClass("border border-1 p-1");
    })
    </script>
    <?php
    require_once "footer.php";
?>