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

                $musteri_varmi = $db->prepare("SELECT * FROM cagri WHERE sofor_id = ?");
                $musteri_varmi->execute([$sofor["id"]]);

                $insert = false;
                if ($musteri_varmi->rowCount() > 0) {
                    $cagri_sorgusu = "UPDATE cagri SET musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ? WHERE sofor_id = ?";   
                    $insert = $db->prepare($cagri_sorgusu);
                    $insert = $insert->execute([
                        $_POST["musteri_adisoyadi"],
                        $_POST["musteri_telefon"],
                        $_POST["musteri_adres"],
                        1,
                        $sofor["id"]
                    ]);
                }
                else {
                    $cagri_sorgusu = "INSERT INTO cagri SET sofor_id = ?, musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ?";
                    $insert = $db->prepare($cagri_sorgusu);
                    $insert = $insert->execute([
                        $sofor["id"],
                        $_POST["musteri_adisoyadi"],
                        $_POST["musteri_telefon"],
                        $_POST["musteri_adres"],
                        1
                    ]);
                }
                
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
                    $musteri_varmi = $db->prepare("SELECT * FROM cagri WHERE sofor_id = ?");
                    $musteri_varmi->execute([$sofor["id"]]);

                    $insert = false;
                    if ($musteri_varmi->rowCount() > 0) {
                        $cagri_sorgusu = "UPDATE cagri SET musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ? WHERE sofor_id = ?";   
                        $insert = $db->prepare($cagri_sorgusu);
                        $insert = $insert->execute([
                            $_POST["musteri_adisoyadi"],
                            $_POST["musteri_telefon"],
                            $_POST["musteri_adres"],
                            1,
                            $sofor["id"]
                        ]);
                    }
                    else {
                        $cagri_sorgusu = "INSERT INTO cagri SET sofor_id = ?, musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ?";
                        $insert = $db->prepare($cagri_sorgusu);
                        $insert = $insert->execute([
                            $sofor["id"],
                            $_POST["musteri_adisoyadi"],
                            $_POST["musteri_telefon"],
                            $_POST["musteri_adres"],
                            1
                        ]);
                    }

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
<?php require 'view_header.php';?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Taksi Çağır</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
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
            width:400px;
            height:350px;
            background: #191919;
            color:#fff;
            top :50%;
            left : 50%;
            position:absolute;
            transform:translate(-50%,-50%);
            box-sizing:border-box;
            padding: 70px 30px;
            border-radius:10%;
        }
        .avatar{
            width:100px;
            height:100px;
            border-radius:30%;
            position:absolute;
            top :-50px;
            left:calc(50% - 10%);
        }
        h2{
        
            margin:0px;
            padding: 10 0 0 20px;
            text-align:center;
            font-size : 15px;
        }
        .login p{
            margin:0;
            padding: 0;
            font-weight:bold;
        }
        .login input{
        width:200px;
        margin-bottom:5px; 
        margin-top:10px; 
        }
        .login input[type="text"],input[type="password"]{
            border:none;
            border-bottom: 1px solid #fff;
            background: transparent;
            outline:none;
            height:40px;
            color :#fff;
            font-size :16px;
            margin-left:10px;
        }
        
        .login a{
        text-decoration:none;
        font-size:12px;
        line-height:20px;
        color: darkgrey; 
        margin-left:155px;
        }
        .login a:hover{
        color: #ffc107; 
        }
        button{
            border:none;
            outline:none;
            height:25px;
            width:80px;
            background: #ffc107;
            color: #fff;
            font-size :16px;
            border-radius:20px;
            margin-left:50px;
            margin-top:10px;
        }
        button:hover{
            cursor:pointer;
            background: #ffc099;
            color: #000;      
        }
    
    </style> 
</head>
<body>
<div class="login">
    <img src="card.png" class="avatar">
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
    <a href="<?=_SITE_URL_?>">Anasayfa</a>

</div>  
</body>
</html>
  



<script>
    function taksicagir() {
        var musteri_adisoyadi = document.getElementById('musteri_adisoyadi').value;
        var musteri_telefon = document.getElementById('musteri_telefon').value;
        var musteri_adres = document.getElementById('musteri_adres').value;

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