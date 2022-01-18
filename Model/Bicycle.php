<?php
    require_once "Database.php";

    class Bicycle extends Database{

        // basic information
        private $bike_name;
        private $bike_type;
        private $bike_brand;
        private $bike_img;
        private $bike_condition;
        private $date_uploaded;
        
        // rates
        private $bike_dayRate;

        // components
        private $bike_color;
        private $bike_frame;
        private $bike_frontSuspension;
        private $bike_rearDerailleur;
        private $bike_brakeLevers;
        private $bike_brakeset;
        private $bike_crankset;
        private $bike_cassette;
        private $bike_wheelset;

        public function __construct(){
            parent::__construct();
        }



        // getters and setteres
        function getBikeName(){
            return $this->bike_name;
        }
        function getBikeType(){
            return $this->bike_type;
        }
        function getBikeBrand(){
            return $this->bike_brand;
        }
        function getBikeImg(){
            return $this->bike_img;
        }
        function getBikeCondition(){
            return $this->bike_condition;
        }
        function getDateUploaded(){
            date_default_timezone_set('Asia/Manila');
            $this->date_uploaded = date("F j, Y, g:i a");
            return $this->date_uploaded;
        }      
    
        function setBikeName($bike_name){
            $this->bike_name = $bike_name;
        }
        function setBikeType($bike_type){
            $this->bike_type = $bike_type;
        }
        function setBikeBrand($bike_brand){
            $this->bike_brand = $bike_brand;
        }
        function setBikeImg($bike_img){
            $this->bike_img = $bike_img;
        }
        function setBikeCondition($bike_condition){
            $this->bike_condition = $bike_condition;
        }
        function insertBicycle(int $lessor_id){
            $this->statement()->bindValue(':LESSOR_ID',$lessor_id, PDO::PARAM_INT);
            $this->statement()->bindValue(':BIKE_NAME', $this->getBikeName() ,PDO::PARAM_STR);
            $this->statement()->bindValue(':BIKE_TYPE', $this->getBikeType() , PDO::PARAM_STR);
            $this->statement()->bindValue(':BIKE_BRAND',$this->getBikeBrand() , PDO::PARAM_STR);
            $this->statement()->bindValue(':BIKE_IMG',$this->getBikeImg(), PDO::PARAM_STR);
            $this->statement()->bindValue(':BIKE_CONDITION',$this->getBikeCondition(), PDO::PARAM_STR);
            $this->statement()->bindValue(':DATE_UPLOADED',$this->getDateUploaded() , PDO::PARAM_STR);
            $this->statement()->bindValue(':STATUS','pending', PDO::PARAM_STR);
        }


        function insertBicycleComponents(int $lessor_id){
            $this->statement()->bindValue(':LESSOR_ID',$lessor_id, PDO::PARAM_INT);
            $this->statement()->bindValue(':COLOR',$this->getColor(), PDO::PARAM_STR);
            $this->statement()->bindValue(':FRAME', $this->getFrame(), PDO::PARAM_STR);
            $this->statement()->bindValue(':FRONT_SUSPENSION', $this->getFrontSuspension(), PDO::PARAM_STR);
            $this->statement()->bindValue(':REAR_DERAILLEUR', $this->getRearDerailleur(), PDO::PARAM_STR);
            $this->statement()->bindValue(':BRAKE_LEVERS', $this->getBrakeLevers(), PDO::PARAM_STR);
            $this->statement()->bindValue(':BRAKE_SET', $this->getBrakeset(), PDO::PARAM_STR);
            $this->statement()->bindValue(':CRANKSET', $this->getCrankset(), PDO::PARAM_STR);
            $this->statement()->bindValue(':CASSETTE', $this->getCassette(), PDO::PARAM_STR);
            $this->statement()->bindValue(':WHEELSET', $this->getWheelset(), PDO::PARAM_STR);
        }
        function insertBicycleRate(int $lessor_id){
            $this->statement()->bindValue(':LESSOR_ID', $lessor_id, PDO::PARAM_INT);
            $this->statement()->bindValue(':BIKE_DAYRATE', $this->getDayRate(), PDO::PARAM_INT);
        }

        // rates
        function getDayRate(){
            return $this->bike_dayRate;
        }
        function setDayRate($day_rate){
            $this->bike_dayRate = $day_rate;
        }
        // components
        function getColor(){
            return $this->bike_color;
        }
        function getFrame(){
            return $this->bike_frame;
        }
        function getFrontSuspension(){
            return $this->bike_frontSuspension;
        }
        function getRearDerailleur(){
            return $this->bike_rearDerailleur;
        }
        function getBrakeLevers(){
            return $this->bike_brakeLevers;
        }
        function getBrakeset(){
            return $this->bike_brakeset;
        }
        function getCrankset(){
            return $this->bike_crankset;
        }
        function getCassette(){
            return $this->bike_cassette;
        }
        function getWheelset(){
            return $this->bike_wheelset;
        }

        // component set
        function setColor($color){
            $this->bike_color = $color;
        }
        function setFrame($frame){
            $this->bike_frame = $frame;
        }
        function setFrontSuspension($frontsuspension){
            $this->bike_frontSuspension = $frontsuspension;
        }
        function setRearDerailleur($rearDerailleur){
            $this->bike_rearDerailleur = $rearDerailleur;
        }
        function setBrakeLevers($brakelevers){
            $this->bike_brakeLevers = $brakelevers;
        }
        function setBrakeset($brakeset){
            $this->bike_brakeset = $brakeset;
        }
        function setCrankset($crankset){
            $this->bike_crankset = $crankset;
        }
        function setCassette($cassette){
            $this->bike_cassette = $cassette;
        }
        function setWheelset($wheelset){
            $this->bike_wheelset = $wheelset;
        }


    }

?>