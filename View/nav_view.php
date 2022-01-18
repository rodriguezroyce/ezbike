<div class="container-fluid bg-dark">
    <nav class="d-flex flex-row align-items-center p-3 border-bottom pb-1">
        <div class="col-md-3">
            <button class="btn">
                <i class="ti-align-justify text-light"></i>
            </button>
            <button class=btn>
                <i class="ti-search text-light"></i>
            </button>
        </div>
        <div class="col-md-6 text-light text-center">
            <a class="text-light" href="../index.php">
                <img class="logo" src="../assets/img/EzbikeLogo.png" alt="">
            </a>
        </div>
        <div class="col-md-3" id="nav-right">
            <ul class="main-navbar pt-3">
                <?php
                                if(isset($_SESSION["Email"])){
                                    echo "<li> <a href=\"#\">" . $_SESSION["FirstName"]. "</a></li>";
                                    echo "<li> <a class=\"fs-13\" href=\"./View/logout.php\"> Logout </a></li>";
                                }else{
                            ?>
                <li><a class="fs-16" href="../View/login.php"><i class="fas fa-user"></i></a></li>
                </li>
                <li><a class="fs-16" href="../View/login.php"><i class="ti-shopping-cart"></i></a></li>
                </li>
                <?php
                                }
                            ?>
            </ul>
        </div>
    </nav>
</div>