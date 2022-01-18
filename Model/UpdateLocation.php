<?php
    require_once "BusinessModel.php";

    $updateTblBusiness = new BusinessModel();
    $updateTblBusiness->setId($_REQUEST["id"]);
    $updateTblBusiness->setLat($_REQUEST["lat"]);
    $updateTblBusiness->setLng($_REQUEST["lng"]);

    $status = $updateTblBusiness->updateLocationLatLng();
    if($status == true){
        echo "updated...";
    }else{
        echo "failed";
    }
    print_r($_REQUEST);
?>