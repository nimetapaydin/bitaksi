<?php
    error_reporting(E_ALL^E_NOTICE);
    require "../config.php";
    session_start();

    if (isset($_GET["cikis"]) && $_GET["cikis"] == true) {
        session_destroy();
        header("Location: ". _SITE_URL_ ."admin");
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
</head>
<body>
    <ul>
        <li><a href="?sayfa=arac_ekle">Araç Ekle</a></li>
        <li><a href="?sayfa=aktif_soforler">Şoförleri Görüntüle</a></li>
        <li><a href="?sayfa=rapor">Raporları Görüntüle</a></li>
    </ul>
    <p><a href="?cikis=true">Çıkış Yap</a></p>
</body>
</html>