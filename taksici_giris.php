<?php
    require './config.php';
    session_start();

    if (isset($_SESSION["oturum_acti"]) && $_SESSION["oturum_acti"] == true) {
        header("Location: ". _SITE_URL_ ."taksici.php");
        die();
    }

    if(isset($_POST["sofor_tc"]) && isset($_POST["sofor_sifre"])){
        require './database.php';
        $query = $db->prepare("SELECT tc FROM sofor WHERE tc=? AND sifre=?");

        $query->execute([
            $_POST["sofor_tc"],
            md5($_POST["sofor_sifre"])
        ]);

        if ($query->rowCount() > 0) {
            $_SESSION["oturum_acti"] = true;
            $_SESSION["tc"] = $_POST["sofor_tc"];
            echo "Başarılı";
        }
        else {
            echo "Başarısız";
        }
        die();
    }
?>
<a href="<?=_SITE_URL_?>">Anasayfa</a>
<table>
    <tbody>
        <tr>
            <td>Şoför TC</td>
            <td><input type="text" name="sofor_tc" id="sofor_tc"></td>
        </tr>
        <tr>
            <td>Şifre</td>
            <td><input type="text" name="sofor_sifre" id="sofor_sifre"></td>
        </tr>
        <tr>
            <td></td>
            <td><button onclick="taksicigiris()">Giriş</button></td>
        </tr>
        <tr>
            <td></td>
            <td id="loginMessage"></td>
        </tr>
    </tbody>
</table>
<script>
    function taksicigiris() {
        var sofor_tc = document.getElementById('sofor_tc').value;
        var sofor_sifre = document.getElementById('sofor_sifre').value;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (xhttp.responseText == 'Başarılı')
                    location.reload();

                if (xhttp.responseText == 'Başarısız')
                    document.getElementById('loginMessage').innerText = 'Giriş başarısız';
            }
        };
        xhttp.open("POST", "", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
        xhttp.send('sofor_tc=' + sofor_tc + '&' +
                'sofor_sifre='        + sofor_sifre);
             
    }
</script>