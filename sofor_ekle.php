<?php
    require "./config.php";

    if (isset($_POST["sofor_adisoyadi"]) && isset($_POST["sofor_sifre"]) && isset($_POST["sofor_tc"])) {
        require './database.php';
        $query = $db->prepare("INSERT INTO sofor SET adisoyadi = ?, tc = ?, sifre = ?");

        $insert = $query->execute([
            $_POST["sofor_adisoyadi"],
            $_POST["sofor_tc"],
            md5($_POST["sofor_sifre"])
        ]);

        if ($insert){
            $last_id = $db->lastInsertId();
            echo "Şoför eklendi!";
        }
        else {
            echo "Ekleme işlemi başarısız";
        }

        die();
    }

?>
<a href="<?=_SITE_URL_?>">Anasayfa</a>
<h2>Şoför kayıt</h2>
<table>
    <tbody>
        <tr>
            <td>Soför'ün adı soyadı</td>
            <td><input type="text" name="sofor_adisoyadi" id="sofor_adisoyadi"></td>
        </tr>
        <tr>
            <td>T.C</td>
            <td><input type="text" name="sofor_tc" id="sofor_tc"></td>
        </tr>
        <tr>
            <td>Şifre</td>
            <td><input type="text" name="sofor_sifre" id="sofor_sifre"></td>
        </tr>
        <tr>
            <td></td>
            <td><button onclick="soforEkle()">Ekle</button></td>
        </tr>
    </tbody>
</table>
<script>
    function soforEkle() {
        var sofor_adisoyadi = document.getElementById('sofor_adisoyadi').value;
        var sofor_tc = document.getElementById('sofor_tc').value;
        var sofor_sifre = document.getElementById('sofor_sifre').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xhttp.responseText);
            }
        };
        xhttp.open("POST", "", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
        xhttp.send('sofor_adisoyadi=' + sofor_adisoyadi + '&' +
                'sofor_tc='        + sofor_tc        + '&' +
                'sofor_sifre='     + sofor_sifre     + '&');
    }
</script>