<?php
    session_start(); //php de oturum değerlerinin kullanılmasını sağlar

    require "./check_admin.php";

    require "../database.php";

    if (isset($_POST["onayla"])) {
        echo "geldi";
        $query = $db->prepare("UPDATE sofor SET onayli = '1' WHERE tc = ?");
        $query = $query->execute([
            $_POST["onayla"]
        ]);
    }

    $query = $db->query("SELECT * FROM sofor");

    $soforler = $query->fetchAll();

?>
<?php require 'view_header.php';?>
<a href="<?=_SITE_URL_."admin"?>">Admin</a>
<h3>Tüm Şoförler</h3>
<table border="1">
    <tbody>
        <tr>
            <th>TC</th>
            <th>İsim</th>
            <th>Aktif mi?</th>
            <th>Onayla</th>
        </tr>
        <?php
            foreach ($soforler as $key => $value) {
                ?>
                <tr>
                    <td><?=$value["tc"]?></td>
                    <td><?=$value["adisoyadi"]?></td>
                    <td><?=$value["aktif"] == '1' ? "Evet" : "Hayır" ?></td>
                    <td>
                        <?php
                            if ($value["onayli"] == '1') {
                                echo "Zaten onaylı";
                            }
                            else {
                                echo '<button onclick="onayla(\'' . $value["tc"] . '\')">Onayla</button>';
                            }
                        ?>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>

<script>
    function onayla(id) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        };
        xhttp.open("POST", "", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send("onayla=" + id);
        // yazılacak
    }
</script>