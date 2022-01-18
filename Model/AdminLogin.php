<?php
    include_once "Database.php";
    include_once "../View/functions.php";
    class AdminLogin extends Database{
        
        private $username;
        private $password;
        private $passwordConfirmation;
        private $sql;

        function construct(){
            parent::_construct();

        }
        public function getUsername(){
            return $this->username;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getPasswordConfirm(){
            return $this->passwordConfirmation;
        }
        function setUsername($username){
            $this->username = $username;
        }
        function setPassword($password){
            $this->password = $password;
        }
        function setPasswordConfirm($passwordConfirmation){
            $this->passwordConfirmation = $passwordConfirmation;
        }
        function isNotEmpty($username, $password){
            if(!empty($username) && !empty($password)){
                return true;
            }
        }
        function passwordMatch(){
            if($this->getPassword() == $this->getPasswordConfirm()){
                return true;
            }
        }
        function getDate(){
            $today = date("F j, Y, g:i a");
            return $today;
        }

        // insert
        function insertAdmin(){
            require_once "../View/functions.php";
            require_once "Registration.php";
           
            $this->sql = "INSERT INTO `tbladmin` (`admin_username`,`admin_password`,`security_code`,`date_created`) VALUES (:ADMIN_USERNAME,:ADMIN_PASSWORD,:SECURITY_CODE,:DATE_CREATED)";
            $db = new Database();
            $hashing = new Registration();
            $db->query($this->sql);
            $hashpassword = $hashing->Password_Encryption($this->getPassword());
            $db->adminValues($this->getUsername(), $hashpassword, generateRandomString(), $this->getDate());
            if($db->execute()){
                redirectTo("../View/admin.php?success_insert=Successfully added new records!");
            }
            $db->closeStmt();
        }

        // auth
        function authenticate($username, $password){
            $hash = new Registration();
            $this->sql = "SELECT * FROM `tbladmin` WHERE `admin_username`='$username'";
            $db = new Database();
            $db->query($this->sql);
            $db->execute();
            $row = $db->fetchSingle();
            if($row){
                if($hash->password_check($password, $row["admin_password"])){
                    $_SESSION["admin_id"] = $row["admin_id"];
                    $_SESSION["admin_username"] = $row["admin_username"];
                    $_SESSION["admin_password"] = $row["admin_password"];
                    redirectTo("../View/adminDashboard.php");
                }else{
                    redirectTo("../View/adminLogin.php?validation_error=The email or password you entered is not connected to an account.");
                }
            }else{
                redirectTo("../View/adminLogin.php?validation_error=The email or password you entered is not connected to an account.");
            }
        }




    }


?>