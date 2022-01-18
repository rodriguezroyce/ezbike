<?php

    require_once "../Model/Database.php";
    require_once "../Model/Registration.php";

    function validate($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }
    function redirectTo($location){
        header("Location:".$location);
        exit;
    }
    function isValidEmail($email){
        $regex = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]$/";
        if(preg_match($regex,$email)){
            return true;
        }else{
            return false;
        }
    }
    // function used to check email exists
    function checkEmailExists($email){

        $db = new Database();
        $sql = "SELECT Email FROM `tblusers` WHERE `Email`='$email';";
        $db->query($sql);
        $db->resultSet();
        if($db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $db->closeStmt();
    }
    function checkLessorEmailExists($email){
        $db = new Database();
        $sql = "SELECT lessor_email FROM `tbllessor` WHERE `lessor_email`='$email'";
        $db->query($sql);
        $db->resultSet();
        if($db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $db->closeStmt();
    }
    function checkLessorPhoneExists($phone){
        $db = new Database();
        $sql = "SELECT lessor_phone FROM `tbllessor` WHERE `lessor_phone`='$phone'";
        $db->query($sql);
        $db->resultSet();
        if($db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $db->closeStmt();
    }

    function phoneExists($phone){
        $db = new Database();
        $sql = "SELECT MobileNos FROM `tblusers` WHERE `MobileNos`='$phone'";
        $db->query($sql);
        $db->resultSet();
        if($db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $db->closeStmt();
    }


    // function used to check 
    function login_attempt($email, $password){
        $db = new Database();
        $registration = new Registration();
        $sql =  "SELECT * FROM `tblusers` WHERE `Email`='$email' && `Active`='ON'";
        $db->query($sql);
        $row = $db->fetchSingle();
        if($row){
            if($registration->password_check($password, $row['Password'])){
                $_SESSION["User_id"] = $row["User_id"];
                $_SESSION["Email"] = $row["Email"];
                $_SESSION["Password"] = $row["Password"];
                $_SESSION["FirstName"] = $row["FirstName"];
                $_SESSION["LastName"] = $row["LastName"];
                $_SESSION["MobileNos"] = $row["MobileNos"];
                return $row;
            }
        }else{
            return null;
        }
    }

    function confirmingAccountActiveStatus($email){
        $db = new Database();
        $sql = "SELECT Email FROM `tblusers` WHERE `Active`='OFF' && Email='$email';";
        $db->query($sql);
        $db->resultSet();
        if($db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        $db->closeStmt();
    }
    // generate random strings
    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString);
    }

    // bicycleFilter
    function sortBy($id, $bike_type,$status,$sortby){
        $sql = "SELECT lessor_bicycle.bike_id, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.bike_img, lessor_bicycle.bike_condition, lessor_bicycle.date_uploaded, lessor_bicycle.status, lessor_bicyclerate.bike_dayRate,lessor_bicyclecomponents.color, lessor_bicyclecomponents.frame, lessor_bicyclecomponents.front_suspension, lessor_bicyclecomponents.rear_derailleur, lessor_bicyclecomponents.brake_levers, lessor_bicyclecomponents.brake_set, lessor_bicyclecomponents.crankset, lessor_bicyclecomponents.cassette, lessor_bicyclecomponents.wheelset FROM lessor_bicyclerate INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_bicyclerate.bike_id INNER JOIN lessor_bicyclecomponents ON lessor_bicycle.bike_id = lessor_bicyclecomponents.bike_id WHERE lessor_bicycle.lessor_id = '$id' && lessor_bicycle.bike_type='$bike_type' && lessor_bicycle.status='$status' ORDER BY lessor_bicycle.bike_id $sortby";
        return $sql;
    }
    function bicycleListSql($id){
        $sql = "SELECT lessor_bicycle.bike_id, lessor_bicycle.bike_name, lessor_bicycle.bike_type, lessor_bicycle.bike_brand, lessor_bicycle.bike_img, lessor_bicycle.bike_condition, lessor_bicycle.date_uploaded, lessor_bicycle.status, lessor_bicyclerate.bike_dayRate,lessor_bicyclecomponents.color, lessor_bicyclecomponents.frame, lessor_bicyclecomponents.front_suspension, lessor_bicyclecomponents.rear_derailleur, lessor_bicyclecomponents.brake_levers, lessor_bicyclecomponents.brake_set, lessor_bicyclecomponents.crankset, lessor_bicyclecomponents.cassette, lessor_bicyclecomponents.wheelset FROM lessor_bicyclerate INNER JOIN lessor_bicycle ON lessor_bicycle.bike_id = lessor_bicyclerate.bike_id INNER JOIN lessor_bicyclecomponents ON lessor_bicycle.bike_id = lessor_bicyclecomponents.bike_id WHERE lessor_bicycle.lessor_id = '$id'";
        return $sql;
    }

?>