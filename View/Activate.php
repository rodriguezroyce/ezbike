<?php
session_start();
    require_once "header.php";
    require_once "../Model/Registration.php";
    require_once "../Model/Database.php";
    require_once "functions.php";

$mydb = new Database();
if(isset($_GET['token'])){
    $tokenFromUrl = $_GET['token'];
    $query = "UPDATE tblusers SET `Active` = 'ON' WHERE `Token`='$tokenFromUrl' ";
    $mydb->query($query);
    if($mydb->execute()){
        redirectTo("login.php?login_success=Successfully activated your account!");
    }else{
        redirectTo("userRegistration.php?message=Something Weng Wrong!");
    }
    

}

?>