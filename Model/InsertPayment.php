<?php
    session_start();
    require_once "Payment.php";

    $payment = new Payment();
    $payment->insertPayment($_REQUEST["lessor_id"],$_REQUEST["user_id"],$_REQUEST["bike_id"],$_REQUEST["bike_description"],$_REQUEST["bike_img"],$_REQUEST["pickup_date"],$_REQUEST["return_date"],$_REQUEST["days"],$_REQUEST["bike_rate"],$_REQUEST["total_amt"]);



    $sql = "INSERT INTO `lessor_payment`(`lessor_id`, `user_id`, `bike_id`,`bike_description`,`bike_img`,`pickup_date`,`return_date`,`days`,`bike_rate`,`total_amt`, `date`) VALUES (:LESSOR_ID,:USER_ID,:BIKE_ID,:BIKE_DESCRIPTION,:BIKE_IMG,:PICKUP_DATE,:RETURN_DATE,:DAYS,:BIKE_RATE,:TOTAL_AMT,:DATE)";
    $stmt = $payment->getConn()->prepare($sql);
    $stmt->bindValue(':LESSOR_ID', $payment->getLessorId(), PDO::PARAM_INT);
    $stmt->bindValue(':USER_ID', $payment->getUserId(), PDO::PARAM_INT);
    $stmt->bindValue(':BIKE_ID', $payment->getBikeId(), PDO::PARAM_INT);
    $stmt->bindValue(':BIKE_DESCRIPTION', $payment->getBikeDescription(), PDO::PARAM_STR);
    $stmt->bindValue(':BIKE_IMG', $payment->getBikeImg(), PDO::PARAM_STR);
    $stmt->bindValue(':PICKUP_DATE', $payment->getPickupDate(), PDO::PARAM_STR);
    $stmt->bindValue(':RETURN_DATE', $payment->getReturnDate(), PDO::PARAM_STR);
    $stmt->bindValue(':DAYS', $payment->getRentalDuration(), PDO::PARAM_INT);
    $stmt->bindValue(':BIKE_RATE', $payment->getRentalPrice(), PDO::PARAM_INT);
    $stmt->bindValue(':TOTAL_AMT', $payment->getTotalAmount(), PDO::PARAM_INT);
    $stmt->bindValue(':DATE', $payment->getDate(), PDO::PARAM_STR);

    $stmt->execute();

    $bike_img = $payment->getBikeImg();

    $shop_name = $_REQUEST["shop_name"];
    $shop_address = $_REQUEST["shop_address"] . ' ' . $_REQUEST["barangay"];
    $shop_location = $_REQUEST["shop_location"];

    $updateBike = new Database();
    $updateBikeSql = "UPDATE `lessor_bicycle` SET `status`='booked' WHERE `lessor_id`=:LESSOR_ID && `bike_id`=:BIKE_ID";
    $updateStmt = $updateBike->getConn()->prepare($updateBikeSql);
    $updateStmt->bindValue(':LESSOR_ID', $payment->getLessorId(), PDO::PARAM_INT);
    $updateStmt->bindValue(':BIKE_ID', $payment->getBikeId(), PDO::PARAM_INT);
    $updateStmt->execute();
    $updateStmt->closeCursor();

    // location of the shop
    /*
        Hi <firstname>,
        
        We validated that we already received your rental order.

        Store Location:
        Address Line 1 + Address Line Province City Barangay

        Order Slip: 
        Ordered By: <firstname> <lastname> 
        Order Nos = payment id nos

        Date
        Description
        Pick-up Date: 11/14/2021
        Return Date:  <b> 11/15/2015 </b>

        Upon receiving your rental bike, please make sure to bring your valid id upon claiming your rental.

    */
    // $email = $_REQUEST["lessor_email"];
    $subject = "Ezbike Payments";
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
                     <h5 style="font-size: 18px;"> <span style="font-weight: 300;"> Hi </span> <span style="">' . $_REQUEST["name"] .',</span></h5>
                    <p> We validated that we already received your rental order. Please take note that this is your official receipt from Ezbike. </p>
                    <h1 style="border-bottom: 2px solid #ddd; display: inline;"> Store Information </h1>
                    <h2 style="margin-top: 8px;"> '. $shop_name .' </h2>
                    <p style="font-size: 16px; margin: 0;"> '. $shop_address .  '  </p>
                    <p style="font-size: 16px; margin: 0;"> '. $shop_location .' </p>
                    <p> <a style="background: #5624D0; color: #fff; padding: 0.35em 1rem; border-radius: 6px;" href="http://localhost/ezbikerental/View/myRentals.php"> Locate Store  </a> </p>
                    
                </div>
                <div style="padding: 1rem;">
                    <h2> Rental Details </h2>
                </div>
                <div class="p-1">
                    <p> Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'. $_REQUEST["name"] . '</strong> </p>
                </div>
                <div class="p-1">
                    <p> Bike id: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'. $payment->getBikeId().' </strong> </p> 
                </div>
                <div class="p-1">
                    <p> Description: &nbsp;&nbsp; <strong>'. $payment->getBikeDescription() .'</strong> </p>
                </div>
                <div class="p-1">
                    <p> Pick-up Date:&nbsp;  <strong> '. $payment->getPickupDate().' </strong> </p>
                </div>
                <div class="p-1">
                    <p style="color: red;"> Return Date: &nbsp; <strong>'. $payment->getReturnDate() . '</strong> </p>
                </div>
                <div class="p-1">
                    <p> Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>₱ '.  number_format($payment->getTotalAmount(),"2") . '</strong> </p>
                </div>
                <div class="p-1">
                    <p> Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> '. $payment->getDate() .'</strong> </p> 
                </div>

                <div class="p-1">
                    <p> Upon receiving your rental bike, please make sure to bring your valid id upon claiming your rental. </p>
                </div>
            </div>
    </div>
    </body> </html>';
    $senderEmail = "FROM: ezbikeofficial@gmail.com\r\n";
    $senderEmail .="Reply-To: ". $_REQUEST["email"] ."\r\n";
    $senderEmail .="MIME-version: 1.0\r\n";
    $senderEmail .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n";

    if(mail($_REQUEST["email"],$subject,$msg,$senderEmail)){
        unset($_SESSION["shopping_cart"]);
    }



    $stmt->closeCursor();

?>