<?php
    require './config.php';
    session_start();
    //isset ile taksici oturum açmış mı değerini getiriyorum sonrada oturum açmış mı kontrol ediyorum
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
<?php require 'view_header.php';?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Taksici Giriş</title>
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
        width:370px;
        height:300px;
        background: rgba(0,0,0,0.65);
        color:#fff;
        top :50%;
        left : 50%;
        position:absolute;
        transform:translate(-50%,-50%);
        box-sizing:border-box;
        padding: 70px 30px;
        border-radius:7%;
    }
    .avatar{
        width:100px;
        height:100px;
        border-radius:50%;
        position:absolute;
        top :-50px;
        left:calc(50% - 10%);
    }
    h1{
       
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
       margin-left:135px;
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
<div  class="login">
    <img src="driver.png" class="avatar">
    <h1>Taksici Giriş</h1>
<table>
    <tbody>
        <tr>
            <td><p>Şoför TC</p></td>
            <td><input type="text" name="sofor_tc" id="sofor_tc"></td>
        </tr>
        <tr>
            <td>Şifre</td>
            <td><input type="password" name="sofor_sifre" id="sofor_sifre"></td>
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
<a href="<?=_SITE_URL_?>">Anasayfa</a>
</div>
</body>
</html>

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