<?php
    session_start();

    require "./check_admin.php";

    require "../database.php";

    $query = $db->query("SELECT *, sofor.adisoyadi AS 'adisoyadi', sofor.tc AS 'tc' FROM rapor LEFT JOIN sofor ON rapor.sofor_id = sofor.id");

    $raporlar = $query->fetchAll();

?>
<?php require 'view_header.php';?>
<a href="<?=_SITE_URL_."admin"?>">Admin</a>
<h3>Tüm Şoförler</h3>
<table border="1">
    <tbody>
        <tr>
            <th>Soför TC</th>
            <th>Soför Adı</th>
            <th>Araç plakası</th>
            <th>tarih</th>
            <th>Kazanç</th>
        </tr>
        <?php
            foreach ($raporlar as $key => $value) {
                ?>
                <tr>
                    <td><?=$value["tc"]?></td>
                    <td><?=$value["adisoyadi"]?></td>
                    <td><?=$value["arac_plaka"]?></td>
                    <td><?=$value["tarih"]?></td>
                    <td><?=$value["kazanc"]?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>