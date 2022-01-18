<?php
    session_start();
    require_once "Page.php";
    load_view("functions");

    unset($_SESSION["shopping_cart"]);
    redirectTo("payment.php");
?>