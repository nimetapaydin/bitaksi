<?php
    require "../config.php";

    if (!isset($_SESSION["isadmin"]) || $_SESSION["isadmin"] != true) {
        header("Location: ". _SITE_URL_ ."admin/giris.php");
        die();
    }