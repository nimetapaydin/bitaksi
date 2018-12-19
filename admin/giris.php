<?php
    session_start();
    require '../config.php';

    if (isset($_SESSION["isadmin"]) && $_SESSION["isadmin"] == true) {
        header("Location: ". _SITE_URL_ ."admin");
        die();
    }

    if (isset($_POST["email"]) && isset($_POST["sifre"])) {
        require '../database.php';

        $query = $db->prepare("SELECT * FROM admin WHERE email=? AND sifre=?");

        $query->execute([
            $_POST["email"],
            md5($_POST["sifre"])
        ]);

        if ($query->rowCount() > 0) {
            $_SESSION["isadmin"] = true;
            $_SESSION["admin_email"] = $_POST["email"];
            header("Location: ". _SITE_URL_ ."admin");
            die();
        }
        else {
            echo "Giriş Başarısız";
        }
    }
?>
<?php require 'view_header.php';?>
<div  class="login">
    <img src="../driver.png" class="avatar">
    <h1>Admin Giriş</h1>
    <form action="" method="POST">
        <table>
            <tbody>
                <tr>
                    <td>Admin email</td>
                    <td><input type="text" name="email" id=""></td>
                </tr>
                <tr>
                    <td>Şifre</td>
                    <td><input type="text" name="sifre" id=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>Giriş</button></td>
                </tr>
            </tbody>
        </table>
    </form>
</body>
</html>


