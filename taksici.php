<?php
    require './config.php';
    require './database.php';
    session_start();

    if (isset($_GET["cikis"])) {
        session_destroy();
        header("Location: ". _SITE_URL_ ."taksici_giris.php");
        die();
    }

    
    if (isset($_SESSION["oturum_acti"]) && $_SESSION["oturum_acti"] == true) {
        
        $sofor = $db->prepare("SELECT * FROM sofor WHERE tc=?");
        $sofor->execute([$_SESSION["tc"]]);
        $sofor = $sofor->fetch();
        
        $musteri = $db->prepare("SELECT * FROM cagri WHERE sofor_id = ? AND aktif = ?");
        $musteri->execute([
            $sofor["id"],
            1,
        ]);
            
        $musteri = $musteri->fetch();
            
        if (isset($_GET["tamamla"]) && isset($_POST["alinan_ucret"])) {
            $sofor_update = $db->prepare("UPDATE sofor SET aktif = '0' WHERE id = ?");
            $sofor_arabasi = $db->prepare("SELECT plaka FROM arac WHERE sofor_id = ?");

            $sofor_arabasi = $db->prepare("SELECT plaka FROM arac WHERE sofor_id = ?");
            $sofor_arabasi->execute([$sofor["id"]]);
            $sofor_arabasi = $sofor_arabasi->fetch();

            $musteri_update = $db->prepare("UPDATE cagri SET aktif = '0' WHERE aktif = '1' AND sofor_id = ?");
            $rapor_insert = $db->prepare("INSERT INTO rapor SET sofor_id = ?, arac_plaka = ?, tarih = NOW(), kazanc = ?");

            $sofor_update = $sofor_update->execute([
                $sofor["id"]
            ]);

            $musteri_update = $musteri_update->execute([
                $sofor["id"]
            ]);

            $rapor_insert = $rapor_insert->execute([
                $sofor["id"],
                $sofor_arabasi["plaka"],
                $_POST["alinan_ucret"]
            ]);

            if($rapor_insert) {
                echo "İş tamamlandı";
            }
            else {
                echo "İş tamamlanırken bir sorun oluştu";
            }

            echo "<br/><a href=\"?\">Geri dön</a>";


            die();
        }

?>
<a href="<?=_SITE_URL_?>">Anasayfa</a>
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
        <?php
        if ($musteri) {
        ?>
        <tr>
            <td>Müşterinizin adı</td>
            <td><?=$musteri["musteri_adisoyadi"]?></td>
        </tr>
        <tr>
            <td>Müşterinizin telefonu</td>
            <td><?=$musteri["musteri_telefon"]?></td>
        </tr>
        <tr>
            <td>Müşterinizin adresi</td>
            <td><?=$musteri["musteri_adres"]?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <form action="?tamamla=true" method="POST">
                    Alınan ücret: <input type="text" name="alinan_ucret" id="">
                    <button>İşi Tamamla</button>
                </form>
            </td>
        </tr>
        <?php
        }
        ?>
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
<script>
    setInterval(function(){
        location.reload();
    }, 10000);
</script>