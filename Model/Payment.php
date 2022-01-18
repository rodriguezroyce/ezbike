<?php
    require_once "Database.php";
    class Payment extends Database{

        // paypal info
        private $name;



        // user info
        private $lessor_id;
        private $user_id;
        private $bike_id;
        private $bike_description;
        private $bike_img;
        private $pickup_date;
        private $return_date;
        private $rental_price;
        private $rental_duration;
        private $total_amt;

        function __construct(){
            parent::__construct();
        }

        function insertPayment($lessor_id, $user_id, $bike_id, $bike_description, $bike_img, $pickup_date, $return_date, $days, $bike_rate, $total_amt){
            $this->lessor_id = $lessor_id;
            $this->user_id = $user_id;
            $this->bike_id = $bike_id;
            $this->bike_description = $bike_description;
            $this->bike_img = $bike_img;
            $this->pickup_date = $pickup_date;
            $this->return_date = $return_date;
            $this->rental_duration = $days;
            $this->rental_price = $bike_rate;
            $this->total_amt = $total_amt;
       
            

        }
        function getPaymentId(){
            return $this->payment_id;
        }

        function getName(){
            return $this->name;
        }

        function getLessorId(){
            return $this->lessor_id;
        }
        function getUserId(){
            return $this->user_id;
        }
        function getBikeId(){
            return $this->bike_id;
        }
        function getBikeDescription(){
            return $this->bike_description;
        }
        function getBikeImg(){
            return $this->bike_img;
        }
        function getPickupDate(){
            return $this->pickup_date;
        }
        function getReturnDate(){
            return $this->return_date;
        }
        function getRentalPrice(){
            return $this->rental_price;
        }
        function getRentalDuration(){
            return $this->rental_duration;
        }
        function getTotalAmount(){
            return $this->total_amt;
        }
        function getDate(){
            date_default_timezone_set('Asia/Manila');
            $today = date("F j, Y, g:i a");
            return $today;
        }



    }



?>