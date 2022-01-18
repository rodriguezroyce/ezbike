<div class="col-md-12">
    <div class="header_dashboard">
        <div>
            <form class="d-flex" action="admin_location.php" method="GET">
                <input class="form-control" type="text" id="searchPlace" name="searchPlace" value="<?php if(isset($_GET["searchPlace"])){
                echo $_GET["searchPlace"];
            } ?>" placeholder="search">
                <button class="btn btn-primary" type="submit" id="submit" name="submit"> Search </button>
            </form>
        </div>


        <ul class="navheader-right fs-15">
            <li class="mt-3"><a href="#"><i class="ti-bell text-dark bg-light"></i></a></li>
            <li class="mt-3"><a href="#"><i class="ti-email text-dark bg-light"></i></a></li>
            <li>
                <div class="dropdown">
                    <button class="btn btn-transparent fs-13 dropdown-toggle text-secondary" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle" style="width: 30px; height: 30px;" src="../assets/img/human-3.jpg"
                            alt="">
                        <?php echo $_SESSION["admin_username"] ?>
                    </button>
                    <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">My Profile</a>
                        <a class="dropdown-item" href="session_logout.php">Log-out</a>

                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>