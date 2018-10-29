<?php
    if (isset($_POST["arac_plaka"]) && isset($_POST["arac_model"])&& isset($_POST["arac_yakit"])) {
        require './database.php';
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
<h2>Araç ekleme</h2>

<form action="" method="POST">
    <table>
        <tbody>
            <tr>
                <td>Aktif Şoförler</td>
                <td><input type="text" name="aktif_sofor" id=""></td>
            </tr>
            <tr>
                <td>Saat</td>
                <td><input type="text" name="saat" id=""></td>
            </tr>
            <tr>
                <td>Adres</td>
                <td><input type="text" name="adres" id=""></td>
            </tr>
            <tr>
                <td></td>
                <td><button>Ekle</button></td>
            </tr>
        </tbody>
    </table>
</form>