<?php
    $database = "mysql";
    $host = "localhost";
    $user = "root";
    $password = "";
    $charset = "utf8";

    $databaseName = "bitaxi";
    try {
        $db = new PDO("$database:host=$host;dbname=$databaseName;charset=$charset", $user, $password);
    }
    catch (PDOException $e) {
        echo "Veritabanı bağlantısında sorun olıuştu<br/>";
        echo "Hata kodu:";
        print $e->getMessage();

        die();
    }

?>