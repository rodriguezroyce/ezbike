<?php
    session_start();
    require_once "functions.php";
    if(!isset($_SESSION["lessor_id"])){
        redirectTo("lenderLogin.php");
    }
    $id = $_SESSION["lessor_id"];
    require_once "../Model/Database.php";
    require_once "header.php";
    require_once "../Model/Bicycle.php";
    require_once "../ViewModel/BicycleListModel.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["confirmBtn"])){
            $payment_id = $_POST["payment_id"];
            $bike_id = $_POST["bike_id"];
            $updateBookings = new Database();
            $updateSql = "UPDATE `lessor_bicycle` SET `status`='in-used' WHERE `bike_id`='$bike_id'";
            $updateStmt = $updateBookings->getConn()->prepare($updateSql);
            $updateStmt->execute();
            $updateStmt->closeCursor();
            
        }
        if(isset($_POST["cancelBookingBtn"])){
            $payment_id = $_POST["payment_id"];
            $deletePayment = new Database();
            $deleteSql = "DELETE FROM `lessor_payment` WHERE `payment_id`='$payment_id'";
            $deleteStmt = $deletePayment->getConn()->prepare($deleteSql);
            $deleteStmt->execute();
            $deleteStmt->closeCursor();
        }
        if(isset($_POST["returnBtn"])){
            $payment_id = $_POST["payment_id"];
            $bike_id = $_POST["bike_id"];
            $updateBike = new Database();
            $updateBikeSql =  "UPDATE `lessor_bicycle` SET `status`='active' WHERE `bike_id`='$bike_id'";
            $returnStmt = $updateBike->getConn()->prepare($updateBikeSql);
            $returnStmt->execute();
            $returnStmt->closeCursor();
        }
        if(isset($_POST["notification"])){
            $email = $_POST["email"];
            $return_date = $_POST["return_date"];
            $subject = "Returning Bikes | Ezbike";
            $msg = '<html>
            <head>
                <style>
                    .container{
                        max-width: 768px;
                        margin: auto;
                    }
                    .row{
                        width: auto;
                    }
                    .p-1{
                        padding: 0.35em 1rem;
                    }
                    .text-center{
                        text-align: center;
                    }
                    .fs-18{
                        font-size: 18px;
                    }
                    h1,h2,h3,h4,h5,h6{
                        margin: 0;
                    }
                    h1,h2,h3,h4,h5,h6,p{
                        line-height: 1.75em;
                        color: #000000;
                    }
                    p{
                        font-size: 15px;
                        margin: 0;
                    }
                </style>
            </head>
            <body>';
            $msg .= '
            <div class="container" style="border: 4px solid #414698; padding: 0;">
                    <div class="row" style="padding: 1rem;">
                        <div style="text-align: center;">
                            <img src="https://ezbikeofficial.com/assets/img/ezbike.png" style="width: 95px; height: 95px;">
                        </div>
                        <div style="border: 3px solid #f3f4f6; padding: 1rem;">
                            <p> Hi. '.$email. ' <br> We would like to remind you that your bike return was due on '.$return_date.'  </p>
                            <br>
                            <p> to avoid inconvenience, please return the bike on the said date. </p>
                        </div>


                    </div>
            </div>
            </body> </html>';
            $senderEmail = "FROM: ezbikeofficial@gmail.com\r\n";
            $senderEmail .="Reply-To: ". $email ."\r\n";
            $senderEmail .="MIME-version: 1.0\r\n";
            $senderEmail .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n";
            
            if(mail($email,$subject,$msg,$senderEmail)){
                header("bookings.php?success_insert=Successfully returned bicycle in shop.");
            }
        }
    }

?>
<title>Ezbike Bookings</title>
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
                        <h5 class="mt-1">Bookings</h5>
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
                    <?php
                        if(isset($_GET["success_insert"])){
                        ?>
                    <div class="col-md-12 px-2">
                        <div id="success_insert" class="alert alert-success mt-2 fs-13" role="alert">
                            <i class="ti-check px-2"></i>
                            <?php echo $_GET["success_insert"] ?>
                        </div>
                    </div>
                    <?php
                            }
                        ?>
                    <?php
                            if(isset($_GET["failed_insert"])){
                        ?>
                    <div class="col-md-12 px-2">
                        <div id="failed_insert" class="alert alert-danger mt-2 fs-13" role="alert">
                            <i class="ti-close px-2"></i>
                            <?php echo $_GET["failed_insert"] ?>
                        </div>
                    </div>
                    <?php
                            }
                        ?>
                </div>
                <!-- Button trigger modal -->

                <div class="row bicycle_list">
                    <div class="col-md-12 mt-3">
                        <?php
                            $db = new Database();
                            $sql = "SELECT lessor_payment.bike_id, lessor_payment.payment_id,lessor_payment.lessor_id, lessor_payment.pickup_date, lessor_payment.return_date,lessor_payment.total_amt, lessor_payment.date, lessor_payment.bike_img, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.status, tblusers.FirstName, tblusers.LastName, tblusers.Email, tblusers.MobileNos, tblusers.valid_id FROM `lessor_payment` INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_payment.bike_id INNER JOIN tblusers ON tblusers.User_id = lessor_payment.user_id WHERE lessor_payment.lessor_id = $id && lessor_bicycle.status = 'booked' || lessor_bicycle.status = 'in-used'";
                            $stmt = $db->getConn()->prepare($sql);
                            $stmt->execute();
                        ?>
                        <table class="table table-stripped fs-11">
                            <thead>
                                <th>Bike Id</th>
                                <th>Bike Name</th>
                                <th>Bike Type</th>
                                <th>Brand</th>
                                <th>Pick Up</th>
                                <th>Return</th>
                                <th>Status</th>
                                <th>User Info</th>
                                <td>Alert</td>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php
                                while($row = $stmt->fetch()){

                           
                            ?>
                                <tr>
                                    <td><?= $row["bike_id"]?></td>
                                    <td><?= $row["bike_name"] ?></td>
                                    <td><?= $row["bike_type"] ?></td>
                                    <td><?= $row["bike_brand"] ?></td>
                                    <td><?= $row["pickup_date"] ?></td>
                                    <td class="text-danger fw-bold"><?= $row["return_date"] ?></td>
                                    <td>
                                    <?= $row["status"]?></td>
                                    <td>
                                        <!-- view user information -->
                                        <button class="btn btn-primary fs-12" data-bs-toggle="modal" data-bs-target="#viewInfo<?=$row["payment_id"]?>">
                                            view
                                        </button>
                                        <div class="modal fade" id="viewInfo<?=$row["payment_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="user_info">
                                                        <div>
                                                            <h6>First Name</h6>
                                                            <p class="fs-14">
                                                                <?= $row["FirstName"] ?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Last Name</h6>
                                                            <p class="fs-14">
                                                                <?= $row["LastName"] ?>

                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Email</h6>
                                                            <p class="fs-14">
                                                                <?= $row["Email"]?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Mobile Number</h6>
                                                            <p class="fs-14">
                                                                <?= '+'. 63 .' ' .$row["MobileNos"] ?>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h6>Valid Id</h6>
                                                            <img class="img-fluid" src="../assets/img/valid_id/<?= $row["valid_id"]?>" alt="">
                                                        </div>
                                                        <div>
                                                            <h6>Bike Img</h6>
                                                            <img class="img-fluid" src="../assets/img/uploads/<?= $row["bike_img"]?>" alt="">
                                                        </div>
                                                        <div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            if($row["status"] != "booked"){
                                        ?>
                                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                                                <input type="hidden" name="email" value="<?=$row["Email"]?>">
                                                <input type="hidden" name="return_date" value="<?=$row["return_date"]?>">
                                                <button type="submit" name="notification" class="btn">
                                                    <i class="fas fa-bell"></i> 
                                                </button>
                                            </form>
                                        <?php
                                            }
                                            
                                        ?>

                                    </td>
                                    <td>
                                        <?php
                                            if($row["status"] == "booked"){

                                       
                                        ?>
                                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#confirmBooking<?=$row["payment_id"]?>">
                                            <i class="fas fa-check text-success"></i>
                                        </button>
                                        <!-- confirm booking -->
                                        <div class="modal fade" id="confirmBooking<?=$row["payment_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Booking</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body fs-16 text-center">
                                                <i class="fas fa-info-circle"></i> By clicking confirm booking, all information regarding the rent will be saved.
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                        <input type="hidden" name="payment_id" value="<?= $row["payment_id"]?>">
                                                        <input type="hidden" name="bike_id" value="<?= $row["bike_id"]?>">
                                                        <button type="submit" name="confirmBtn" class="btn btn-success">Confirm booking</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- cancel booking -->
                                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cancelBooking">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                        <div class="modal fade" id="cancelBooking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cancel Booking</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center fs-16">
                                                    <i class="fas fa-info-circle"></i> By clicking Cancel Booking, all information about this booking will be lost.
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">

                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <input type="hidden" name="payment_id" value="<?= $row["payment_id"]?>">
                                                        <button type="submit" name="cancelBookingBtn" class="btn btn-danger">Cancel Booking</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }else{
                                            
                                        ?>
                                            <button class="btn" data-bs-toggle="modal" data-bs-target="#returned<?=$row["payment_id"]?>">
                                                <i class="fas fa-pen text-success"></i>
                                            </button>
                                            <div class="modal fade" id="returned<?=$row["payment_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Returning Bikes</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center fs-16">
                                                    <i class="fas fa-info-circle"></i> By updating bikes. the bicycle will be available for listing to the other users.
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">

                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <input type="hidden" name="payment_id" value="<?= $row["payment_id"]?>">
                                                        <input type="hidden" name="bike_id" value="<?= $row["bike_id"]?>">
                                                        <button type="submit" name="returnBtn" class="btn btn-success">Update Bike</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>
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
        </div>
    </div>
    <script>
    function readURL(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function(event) {
                $('#bike_preview').html('<img src="' + event.target.result + '" width="200" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
    $(function(e) {


        $("#bike_img").change(function() {
            readURL(this);
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


        $('table tr td').css("vertical-align", "middle");
        $('table tr th').css("vertical-align", "middle");
        $('#success_insert').fadeOut(6000);
        $('#failed_insert').fadeOut(6000);
        $('label').css("font-size", "14px");
        $('#requestBicycle .row .col-md-6 .row > div').css("margin-top", ".75em");
        $("#moreFeatures .row div").css("margin-top", "0.35em");
        $("#moreFeatures .row div label").css("font-weight", "bold");
        $("#moreFeatures .row .col-md-8").addClass("border border-1 p-1");

        let bike_name = $('#bike_name').val();
        let bike_brand = $('#bike_brand').val();
        let bike_type = $('#bike_type').val();
        let bike_condition = $('#bike_condition').val();
        let bike_rate = $('#bike_rate').val();
        let submit = $('#submit');


    });
    </script>
    <?php
    require "footer.php";
?>