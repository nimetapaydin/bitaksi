<?php
    require './config.php';
    session_start();

    if (isset($_GET["cikis"])) {
        session_destroy();
        header("Location: ". _SITE_URL_ ."taksici_giris.php");
        die();
    }

    if (isset($_SESSION["oturum_acti"]) && $_SESSION["oturum_acti"] == true) {
        require './database.php';
        $query = $db->prepare("SELECT * FROM sofor WHERE tc=?");

        $query->execute([
            $_SESSION["tc"]
        ]);

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        $sofor = $rows[0];

?>
<table border='1'>
    <tbody>
        <tr>
            <td>Adınız:</td>
            <td><?=$sofor["adisoyadi"]?></td>
        </tr>
        <tr>
            <td>Şuanki Durumunuz:</td>
            <td><?=$sofor["aktif"] == 0 ? "Şu an boştasınız" : "Şu an çalışmaktasınız"?></td>
        </tr>
        <tr>
            <td></td>
            <td><a href="?cikis=true">Çıkış Yap</a></td>
        </tr>
    </tbody>
</table>
<?php

    }
    else {
        header("Location: ". _SITE_URL_ ."taksici_giris.php");
        die();
    }

?>
