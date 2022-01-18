<?php
    require_once "../Model/BusinessModel.php";

    $distanceModel = new BusinessModel();
    $distanceModel->setLat($_REQUEST["lat"]);
    $distanceModel->setLng($_REQUEST["lng"]);
    $distanceModel->getShopLatLng();

?>