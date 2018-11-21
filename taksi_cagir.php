<?php
    require './config.php';
    if (isset($_POST["musteri_adisoyadi"]) && isset($_POST["musteri_telefon"]) && isset($_POST["musteri_adres"])) {
        require './database.php';

        $bosta_araba = $db->query("SELECT plaka FROM arac WHERE sofor_id IS NULL");
        $bosta_araba = $bosta_araba->fetch();
        $rastgele_sofor = "SELECT id, tc FROM sofor WHERE aktif = '0' AND onayli = '1' ORDER BY RAND()";
        if (!$bosta_araba) {
            $rastgele_sofor = "SELECT id, tc FROM sofor WHERE aktif = '0' AND onayli = '1' AND id IN(SELECT sofor_id FROM arac WHERE sofor_id IS NOT NULL) ORDER BY RAND()";            
        }

        // PDO::FETCH_ASSOC satır satır çeker
        $query = $db->query($rastgele_sofor, PDO::FETCH_ASSOC);
        //Aktif olmayan şoför var mı diye bakar.
        if ($query->rowCount() > 0) {
            $sofor = $query->fetch();

            $araba = $db->prepare("SELECT * FROM arac WHERE sofor_id = ?");
            $araba->execute([$sofor["id"]]);

            if ($araba->rowCount() > 0) {
                // arabası varsa
                $db->prepare("UPDATE sofor SET aktif = ? WHERE id = ?")->execute(["1", $sofor["id"]]);

                $insert = $db->prepare("INSERT INTO cagri SET sofor_id = ?, musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ?");
                $insert = $insert->execute([
                    $sofor["id"],
                    $_POST["musteri_adisoyadi"],
                    $_POST["musteri_telefon"],
                    $_POST["musteri_adres"],
                    1
                ]);
                
                if ($insert) {
                    echo "Araç yola çıkmıştır";
                }
                else {
                    echo "Taksi çağrılırken bir sorun oluştu";
                }   
            }
            else {
                // arabası yoksa
                $araba = $db->query("SELECT plaka FROM arac WHERE sofor_id IS NULL");
                $araba = $araba->fetch();
                if (!$araba) {
                    echo "Boşta aracımız yoktur";
                }
                else {
                    // o soför'e araç tahsis edilir
                    $db->prepare("UPDATE arac SET sofor_id = ? WHERE plaka = ?")->execute([$sofor["id"], $araba["plaka"]]);

                    // araba atandığı için soför yola çıkmaya hazır
                    $db->prepare("UPDATE sofor SET aktif = ? WHERE id = ?")->execute(["1", $sofor["id"]]);

                    $insert = $db->prepare("INSERT INTO cagri SET sofor_id = ?, musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ?");
                    $insert = $insert->execute([
                        $sofor["id"],
                        $_POST["musteri_adisoyadi"],
                        $_POST["musteri_telefon"],
                        $_POST["musteri_adres"],
                        1
                    ]);

                    if ($insert) {
                        echo "Araç yola çıkmıştır";
                    }
                    else {
                        echo "Taksi çağrılırken bir sorun oluştu";
                    }
                }
            }
        }
        else {
            echo "Boşta aracımız yoktur";
        }
        die();
    }

?>
<html class="taksi_cagir">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="style.css" />
   
<body>
<div class="loginbox">
    <img src="avatar.png" class="avatar">

<a href="<?=_SITE_URL_?>">Anasayfa</a>
<h2>Taksi Çağır</h2>

    <table>
        <tbody>
            <tr>
                <td>İsminiz</td>
                <td><input type="text" name="musteri_adisoyadi" id="musteri_adisoyadi"></td>
            </tr>
            <tr>
                <td>Telefonunuz</td>
                <td><input type="text" name="musteri_telefon" id="musteri_telefon"></td>
            </tr>
            <tr>
                <td>Adresiniz</td>
                <td><input type="text" name="musteri_adres" id="musteri_adres"></td>
            </tr>
            <tr>
                <td></td>
                <td><button onclick="taksicagir()">Ekle</button></td>
            </tr>
        </tbody>
    </table>

</div>    
</body>
</head>
</html>
<script>
    function taksicagir() {
        var sofor_adisoyadi = document.getElementById('musteri_adisoyadi').value;
        var sofor_tc = document.getElementById('musteri_telefon').value;
        var sofor_sifre = document.getElementById('musteri_adres').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xhttp.responseText);
            }
        };
        xhttp.open("POST", "", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
        xhttp.send('musteri_adisoyadi=' + musteri_adisoyadi + '&' +
                   'musteri_telefon='        + musteri_telefon        + '&' +
                   'musteri_adres='     + musteri_adres     + '&');
    }
</script>