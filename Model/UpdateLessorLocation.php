<?php
    require_once "../View/functions.php";
    require_once "BusinessModel.php";
    

    $locationUpdate = new BusinessModel();
    $locationUpdate->setId($_REQUEST["id"]);
    $locationUpdate->setLat($_REQUEST["lat"]);
    $locationUpdate->setLng($_REQUEST["lng"]);

    print_r($_REQUEST);
    
    $status = $locationUpdate->updateLessorLatLng();
    if($status == true){
        echo "updated location";
    }else{
        echo "failed update location";
    }
    
    
?>