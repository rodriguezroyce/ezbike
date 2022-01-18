<?php
    session_start();    
    require_once "functions.php";
    require_once "../Model/Bicycle.php";
    if(!isset($_SESSION["lessor_id"])){
        redirectTo("lenderLogin.php");
    }
    require_once "../Model/Lessor.php";
    require_once "../Model/Database.php";    
    require_once "../Model/BusinessModel.php";
    require_once "../Model/Registration.php";
    if($_SERVER["REQUEST_METHOD"] =="POST"){
        if(isset($_POST["saveBtn"])){
            $businessModel = new BusinessModel();
            $businessModel->setStoreName(validate($_POST["bicycleName"]));
            $businessModel->setBanner(validate($_FILES["banner"]["name"]));
            $businessModel->setAddressLine1(validate($_POST["addressLine1"]));
            $businessModel->setAddressLine2(validate($_POST["addressLine2"]));

            $businessModel->setRegion(validate($_POST["region"]));
            $businessModel->setProvince(validate($_POST["province"]));
            $businessModel->setCity(validate($_POST["city"]));
            $businessModel->setBarangay(validate($_POST["barangay"]));
            $businessModel->setZipCode(validate($_POST["zip_code"]));

            

            $mydb = new Database();
            $bicycle = new Bicycle();

            $sql = "INSERT INTO `tblbusiness` (`lessor_id`,`Name`,`Banner`,`Address_Line1`,`Address_Line2`,`Region`,`Province`,`City`,`Barangay`,`Zip_Code`,`Date_Updated`) VALUES (:LESSOR_ID,:NAME,:BANNER,:ADDRESS_LINE1,:ADDRESS_LINE2,:REGION,:PROVINCE,:CITY,:BARANGAY,:ZIP_CODE,:DATE_UPLOADED)";
            $stmt = $mydb->getConn()->prepare($sql);
            $stmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"], PDO::PARAM_INT);
            $stmt->bindValue(':NAME', $businessModel->getStoreName(), PDO::PARAM_STR);
            $stmt->bindValue(':BANNER', $businessModel->getBanner(), PDO::PARAM_STR);
            $stmt->bindValue(':ADDRESS_LINE1', $businessModel->getAddressLine1(), PDO::PARAM_STR);
            $stmt->bindValue(':ADDRESS_LINE2', $businessModel->getAddressLine2(), PDO::PARAM_STR);
            $stmt->bindValue(':REGION', $businessModel->getRegion(), PDO::PARAM_STR);
            $stmt->bindValue(':PROVINCE', $businessModel->getProvince(), PDO::PARAM_STR);
            $stmt->bindValue(':CITY', $businessModel->getCity(), PDO::PARAM_STR);
            $stmt->bindValue(':BARANGAY', $businessModel->getBarangay(), PDO::PARAM_STR);
            $stmt->bindValue(':ZIP_CODE', $businessModel->getZipCode(), PDO::PARAM_STR);
            $stmt->bindValue(':DATE_UPLOADED', $bicycle->getDateUploaded() , PDO::PARAM_STR);
            
            if($stmt->execute()){
                $dir = "../assets/img/businessImg";
                $tmpName = $_FILES["banner"]["tmp_name"];
                if(!file_exists($dir)){
                    mkdir($dir);
                }else{
                    move_uploaded_file($tmpName, $dir."/".$businessModel->getBanner());
                    redirectTo("lessor_profile.php?success_insert=Your have successfully updated your business information!");
                }
            }else{
                    redirectTo("lessor_profile.php?failed_insert=Your have successfully updated your business information!");
            }
            $stmt->closeCursor();

        }
        if(isset($_POST["passBtn"])){
            $database = new Database();
            $registration = new Registration();
            $my_id = $_SESSION["lessor_id"];
            $sql = "SELECT `lessor_password` FROM `tbllessor` WHERE `lessor_id`='$my_id'";
            $stmt = $database->getConn()->prepare($sql);
            $stmt->execute();
            $my_password = $stmt->fetch();
        
            $lessor_acc = new Lessor();
            $lessor_acc->setOldPassword(validate($_POST["oldpw"]));
            $lessor_acc->setNewPassword(validate($_POST["newpw"]));
            $lessor_acc->setConfirmPassword(validate($_POST["confirmpw"]));
            try{
                if(empty($lessor_acc->getOldPassword()) || empty($lessor_acc->getNewPassword()) || empty($lessor_acc->getConfirmPassword())){
                    throw new Exception("fields must not be empty");
                }else if(!$registration->password_check($lessor_acc->getOldPassword(),$my_password["lessor_password"])){
                    throw new Exception("incorrect password!");
                }else{
                    if($lessor_acc->isPasswordMatch($lessor_acc->getNewPassword(), $lessor_acc->getConfirmPassword())){
                        $parsePw = $registration->Password_Encryption($lessor_acc->getNewPassword());
                        $sql_update = "UPDATE `tbllessor` SET `lessor_password`='$parsePw' WHERE `lessor_id`='$my_id'";
                        $stmt_update = $database->getConn()->prepare($sql_update);
                        if($stmt_update->execute()){
                            redirectTo("lessor_profile.php?success_insert=Successfully update user password!");
                        }
                        $stmt_update->closeCursor();
                    }else{
                        redirectTo("lessor_profile.php?failed_insert=Password does not match");
                    }
                }
            }catch(Exception $e){
                redirectTo('lessor_profile.php?failed_insert='. $e->getMessage() .'');
            }
        }
        if(isset($_POST["updateBtn"])){
            $shopName = validate($_POST["shopName"]);
            $addressLine1 = validate($_POST["addressLine1"]);
            $addressLine2 = validate($_POST["addressLine2"]);
            $zip_code = validate($_POST["zip_code"]);

            $updateDb = new Database();
            $updateSql = "UPDATE `tblbusiness` SET `Name`=:STORENAME , `Address_Line1`=:ADDRESS1 , `Address_Line2`=:ADDRESS2, `Zip_Code`=:ZIP_CODE WHERE `lessor_id`=:LESSOR_ID";
            $updateDbStmt = $updateDb->getConn()->prepare($updateSql);
            $updateDbStmt->bindValue(':STORENAME', $shopName);
            $updateDbStmt->bindValue(':ADDRESS1', $addressLine1);
            $updateDbStmt->bindValue(':ADDRESS2', $addressLine2);
            $updateDbStmt->bindValue(':ZIP_CODE', $zip_code);
            $updateDbStmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"]);
            if($updateDbStmt->execute()){
                redirectTo("lessor_profile.php?success_insert=Successfully Update business information!");
            }
            $updateDbStmt->closeCursor();

        }
        if(isset($_POST["updateBannerBtn"])){
            $shopBanner = $_FILES["shopBanner"]["name"];
            $updateBanner = new Database();
            $updateBannerSql = "UPDATE `tblbusiness` SET `Banner`=:BANNER WHERE `lessor_id`=:LESSOR_ID";
            $updateBannerStmt = $updateBanner->getConn()->prepare($updateBannerSql);
            $updateBannerStmt->bindValue(':BANNER', $shopBanner);
            $updateBannerStmt->bindValue(':LESSOR_ID', $_SESSION["lessor_id"]);
            if($updateBannerStmt->execute()){
                $dir = "../assets/img/businessImg";
                move_uploaded_file($_FILES["shopBanner"]["tmp_name"], $dir."/".$shopBanner);
                redirectTo("lessor_profile.php?success_insert=Successfully Update your banner!");

            }
            $updateBannerStmt->closeCursor();
        }
    }
    
    require_once "header.php";
?>
<title>Ezbike | Lessor Dashboard</title>
</head>

<body>
    <div class="container-fluid web-wash">
        <div class="row">
            <div class="col-md-2 sidenav bg-dark text-light">
                <div class="text-center">
                    <img class="logo" src="../assets/img/ezbike.png" alt="">
                </div>
                <ul class="dashboard-navleft fs-14">
                    <?php
                        require_once "library.php";
                        foreach($nav_elements as $nav_data => $value){   
                            foreach($value as $key => $data_value){                                               
                    ?>
                    <li>
                        <div class="row align-items-center">
                            <div class="col-md-3 px-4">
                                <i class="<?php echo $key;?>"></i>
                            </div>
                            <div class="col-md-9 p-0">
                                <a href="<?php echo $data_value;?>"> <?php echo $nav_data; ?></a>
                            </div>
                        </div>
                    </li>
                    <?php
                            } 
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-10 main">
                <div class="row align-items-center" id="top-main">
                    <div class="col-md-6">
                        <h5 class="mt-1 ff-1">My Profile</h5>
                    </div>
                    <div class="col-md-6" id="nav_top_right">
                        <ul class="navright_utilities mb-0">
                            <li>
                                <a href="lessor_profile.php"><i class="fas fa-user border p-1 px-2 rounded-circle"></i>
                                    My Profile</a>
                            </li>
                            <li> | </li>
                            <li><a href="logoutLessor.php"> <i class="fas fa-sign-out-alt"></i> Log-out</a></li>
                        </ul>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 navbar-background mt-1 border border-2 p-2 rounded">
                        <!-- Button trigger modal -->
                        <?php
                        $db = new Database();
                        $lessor_id = $_SESSION["lessor_id"];
                        $sql = "SELECT * FROM `tblbusiness` WHERE `lessor_id`='$lessor_id'";
                        $stmt = $db->getConn()->prepare($sql);
                        $stmt->execute();
                        $count = $stmt->rowCount();
                        if($count == 0){
                    ?>
                        <button type="button" class="btn btn-primary fs-13" data-bs-toggle="modal"
                            data-bs-target="#setupBusiness">
                            <i class="fas fa-plus"></i> Setup Business
                        </button>
                        <?php
                        }else{
                    ?>
                        <?php
                        }
                        
                        ?>
                        <a class="btn btn-transparent border"
                            href="<?php echo "clientPage.php?lessorid=".$_SESSION["lessor_id"]; ?>"
                            target="_blank">Visit Page</a>
                        <!-- Modal -->
                        <div class="modal fade" id="setupBusiness" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title ff-2" id="staticBackdropLabel">Setup Business Information
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                            method="POST" enctype="multipart/form-data">
                                            <div class="row align-items-center">
                                                <!-- store name -->
                                                <div class="col-md-3 mt-1">
                                                    <label for="Name">Store Name</label>
                                                </div>
                                                <div class="col-md-9 mt-1">
                                                    <input class="form-control" type="text" name="bicycleName" required>
                                                </div>
                                                <!-- banner -->
                                                <div class="col-md-3 mt-1">
                                                    <label for="banner">Banner</label>
                                                </div>
                                                <div class="col-md-9 mt-1">
                                                    <input id="image" class="form-control" type="file" name="banner"
                                                        onchange="readURL(this);">
                                                    <div id="preview">

                                                    </div>
                                                </div>
                                                <!--  -->
                                                <div class="col-md-3 mt-1">
                                                    <label for="addressLine1">Address Line 1:</label>
                                                </div>
                                                <div class="col-md-9 mt-1">
                                                    <input class="form-control" type="address" name="addressLine1"
                                                        placeholder="street address" required>
                                                </div>
                                                <div class="col-md-3 mt-1">
                                                    <label for="addressLine2">Address Line 2:</label>
                                                </div>
                                                <div class="col-md-9 mt-1">
                                                    <input class="form-control" type="address" name="addressLine2"
                                                        placeholder="apartment nos. suite or other">
                                                </div>
                                                <!-- province -->
                                                <div class="col-md-12 mt-1">
                                                    <label for="region">Region</label>
                                                    <select class="form-select" name="region" id="region">
                                                        <option value="15">AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)
                                                        </option>
                                                        <option value="14">CORDILLERA ADMINISTRATIVE REGION (CAR)
                                                        </option>
                                                        <option value="13">NATIONAL CAPITAL REGION (NCR)</option>
                                                        <option value="01">REGION I (ILOCOS REGION)</option>
                                                        <option value="02">REGION II (CAGAYAN VALLEY)</option>
                                                        <option value="03">REGION III (CENTRAL LUZON)</option>
                                                        <option value="04">REGION IV-A (CALABARZON)</option>
                                                        <option value="17">REGION IV-B (MIMAROPA)</option>
                                                        <option value="09">REGION IX (ZAMBOANGA PENINSULA)</option>
                                                        <option value="05">REGION V (BICOL REGION)</option>
                                                        <option value="06">REGION VI (WESTERN VISAYAS)</option>
                                                        <option value="07">REGION VII (CENTRAL VISAYAS)</option>
                                                        <option value="08">REGION VIII (EASTERN VISAYAS)</option>
                                                        <option value="10">REGION X (NORTHERN MINDANAO)</option>
                                                        <option value="11">REGION XI (DAVAO REGION)</option>
                                                        <option value="12">REGION XII (SOCCSKSARGEN)</option>
                                                        <option value="16">REGION XIII (Caraga)</option>
                                                    </select>
                                                </div>
                                                <!-- city -->
                                                <div class="col-md-6 mt-1">
                                                    <label for="province">Province</label>
                                                    <select class="form-select" name="province" id="province">

                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label for="city">City</label>
                                                    <select class="form-select" name="city" id="city">

                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label for="barangay">Barangay</label>
                                                    <select class="form-select" name="barangay" id="barangay"></select>
                                                </div>
                                                <!-- zipcode -->
                                                <div class="col-md-6 mt-1">
                                                    <label for="zip_code">Zip Code: </label>
                                                    <input class="form-control" type="text" name="zip_code" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <input type="submit" name="saveBtn" class="btn btn-primary"
                                                    value="Save Changes">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>


                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 p-1">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <!-- account information -->
                                        <h2 class="accordion-header" id="flush-headingFour">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                                                aria-expanded="false" aria-controls="flush-collapseFour">
                                                <i class="ti-lock p-1"></i> Account Information
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <?php
                                            $tbllessor = new Database();
                                            $tbllessorSql = "SELECT * FROM `tbllessor` WHERE `lessor_id`=:LESSOR";
                                            $tbllessorStmt = $tbllessor->getConn()->prepare($tbllessorSql);
                                            $tbllessorStmt->bindValue(':LESSOR', $_SESSION["lessor_id"]);
                                            $tbllessorStmt->execute();
                                            $tbllessorRow = $tbllessorStmt->fetch();
                                        
                                        ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center">
                                                            <label for="lessorid">My Id: </label>
                                                            <p class="mb-1 mx-1 fs-16"><?= $_SESSION["lessor_id"] ?></p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <label for="accountname">Name:</label>
                                                            <p class="mb-1 mx-1 fs-16">
                                                                <?= $tbllessorRow["first_name"] . ' ' .$tbllessorRow["last_name"] ?>
                                                            </p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <label for="accountname">Email:</label>
                                                            <p class="mb-1 mx-1 fs-16">
                                                                <?= $tbllessorRow["lessor_email"]?>
                                                            </p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <label for="lessor_phone">Phone:</label>
                                                            <p class="mb-1 mx-1 fs-16">
                                                                <?= $tbllessorRow["lessor_phone"]?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">

                                                    </div>
                                                </div>
                                                <?php
                                            $tbllessorStmt->closeCursor();
                                            ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <!-- change password -->
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                <i class="ti-lock p-1"></i> Change Password
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                                                    method="post">

                                                    <div class="row">
                                                        <div>
                                                            <label for="oldpw">Enter Old Password<span
                                                                    class="text-danger">*</span> </label>
                                                            <input class="form-control w-50" type="password"
                                                                name="oldpw" id="oldpw">
                                                        </div>
                                                        <div>
                                                            <label for="newpw">New Password: </label>
                                                            <input class="form-control w-50" type="password"
                                                                name="newpw" id="newpw">
                                                        </div>
                                                        <div>
                                                            <label for="newpw">Confirm Password: </label>
                                                            <input class="form-control w-50" type="password"
                                                                name="confirmpw" id="confirmpw">
                                                        </div>
                                                    </div>
                                                    <div class="mt-1">
                                                        <input class="btn btn-success" type="submit" name="passBtn"
                                                            value="Confirm">
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                aria-expanded="false" aria-controls="flush-collapseTwo">
                                                <i class="ti-reload p-1"></i> Business Information
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <?php
                                        $updateTblBusiness = new Database();
                                        
                                        $updateSql = "SELECT * FROM `tblbusiness` WHERE `lessor_id`='$lessor_id'";
                                        $updateStmt = $updateTblBusiness->getConn()->prepare($updateSql);
                                        $updateStmt->execute();
                                        $rowCount = $updateStmt->rowCount();
                                        
                                        $updaterow = $updateStmt->fetch();


                                        if($rowCount != 0){     
                                            $active = true;
                                            
                                            $storename = $updaterow["Name"];
                                            $banner = $updaterow["Banner"];
                                            $addressLine1 = $updaterow["Address_Line1"];
                                            $addressLine2 = $updaterow["Address_Line2"];
                                            $zipcode = $updaterow["Zip_Code"];

                                        }else{
                                            $active = false;
                                            $storename = "";
                                            $banner = "";
                                            $addressLine1 = "";
                                            $addressLine2 = "";
                                            $zipcode = "";
                                        }
                                        if($active){
                                    ?>

                                                <form id="formUpdate"
                                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                    method="POST" enctype="multipart/form-data">

                                                    <div class="row align-items-center">
                                                        <div class="col-md-2 mt-1"><button type="button"
                                                                class="btn btn-outline-primary" id="enableForm"><i
                                                                    class="ti-plus"></i> Edit </button>
                                                        </div>
                                                        <div class="col-md-10 mt-1">

                                                        </div>
                                                        <!-- store name -->
                                                        <div class="col-md-2 mt-1">
                                                            <label for="Name">Store Name</label>
                                                        </div>
                                                        <div class="col-md-10 mt-1">
                                                            <input id="update_name" class="form-control w-50"
                                                                type="text" name="shopName"
                                                                value="<?php echo $storename; ?>" required disabled>
                                                        </div>
                                                        <!--  -->
                                                        <div class="col-md-2 mt-1">
                                                            <label for="addressLine1">Address Line 1:</label>
                                                        </div>
                                                        <div class="col-md-10 mt-1">
                                                            <input id="update_address1" class="form-control w-50"
                                                                type="address" name="addressLine1"
                                                                value="<?php echo $addressLine1; ?>" required disabled>
                                                        </div>
                                                        <div class="col-md-2 mt-1">
                                                            <label for="addressLine2">Address Line 2:</label>
                                                        </div>
                                                        <div class="col-md-10 mt-1">
                                                            <input id="update_address2" class="form-control w-50"
                                                                type="address" name="addressLine2"
                                                                value="<?php echo $addressLine2; ?>" required disabled>
                                                        </div>
                                                        <div class="col-md-2 mt-1">
                                                            <label for="zip_code">Zip Code: </label>
                                                        </div>
                                                        <div class="col-md-10 mt-1">
                                                            <input id="update_zipcode" class="form-control w-50"
                                                                type="text" name="zip_code"
                                                                value="<?php echo $zipcode; ?>" required disabled>
                                                        </div>
                                                        <div class="col-md-2 mt-1"></div>
                                                        <div class="col-md-10 mt-2">
                                                            <input type="submit" name="updateBtn"
                                                                class="btn btn-primary" id="updateBtn" value="Update">
                                                            <input type="reset" id="resetBtn" class="btn btn-secondary">
                                                        </div>
                                                    </div>
                                                </form>
                                                <?php
                                            }else{
                                                echo "<p class=\"text-center fw-lighter bg-secondary text-light rounded border p-2\">No information to display. please click 'setup business' button on the top of the page. </p>";
                                            }
                                        ?>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end -->

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                aria-expanded="false" aria-controls="flush-collapseThree">
                                                <i class="far fa-image mx-1"></i> Banner
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingThree"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form class="d-flex flex-wrap"
                                                    action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                                    method="POST" enctype="multipart/form-data">
                                                    <div class="col-md-2 mt-1">
                                                        <label for="banner">Banner</label>
                                                    </div>
                                                    <div class="col-md-10 mt-1">
                                                        <input id="image1" class="form-control w-50" type="file"
                                                            name="shopBanner"
                                                            value="../assets/img/businessImg/<?php echo $banner; ?>"
                                                            onchange="readURL(this);">
                                                        <div id="preview1">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">

                                                    </div>
                                                    <div class="col-md-10">
                                                        <input class="btn btn-primary mt-2" type="submit"
                                                            name="updateBannerBtn" value="Update Banner">
                                                    </div>
                                                </form>
                                                <!-- banner -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <?php
        if(isset($_GET["success_insert"])){
    ?>
    <div class="col-md-12 px-2">
        <div id="success_insert" class="alert alert-success mt-2 fs-13" role="alert">
            <i class="ti-check px-2"></i>
            <?php echo $_GET["success_insert"] ?>
        </div>
    </div>
    <?php
        }
            ?>
    <?php
        if(isset($_GET["failed_insert"])){
            ?>
    <div class="col-md-12 px-2">
        <div id="failed_insert" class="alert alert-danger mt-2 fs-13" role="alert">
            <i class="ti-close px-2"></i>
            <?php echo $_GET["failed_insert"] ?>
        </div>
    </div>
    <?php
        }
        ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js">
    </script>

    <script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
    <script>
    function readURL(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function(event) {
                $('#preview').html('<img src="' + event.target.result + '" width="200" height="auto"/>');
                $('#preview1').html('<img src="' + event.target.result + '" width="200" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
    $(function() {
        let editBtn = $('#enableForm');
        let updateBtn = $('#updateBtn');
        let resetBtn = $('#resetBtn');
        updateBtn.prop('disabled', true);
        resetBtn.prop('disabled', true);
        let count = 0;
        editBtn.click(function() {
            count++;
            if (count % 2 != 0) {
                updateBtn.prop('disabled', false);
                resetBtn.prop('disabled', false);
            } else {
                updateBtn.prop('disabled', true);
                resetBtn.prop('disabled', true);
            }
        });

        var my_handlers = {
            fill_provinces: function() {
                var region_code = $(this).val();
                $('#province').ph_locations('fetch_list', [{
                    "region_code": region_code
                }]);

            },
            fill_cities: function() {

                var province_code = $(this).val();
                $('#city').ph_locations('fetch_list', [{
                    "province_code": province_code
                }]);
            },
            fill_barangays: function() {

                var city_code = $(this).val();
                $('#barangay').ph_locations('fetch_list', [{
                    "city_code": city_code
                }]);
            }
        };
        $(function() {
            $('#region').on('change', my_handlers.fill_provinces);
            $('#province').on('change', my_handlers.fill_cities);
            $('#city').on('change', my_handlers.fill_barangays);

            $('#region').ph_locations({
                'location_type': 'regions'
            });
            $('#province').ph_locations({
                'location_type': 'provinces'
            });
            $('#city').ph_locations({
                'location_type': 'cities'
            });
            $('#barangay').ph_locations({
                'location_type': 'barangays'
            });

            $('#region').ph_locations('fetch_list');
        });


        $('label').addClass("fs-14");

        // edit button in business information event
        $click_count = 0;
        $('#enableForm').click(() => {
            $click_count++;
            if ($click_count % 2 == 0) {
                $('#update_name').prop("disabled", true);
                $('#image1').prop("disabled", true);
                $('#update_address1').prop("disabled", true);
                $('#update_address2').prop("disabled", true);
                $('#update_zipcode').prop("disabled", true);
                $('#enableForm').html("Edit");
            } else {
                $('#update_name').prop("disabled", false);
                $('#image1').prop("disabled", false);
                $('#update_address1').prop("disabled", false);
                $('#update_address2').prop("disabled", false);
                $('#update_zipcode').prop("disabled", false);
                $('#enableForm').html("disabled");
            }
        });
    });

    $('#success_insert').fadeOut(6000);
    $('#failed_insert').fadeOut(6000);


    $("#image").change(function() {
        readURL(this);
    });
    $("#image1").change(function() {
        readURL(this);
    });
    </script>
    <?php
    require_once "footer.php";
?>