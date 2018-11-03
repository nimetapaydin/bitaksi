<?php
    session_start();
    require "./check_admin.php";

    if (isset($_POST["arac_plaka"]) && isset($_POST["arac_model"]) && isset($_POST["arac_yakit"])) {
        require '../database.php';
        $query = $db->prepare("INSERT INTO arac SET plaka = ?, model = ?, yakit = ?");

        $insert = $query->execute([
            $_POST["arac_plaka"],
            $_POST["arac_model"],
            $_POST["arac_yakit"],
        ]);

        if ($insert){
            $last_id = $db->lastInsertId();
            echo "Araç eklendi!";
        }
        else {
            echo "Ekleme işlemi başarısız";
        }
    }

?>
<a href="<?=_SITE_URL_."admin"?>">Admin</a>
<h2>Araç ekleme</h2>
<form action="" method="POST">
    <table>
        <tbody>
            <tr>
                <td>Araç'ın plakası</td>
                <td><input type="text" name="arac_plaka" id=""></td>
            </tr>
            <tr>
                <td>Araç'ın modeli</td>
                <td><input type="text" name="arac_model" id=""></td>
            </tr>
            <tr>
                <td>Araç Yakıt</td>
                <td><input type="text" name="arac_yakit" id=""></td>
            </tr>
            <tr>
                <td></td>
                <td><button>Ekle</button></td>
            </tr>
        </tbody>
    </table>
</form>