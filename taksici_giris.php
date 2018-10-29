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
            header("Location: ". _SITE_URL_ ."taksici.php");
            die();
        }
        else {
            echo "Başarısız";
        }
    }
?>
<form action="" method="POST">
    <table>
        <tbody>
            <tr>
                <td>Şoför TC</td>
                <td><input type="text" name="sofor_tc" id=""></td>
            </tr>
            <tr>
                <td>Şifre</td>
                <td><input type="text" name="sofor_sifre" id=""></td>
            </tr>
            <tr>
                <td></td>
                <td><button>Giriş</button></td>
            </tr>
        </tbody>
    </table>
</form>