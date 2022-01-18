<?php
    include_once "functions.php";
    session_start();
    session_unset();
    session_destroy();
    redirectTo("lenderLogin.php?login_attempt=Session Expired!");
?>