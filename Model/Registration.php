<?php
  
    class Registration{

        protected $fName;
        protected $lName;
        protected $mobileNos;
        protected $email;
        protected $mypassword;
        

        // basic information

        protected $addressLine1 = "";
        protected $addressLine2 = "";
        protected $city = "";
        protected $province = "";
        protected $zip;


     
    //hashing algorithm
        public function Password_Encryption($password){
            $Blowfish_Hash_Format = "$2y$10$";
            $Salt_Length = 22;
            $Salt = $this->Generate_Salt($Salt_Length);
            $Formatting_BlowFish_With_Salt = $Blowfish_Hash_Format . $Salt;
            $hash = crypt($password, $Formatting_BlowFish_With_Salt);
            return $hash;
        }
        public function Generate_Salt($length){
            $Unique_Random_String = md5(uniqid(mt_rand(), true));
            $Base64_String = base64_encode($Unique_Random_String);
            $Modified_Base64_String = str_replace('+','.', $Base64_String);
            $salt = substr($Modified_Base64_String,0,$length);
            return $salt;
        }
        public function password_check($Password, $Existing_Hash){
            $hash = crypt($Password, $Existing_Hash);
            if($hash === $Existing_Hash){
                return true;
            }else{
                return false;
            }
        }
        // getters and setters method
        public function getFname(){
            return $this->fname;
        }
        public function getLname(){
            return $this->lname;
        }
        public function getMobile(){
            return $this->mobileNos;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPassword(){
            return $this->mypassword;
        }

        public function setFname($fname): string{
            $this->fName = $fname;
        }
        public function setLname($lname): string{
            $this->lName = $lname;
        }
        public function setMobile($mobileNos): int{
            $this->mobileNos = $mobileNos;
        }
        public function setEmail($email): string{
            $this->email = $email;
        }
        public function setPassword($password): string{
            $this->mypassword = $password;
        }

        public function confirmPassword($password, $confirmPassword): string{
            if($password == $confirmPassword){
                return $password;
            }
        }

    }


?>