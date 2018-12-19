<?php
    error_reporting(E_ALL^E_NOTICE);
    require "../config.php";
    session_start();

    if (isset($_GET["cikis"]) && $_GET["cikis"] == true) {
        session_destroy();
        header("Location: ". _SITE_URL_);
        die();
    }

    if (!isset($_SESSION["isadmin"]) || $_SESSION["isadmin"] != true) {
        header("Location: ". _SITE_URL_ ."admin/giris.php");
        die();
    }

    if (isset($_GET["sayfa"])) {
        switch ($_GET["sayfa"]) {
            case "arac_ekle":
                require "./arac_ekle.php";
                die();
            case "aktif_soforler":
                require "./aktif_soforler.php";
                die();
            case "rapor":
                require "./rapor.php";
                die();
            default:
                break;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <style>
    body{
        margin:0;
        padding:0;
        background-size: cover;
        background-position:center;
        font-family:sans-serif;
        font-size:20px;
    }
    .login{
        width:370px;
        height:300px;
        background: rgba(0,0,0,0.65);
        color:#fff;
        top :50%;
        left : 50%;
        position:absolute;
        transform:translate(-50%,-50%);
        box-sizing:border-box;
        padding: 70px 30px;
        border-radius:7%;
    }
    .avatar{
        width:100px;
        height:100px;
        border-radius:50%;
        position:absolute;
        top :-50px;
        left:calc(50% - 10%);
    }
    .login p{
        margin:0;
        padding: 0;
        font-weight:bold;
    }
    .login a{
       text-decoration:none;
       font-size:12px;
       line-height:20px;
       color: darkgrey;
       margin-left:50px;
      
    }
    .login a:hover{
       color: #ffc107;
    }
   

</style>
</head>
<body>
<div  class="login">
    <img src="../driver.png" class="avatar">
    <ul>
    <p><li><a href="?sayfa=arac_ekle">Araç Ekle</a></li></p>
    <p><li><a href="?sayfa=aktif_soforler">Şoförleri Görüntüle</a></li></p>
    <p><li><a href="?sayfa=rapor">Raporları Görüntüle</a></li></p>
    </ul>
    <p><a href="?cikis=true">Çıkış Yap</a></p>
</body>
</html>