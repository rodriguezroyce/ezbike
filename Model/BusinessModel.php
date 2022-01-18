<?php
    require_once "Database.php";
    class BusinessModel extends Database{

        private $id;
        private $store_name;
        private $banner;
        private $address_line1;
        private $address_line2;

        private $region;
        private $province;
        private $city;
        private $barangay;

        private $businessAddress;
        private $zip_code;

        private $lat;
        private $lng;
        
        private $phone;

        function __construct(){
            parent::__construct();
        }
        
        function getId(){
            return $this->id;
        }
        function getStoreName(){
            return $this->store_name;
        }
        function getBanner(){
            return $this->banner;
        }
        function getAddressLine1(){
            return $this->address_line1;
        }
        function getAddressLine2(){
            return $this->address_line2;
        }
        function getRegion(){
            return $this->region;
        }
        function getProvince(){
            return $this->province;
        }
        function getCity(){
            return $this->city;
        }
        function getBarangay(){
            return $this->barangay;
        }

        function getZipCode(){
            return $this->zip_code;
        }
        function getBusinessAddress(){
            return $this->businessAddress;
        }
        function getPhone(){
            return $this->phone;
        }
        function getLat(){
            return $this->lat;
        }
        function getLng(){
            return $this->lng;
        }

        function setStoreName($store_name){
            $this->store_name = $store_name;
        }
        function setBanner($banner){
            $this->banner = $banner;
        }
        function setAddressLine1($address_line1){
            $this->address_line1 = $address_line1;
        }
        function setAddressLine2($address_line2){
            $this->address_line2 = $address_line2;
        }
        function setRegion($region){
            $this->region = $region;
        }
        function setProvince($province){
            $this->province = $province;
        }
        function setCity($city){
            $this->city = $city;
        }
        function setBarangay($barangay){
            $this->barangay = $barangay;
        }

        function setZipCode($zip_code){
            $this->zip_code = $zip_code;
        }
        function setBusinessAddress($businessAddress){
            $this->businessAddress = $businessAddress;
        }
        function setPhone($phone){
            $this->phone = $phone;
        }
        function setLat($lat){
            $this->lat = $lat;
        }
        function setLng($lng){
            $this->lng = $lng;
        }
        function setId($id){
            $this->id = $id;
        }

        function getLocationLatLng(){
            $sql = "SELECT * FROM `tblbusiness` WHERE lat IS NULL AND lng IS NULL";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        function updateLocationLatLng(){
            $sql = "UPDATE tblbusiness SET lat=:lat, lng=:lng WHERE lessor_id=:id";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':lat', $this->getLat());
            $stmt->bindValue(':lng', $this->getLng());
            $stmt->bindValue(':id', $this->getId());
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
        function updateLessorLatLng(){
            $sql = "UPDATE tblbusiness SET lat=:lat, lng=:lng WHERE lessor_id=:id";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bindValue(':lat', $this->getLat());
            $stmt->bindValue(':lng', $this->getLng());
            $stmt->bindValue(':id', $this->getId());
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }

        function getAllShops(){
            $sql = "SELECT * FROM `tblbusiness`";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        function getSpecificLocation($lessor_id){
            $sql = "SELECT * FROM `tblbusiness` WHERE `lessor_id`='$lessor_id'";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        function getShopLatLng(){
            require_once "../View/library.php";
            require_once "../View/barangay.php";
            $sql = "SELECT * FROM `tblbusiness`";
            $stmt = $this->getConn()->prepare($sql);
            $stmt->execute();
            $count = 0;          
            while($row = $stmt->fetch()){
                if($this->getDistanceFromLatLonInKm($row["lat"],$row["lng"]) <= 5){
                    $count++;
                    $row_img = $row["Banner"];
                    $lessor_id = $row["lessor_id"];
                    $row_name = $row["Name"];
                   
                    foreach($city as $key => $value){
                        if($key == $row["City"]){
                            $mycity = $value;
                        }
                    }
                    foreach($province as $key => $values){
                        if($key == $row["Province"]){
                            $myprovince = $values;
                        }
                    }
                    
                    foreach($region as $key => $value){
                        if($key == $row["Region"]){
                            $myregion = $value;
                        }
                    }
                    foreach($barangay as $key => $values){
                        if($key == $row["Barangay"]){
                            $mybarangay = $values;
                        }
                    }

                    
                 
    
                    $distance = number_format($this->getDistanceFromLatLonInKm($row["lat"], $row["lng"]),"2");
                    $address = $row["Address_Line1"] . " " . $row["Address_Line2"];
                    echo "<div class=\"client-card\"> 
                            <div class=\"client-content\">
                                <a href=\"clientPage.php?lessorid=$lessor_id\">
                                    <img class=\"merchant-photo\" src=\"../assets/img/businessImg/$row_img\" alt=\"\">
                                    <div class=\"lessorDescription text-light\">
                                    <div class=\"top\"></div>
                                        <div class=\"bottom\">
                                        <div class=\"left p-2\">
                                            <h5 class=\"ff-2 mb-0\"> $row_name </h5>
                                            <div class=\"fs-12 mt-0\">
                        ";
                                $feedbackDb = new Database();
                                $feedBacksql = "SELECT * FROM `tblfeedback` WHERE `lessor_id`='$lessor_id'";
                                $feedbackStmt = $feedbackDb->getConn()->prepare($feedBacksql);
                                $feedbackStmt->execute();
                                $score = 0;
                                $scoreTotal = 0;
                                $rowCount = $feedbackStmt->rowCount();
                                if($rowCount != 0){
                                    while($feedbackRow = $feedbackStmt->fetch()){
                                    
                                        $score+= $feedbackRow["Score"];
                                        $scoreTotal = $scoreTotal + 5;
                                    }
                                        // ratings score
                                        $totalRatings = $score / $scoreTotal;
                                        echo "<span class=\"text-light\">(".$score .")</span>";
                                        if($totalRatings > 0.80){   
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';

                                        }else if($totalRatings > 0.60){
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                        }else if($totalRatings > 0.40){
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                        }else if($totalRatings > 0.20){
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                        }else if($totalRatings > 0){
                                            echo '<i class="fas fa-star fa-fw text-yellow"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';
                                            echo '<i class="fas fa-star fa-fw text-secondary"></i>';

                                        }else{
                                            echo "no reviews";
                                        }

                                }else{
                                    echo "<span> 0 </span>";
                                    echo "<span class=\"text-light\"> No reviews</span>";

                                }
                        echo "
  
                                            </div>
                                            <div class=\"mt-1 d-flex align-items-center\">
                                                <small class=\"bg-warning text-center text-light fs-11 p-1\"> $distance km &nbsp; </small>
                                                <p class=\"mb-0 fs-16 fw-bold mx-1\"> $myprovince </p>
                                                
                                            </div>
                                            <div class=\"mt-2 mx-2 fs-14\">
                                                <p> $mybarangay , $mycity  </p>
                                            </div>
                                            
                                           
                                        </div>
                                        <div class=\"right p-1\">
                                            <img src=\"../assets/img/ezbike_icon.png\" alt=\"\" class=\"profile\">
                                        </div>
                                    </div>
    
                                    </div>
                                </a>
                            </div>
                        </div>";
                    
                }else{
                    $count == 0;
                  
                }
            }
            if($count == 0){
                $output = '<div class="d-flex flex-column align-items-center justify-content-center p-4">
                <i class="fas fa-search-location fa-4x"> </i>
                <div>
                <span class="spinner-grow mx-1" role="status"> </span>
                <span class="spinner-grow mx-1" role="status"> </span>
                <span class="spinner-grow mx-1" role="status"> </span>
                </div>
                <h4 class=""> Unfortunately, there are no bicycle store in this location yet. </h4>
                <p class="px-4"> Please check again soon, as we are rapidly scaling our service! Alternatively, try searching for another location nearby. </p>
                </div>';
                echo $output;
            }

        }

        function getDistanceFromLatLonInKm($lat2,$lon2) {
            $R = 6371; // Radius of the earth in km
            $dLat = deg2rad($lat2-$this->getLat());  // deg2rad below
            $dLon = deg2rad($lon2-$this->getLng()); 
            $a = 
                sin($dLat/2) * sin($dLat/2) +
                cos(deg2rad($this->getLat())) * cos(deg2rad($lat2)) * 
                sin($dLon/2) * sin($dLon/2)
                ; 
            $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
            $d = $R * $c; // Distance in km
            return $d;
        }

        function deg2rad($deg) {
            return $deg * (pi()/180);
        }
        


    }

?>