<?php
    session_start();
    require_once "header.php";
    require_once "../Model/Database.php";
    require_once "functions.php";
    if(isset($_GET["token"]) && isset($_GET["user_id"]) && isset($_GET["lessor_id"])){
        $db = new Database();
        $token = $_GET["token"];
        $user_id = $_GET["user_id"];
        $lessor_id = $_GET["lessor_id"];
        $sql = "SELECT * FROM `tblfeedback` WHERE `Token`='$token' && `status`='OFF'";
        $stmt = $db->getConn()->prepare($sql);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        if($rowCount != 0){
            
        }else{
            redirectTo("show404.php");
        }
    }else{
        redirectTo("show404.php");
    }


?>

<body>
    <?php
        include_once "messenger.php";
    ?>
    <div class="container">
        <?php
            include_once "navigation.php";
        ?>
        <div class="show404 text-center p-5">
                <?php
                    $tblbusiness = new Database();
                    $tblbusinessSql = "SELECT * FROM `tblbusiness` WHERE `lessor_id`='$lessor_id'";
                    $tblbusinessStmt = $tblbusiness->getConn()->prepare($tblbusinessSql);
                    $tblbusinessStmt->execute();
                    $tblbusinessRow = $tblbusinessStmt->fetch();
                ?>
            <img class="shadow border border-1 p-1" style="width: 120px; height: 120px; border-radius: 50%;"
                src="../assets/img/businessImg/<?php echo $tblbusinessRow["Banner"]?>" alt="">
            <h3 class="mt-2"><?= $tblbusinessRow["Name"] ?></h3>
            <div>
                <div class="rating text-center">
                    <p id="poor-ratings" class="fs-14 mb-0">Poor 1/5</p>
                    <p id="weak-ratings" class="fs-14 mb-0">Weak 2/5</p>
                    <p id="good-ratings" class="fs-14 mb-0">Good 3/5</p>
                    <p id="verygood-ratings" class="fs-14 mb-0">Very Good 4/5</p>
                    <p id="excellent-ratings" class="fs-14 mb-0">!Excellent 5/5</p>

                    <span id="five-star">☆</span><span id="four-star">☆</span><span id="three-star">☆</span><span
                        id="two-star">☆</span><span id="one-star">☆</span>
                    <input type="hidden" id="lessorid" value="<?= $_GET["lessorid"] ?>">
                    <input type="hidden" id="User_id" value="<?php if(isset($_SESSION["User_id"]))
                        
                                { echo $_SESSION["User_id"]; } ?>">


                </div>
                <div>
                    <h3>Leave Comments</h3>
                    <textarea class="form-control" name="comments" id="comments" cols="40" rows="4"></textarea>
                    <div class="mt-3">
                        <input class="btn btn-success" id="submitReview" type="submit" value="Post a review">
                        <input type="hidden" name="token" id="token" value="<?= $token ?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?= $user_id?>">
                        <input type="hidden" name="lessor_id" id="lessor_id" value="<?= $lessor_id ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        require_once "viewFooter.php";
    ?>
    <script>
    $(function() {
        $('label').css("font-size", "14px");

        let user_id = $('#user_id').val();
        let token = $('#token').val();
        let lessor_id = $('#lessor_id').val();

        let ratings = 0;
        let poorRatings = $('#poor-ratings');
        let weakRatings = $('#weak-ratings');
        let goodRatings = $('#good-ratings');
        let verygood_ratings = $('#verygood-ratings');
        let excellent_ratings = $('#excellent-ratings');
        let submit = $('#submitReview');
        poorRatings.hide();
        weakRatings.hide();
        goodRatings.hide();
        verygood_ratings.hide();
        excellent_ratings.hide();
        let oneStar = $('#one-star');
        let twoStar = $('#two-star');
        let threeStar = $('#three-star');
        let fourStar = $('#four-star');
        let fiveStar = $('#five-star');
        // HOVER STARS
        oneStar.hover(function() {
            poorRatings.show();
            weakRatings.hide();
            goodRatings.hide();
            verygood_ratings.hide();
            excellent_ratings.hide();
        });
        twoStar.hover(function() {
            poorRatings.hide();
            weakRatings.show();
            goodRatings.hide();
            verygood_ratings.hide();
            excellent_ratings.hide();
        });
        threeStar.hover(function() {
            poorRatings.hide();
            weakRatings.hide();
            goodRatings.show();
            verygood_ratings.hide();
            excellent_ratings.hide();
        });
        fourStar.hover(function() {
            poorRatings.hide();
            weakRatings.hide();
            goodRatings.hide();
            verygood_ratings.show();
            excellent_ratings.hide();
        });
        fiveStar.hover(function() {
            poorRatings.hide();
            weakRatings.hide();
            goodRatings.hide();
            verygood_ratings.hide();
            excellent_ratings.show();
        });
        // ONCLICK STARS
        oneStar.click(function() {
            oneStar.html("★");
            oneStar.css("color", "rgb(255,205,60)");
            twoStar.html("☆");
            twoStar.css("color", "#000");
            threeStar.html("☆");
            threeStar.css("color", "#000");
            fourStar.html("☆");
            fourStar.css("color", "#000");
            fiveStar.html("☆");
            fiveStar.css("color", "#000");
            ratings = 1;
        });
        twoStar.click(function() {
            oneStar.html("★");
            oneStar.css("color", "rgb(255,205,60)");
            twoStar.html("★");
            twoStar.css("color", "rgb(255,205,60)");
            threeStar.html("☆");
            threeStar.css("color", "#000");
            fourStar.html("☆");
            fourStar.css("color", "#000");
            fiveStar.html("☆");
            fiveStar.css("color", "#000");
            ratings = 2;
        });
        threeStar.click(function() {
            oneStar.html("★");
            oneStar.css("color", "rgb(255,205,60)");
            twoStar.html("★");
            twoStar.css("color", "rgb(255,205,60)");
            threeStar.html("★");
            threeStar.css("color", "rgb(255,205,60)");
            fourStar.html("☆");
            fourStar.css("color", "#000");
            fiveStar.html("☆");
            fiveStar.css("color", "#000");
            ratings = 3;
        });
        fourStar.click(function() {
            oneStar.html("★");
            oneStar.css("color", "rgb(255,205,60)");
            twoStar.html("★");
            twoStar.css("color", "rgb(255,205,60)");
            threeStar.html("★");
            threeStar.css("color", "rgb(255,205,60)");
            fourStar.html("★");
            fourStar.css("color", "rgb(255,205,60)");
            fiveStar.html("☆");
            fiveStar.css("color", "#000");
            ratings = 4;
        });
        fiveStar.click(function() {
            oneStar.html("★");
            oneStar.css("color", "rgb(255,205,60)");
            twoStar.html("★");
            twoStar.css("color", "rgb(255,205,60)");
            threeStar.html("★");
            threeStar.css("color", "rgb(255,205,60)");
            fourStar.html("★");
            fourStar.css("color", "rgb(255,205,60)");
            fiveStar.html("★");
            fiveStar.css("color", "rgb(255,205,60)");
            ratings = 5;

        });

        submit.click(function() {
            let comments = $('#comments').val();
            console.log(ratings);
            console.log(comments);
            console.log(user_id);
            console.log(lessor_id);
            console.log(token);

            var feedbackData = {};
            feedbackData.ratings = ratings;
            feedbackData.comments = comments;
            feedbackData.user_id = user_id;
            feedbackData.lessor_id = lessor_id;
            feedbackData.token = token;
            feedback(feedbackData);

        });

        function feedback(feedbackData) {
            $.ajax({
                url: '../Model/Feedback.php',
                data: feedbackData,
                success: function(res) {
                    window.location.href = "success_review.php";
                },
                error: function(err) {
                    console.log(err);
                }

            });
        }
    });
    </script>
    <?php
        require_once "footer.php";
    ?>