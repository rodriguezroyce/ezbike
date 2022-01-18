<?php
    $bicycle = new Bicycle();
    $bicycleComponents = new Bicycle();
    $bicycleRate = new Bicycle();

    if(isset($_SERVER["REQUEST_METHOD"]) == "POST"){
        if(isset($_POST["submit"])){
            $error_msg = "";
                // basic information
                $bicycle->setBikeName(validate($_POST["bike_name"]));
                $bicycle->setBikeType(validate($_POST["bike_type"]));
                $bicycle->setBikeBrand(validate($_POST["bike_brand"]));
                $bicycle->setBikeCondition(validate($_POST["bike_condition"]));
                $bicycle->setBikeImg($_FILES["bike_img"]["name"]);

                // rates
                $bicycleRate->setDayRate(validate($_POST["bike_dayRate"]));    
                //components
                $bicycleComponents->setColor(validate($_POST["color"]));
                $bicycleComponents->setFrame(validate($_POST["frame"]));
                $bicycleComponents->setFrontSuspension(validate($_POST["front_suspension"]));
                $bicycleComponents->setRearDerailleur(validate($_POST["rear_derailleur"]));
                $bicycleComponents->setBrakeLevers(validate($_POST["brake_levers"]));
                $bicycleComponents->setBrakeset(validate($_POST["brakeset"]));
                $bicycleComponents->setCrankset(validate($_POST["crankset"]));
                $bicycleComponents->setCassette(validate($_POST["cassette"]));
                $bicycleComponents->setWheelset(validate($_POST["wheelset"]));

            

                // image info
                $tmpName = $_FILES["bike_img"]["tmp_name"];
                $fileName = $_FILES["bike_img"]["name"];
                $filesize = $_FILES["bike_img"]["size"];
                $fileType = $_FILES["bike_img"]["type"];

                $isValidFile = false;

                // image allowed types
                $allowedTypes = ["image/jpeg","image/png","image/jpg","image/gif","image/tiff","image/psd"];
                if($filesize > 26214400){
                    redirectTo("lessor_bicycle.php?failed_insert=Image exceeds the following size. Make sure you uploaded image that is below 26kb");
                }else if(empty($bicycle->getBikeName())){
                    echo "<script type=\"text/javascript\"> $(function(){
                        $('#add_bicycle').modal('show');
                        $('#bike_name_validation').html('bike name should not be empty'); 
                    }); </script>";
    
                }elseif(empty($bicycle->getBikeBrand())){
                    echo "<script type=\"text/javascript\"> $(function(){
                        $('#add_bicycle').modal('show');
                        $('#bike_brand_validation').html('brand name should not be empty'); 
                    }); </script>";

                }elseif(empty($bicycle->getBikeCondition())){
                    echo "<script type=\"text/javascript\"> $(function(){
                        $('#add_bicycle').modal('show');
                        $('#bike_condition_validation').html('bike condition should not be empty'); 
                    }); </script>";
                }elseif(empty($bicycle->getBikeImg())){
                    echo "<script type=\"text/javascript\"> $(function(){
                        $('#add_bicycle').modal('show');
                        $('#bike_img_validation').html('bicycle image should not be empty'); 
                    }); </script>";
                }elseif(empty($bicycleRate->getDayRate())){
                    echo "<script type=\"text/javascript\"> $(function(){
                        $('#add_bicycle').modal('show');
                        $('#bike_img_validation').html('bicycle rate should not be empty'); 
                    }); </script>";
                }elseif(empty($bicycleComponents->getColor()) || empty($bicycleComponents->getFrame()) || empty($bicycleComponents->getFrontSuspension()) || empty($bicycleComponents->getRearDerailleur()) || empty($bicycleComponents->getBrakeLevers()) || empty($bicycleComponents->getBrakeset()) || empty($bicycleComponents->getCrankset()) || empty($bicycleComponents->getCassette()) || empty($bicycleComponents->getWheelset())){
                    echo "<script type=\"text/javascript\"> $(function(){
                        $('#add_bicycle').modal('show');
                        $('#components_validation').html('bicycle components should not be leave blank.'); 
                    }); </script>";
                }else{
                    foreach($allowedTypes as $fileTypes){
                        if($fileType == $fileTypes){
                            $isValidFile = true;
                        }
                    }
                    if($isValidFile){
                        $sql = "INSERT INTO `lessor_bicycle`(`lessor_id`,`bike_name`, `bike_type`, `bike_brand`,`bike_img`,`bike_condition`, `date_uploaded`, `status`) VALUES (:LESSOR_ID,:BIKE_NAME,:BIKE_TYPE,:BIKE_BRAND,:BIKE_IMG,:BIKE_CONDITION,:DATE_UPLOADED,:STATUS)";

                        $sql1 = "INSERT INTO `lessor_bicyclecomponents` (`lessor_id`,`color`,`frame`,`front_suspension`,`rear_derailleur`,`brake_levers`,`brake_set`,`crankset`,`cassette`,`wheelset`) VALUES (:LESSOR_ID,:COLOR,:FRAME,:FRONT_SUSPENSION,:REAR_DERAILLEUR,:BRAKE_LEVERS,:BRAKE_SET,:CRANKSET,:CASSETTE,:WHEELSET)"; 
            
                        $sql2 = "INSERT INTO `lessor_bicyclerate` (`lessor_id`,`bike_dayRate`) VALUES (:LESSOR_ID,:BIKE_DAYRATE)";
            
                        $bicycle->query($sql);
                        $bicycle->insertBicycle($_SESSION["lessor_id"]);
                        $bicycleComponents->query($sql1);
                        $bicycleComponents->insertBicycleComponents($_SESSION["lessor_id"]);
                        $bicycleRate->query($sql2);
                        $bicycleRate->insertBicycleRate($_SESSION["lessor_id"]);
            
                        if($bicycle->execute() && $bicycleComponents->execute() && $bicycleRate->execute()){
                            $dir = "../assets/img/uploads";
                            if(!file_exists($dir)){
                                mkdir($dir);
                            }else{
                                move_uploaded_file($tmpName, $dir."/".$bicycle->getBikeImg());
                                redirectTo("lessor_bicycle.php?success_insert=Your request has been made and is now currently reviewed by the admin.");
                            }
                        }
                        $bicycle->closeStmt();
                        $bicycleComponents->closeStmt();
                        $bicycleRate->closeStmt();
                    
                    }else{
                        redirectTo("lessor_bicycle.php?failed_insert=Make sure you insert a valid image format.");
                    }
                }
                echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>';
            
        }
    }
?>