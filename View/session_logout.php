<?php
    include_once "functions.php";
    include_once "../Model/Database.php";
    include_once "../Model/Bicycle.php";
    session_start();
    $db = new Database();
    $bicycle = new Bicycle();
    $last_login = $bicycle->getDateUploaded();
    $admin_id = $_SESSION["admin_id"];
    $db->query("UPDATE `tbladmin` SET `logged_in`='$last_login' WHERE `admin_id`='$admin_id'");
    if($db->execute()){
        unset($_SESSION["admin_id"]);
        unset($_SESSION["admin_username"]);
        unset($_SESSION["admin_password"]);
        redirectTo("adminLogin.php");
        $db->closeStmt();
    }
    session_destroy();

?>