<?php
    if (isset($_POST["sofor_adisoyadi"]) && isset($_POST["sofor_maas"])) {
        require './database.php';
        $query = $db->prepare("INSERT INTO sofor SET adisoyadi = ?, maas = ?, aktif = ?");

        $insert = $query->execute([
            $_POST["sofor_adisoyadi"],
            $_POST["sofor_maas"],
            0
        ]);

        if ($insert){
            $last_id = $db->lastInsertId();
            echo "Şoför eklendi!";
        }
        else {
            echo "Ekleme işlemi başarısız";
        }
    }

?>
<h2>Şoför ekleme</h2>

<form action="" method="POST">
    <table>
        <tbody>
            <tr>
                <td>Soför'ün adı soyadı</td>
                <td><input type="text" name="sofor_adisoyadi" id=""></td>
            </tr>
            <tr>
                <td>Maaş</td>
                <td><input type="text" name="sofor_maas" id=""></td>
            </tr>
            <tr>
                <td></td>
                <td><button>Ekle</button></td>
            </tr>
        </tbody>
    </table>
</form>