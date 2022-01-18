<?php
    session_start();
    require_once "header.php";
    require_once "../Model/Registration.php";
    require_once "../Model/Database.php";
    require_once "functions.php";

$lenderDb = new Database();
if(isset($_GET['Token'])){
    echo $_GET['Token'];
    $tokenFromUrl = $_GET['Token'];
    $query = "UPDATE tbllessor SET `status` = 'ON' WHERE `Token`='$tokenFromUrl'";
    $lenderDb->query($query);
    if($lenderDb->execute()){
        redirectTo("lenderLogin.php?login_msg=Successfully activated your account!");
    }else{
        redirectTo("lenderLogin.php");
    }
    

}

?>