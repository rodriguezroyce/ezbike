<?php
   require_once "Database.php";
   require_once "Payment.php";
   require_once "../View/functions.php";

   $user_id = $_REQUEST["user_id"];
   $lessor_id = $_REQUEST["lessor_id"];
   $ratings = $_REQUEST["ratings"];
   $comment = $_REQUEST["comments"];
   $token = $_REQUEST["token"];
   $date = new Payment();
   $myDate = $date->getDate();

   $db = new Database();
   $sql = "UPDATE `tblfeedback` SET `Score`=:SCORE , `Comment`=:COMMENT, `Date_Reviewed`=:DATE_REVIEWED, `status`='ON' WHERE `lessor_id`=:LESSOR_ID && `User_id`=:USER_ID && `Token`=:TOKEN";
   $stmt = $db->getConn()->prepare($sql);


   $stmt->bindValue(':SCORE',$ratings, PDO::PARAM_INT);
   $stmt->bindValue(':COMMENT',$comment, PDO::PARAM_STR);
   $stmt->bindValue(':DATE_REVIEWED', $myDate, PDO::PARAM_STR);
   $stmt->bindValue(':LESSOR_ID', $lessor_id, PDO::PARAM_INT);
   $stmt->bindValue(':USER_ID', $user_id, PDO::PARAM_INT);
   $stmt->bindValue(':TOKEN', $token, PDO::PARAM_STR);
   $stmt->execute();
   $stmt->closeCursor();



  
?>