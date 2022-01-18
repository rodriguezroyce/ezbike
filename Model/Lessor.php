<?php
    require_once "Database.php";
    require_once "Registration.php";
    require_once "../View/functions.php";

    class Lessor extends Database{

        private $first_name;
        private $last_name;
        private $lessor_email;
        private $lessor_password;
        private $phone;

        // password
        private $old_password;
        private $new_password;
        private $confirm_password;

        public function __construct(){
           parent::__construct();
        }

        function getFirstName(){
            return $this->first_name;
        }
        function getLastName(){
            return $this->last_name;
        }
        function getEmail(){
            return $this->lessor_email;
        }
        function getPassword(){
            return $this->lessor_password;
        }
        function getPhone(){
            return $this->phone;
        }
        function getDate(){
            $today = date("F j, Y, g:i a");
            return $today;
        }
        function getOldPassword(){
            return $this->old_password;
        }
        function getNewPassword(){
            return $this->new_password;
        }
        function getConfirmPassword(){
            return $this->confirm_password;
        }

        function setFirstName($first_name){
            $this->first_name = $first_name;
        }
        function setLastName($last_name){
            $this->last_name = $last_name;
        }
        function setEmail($email){
            $this->lessor_email = $email;
        }
        function setPassword($password){
            $this->lessor_password = $password;
        }
        function setPhone($phone){
            $this->phone = $phone;
        }
        function setOldPassword($old_password){
            $this->old_password = $old_password;
        }
        function setNewPassword($new_password){
            $this->new_password = $new_password;
        }
        function setConfirmPassword($confirm_password){
            $this->confirm_password = $confirm_password;
        }
        function isPasswordMatch($new_password, $confirm_password){
            if($new_password == $confirm_password)
                return true;
        }

        function lessorLogin($email, $password){
            $registration = new Registration();
            $db = new Database();
            $sql = "SELECT lessor_id,lessor_email,first_name,lessor_password FROM `tbllessor` WHERE `lessor_email`='$email';";
            $db->query($sql);
            $row = $db->fetchSingle();
            if($registration->password_check($password, $row["lessor_password"])){
                if($this->activeStatus($email)){
                        $_SESSION["lessor_email"] = $row["lessor_email"];
                        $_SESSION["lessor_id"] = $row["lessor_id"];
                        $_SESSION["lessor_firstname"] = $row["first_name"];
                        $_SESSION["lessor_password"] = $row["lessor_password"];
                        redirectTo("../View/lessor_dash.php");
                }else{
                    redirectTo("../View/lenderLogin.php?login_attempt=Invalid Email or Password.");
                }
            }else{
                redirectTo("../View/lenderLogin.php?login_attempt=Invalid Email or Password.");
            }
            $this->closeStmt();

        }
        function activeStatus($email){
            $db = new Database();
            $db->query("SELECT status FROM `tbllessor` WHERE `lessor_email`='$email' && `status`='ON'");
            $db->resultSet();
            if($db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            $db->closeStmt();
        }


        function insertNewLessor(string $first_name, string $last_name, string $email, int $phone){
            $Token = bin2hex(openssl_random_pseudo_bytes(40));
            $registration = new Registration();

            $randPass = generateRandomString();
            $hashPw = $registration->Password_Encryption($randPass);


            $sql = "INSERT INTO `tbllessor` (`first_name`,`last_name`,`lessor_email`,`lessor_password`,`lessor_phone`,`registered_date`,`token`,`status`) VALUES (:FIRSTNAME,:LASTNAME,:LESSOR_EMAIL,:LESSOR_PASSWORD,:LESSOR_PHONE,:REGISTERED_DATE,:TOKEN,:ACC_STATUS)";
            $this->query($sql);
            $this->statement()->bindValue(':FIRSTNAME',$first_name, PDO::PARAM_STR);
            $this->statement()->bindValue(':LASTNAME',$last_name, PDO::PARAM_STR);
            $this->statement()->bindValue(':LESSOR_EMAIL',$email, PDO::PARAM_STR);
            $this->statement()->bindValue(':LESSOR_PASSWORD',$hashPw, PDO::PARAM_STR);
            $this->statement()->bindValue(':LESSOR_PHONE',$phone, PDO::PARAM_INT);
            $this->statement()->bindValue(':REGISTERED_DATE',$this->getDate(), PDO::PARAM_STR);
            $this->statement()->bindValue(':TOKEN',$Token, PDO::PARAM_STR);
            $this->statement()->bindValue(':ACC_STATUS',"OFF", PDO::PARAM_STR);
            if($this->execute()){

                $subject = "Activate Account";
                $msg = 'Hi '.$first_name . ' Here is the link to active your lessor account http://localhost/ezbikerental/View/Activate_Lessor.php?Token='. $Token . "\n\nThis is you account information to authenticate the dashboard\n" . $email . "\nPassword: ". $randPass . "\nThis will be the login to the dashboard https://localhost/ezbikerental/View/lenderLogin.php";
                $senderEmail = "FROM: ezbikeofficial@gmail.com";

                if(mail($email,$subject,$msg,$senderEmail))
                {
                    redirectTo("../View/admin_management.php?success_insert=Successfully added new lessor!");
                }else{
                    redirectTo("../View/admin_management.php?failed_insert=Something went wrong! Please make sure you type correctly.");
                }

            }else{
                echo "error";
            }
            $this->closeStmt();
        }

    }

?>