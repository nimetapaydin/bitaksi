<?php
    session_start();

    require "./check_admin.php";

    require "../database.php";

    $query = $db->query("SELECT * FROM sofor");

    $soforler = $query->fetchAll();

?>
<a href="<?=_SITE_URL_."admin"?>">Admin</a>
<h3>Tüm Şoförler</h3>
<table border="1">
    <tbody>
        <tr>
            <th>TC</th>
            <th>İsim</th>
            <th>Maaş</th>
            <th>Aktif mi?</th>
        </tr>
        <?php
            foreach ($soforler as $key => $value) {
                ?>
                <tr>
                    <td><?=$value["tc"]?></td>
                    <td><?=$value["adisoyadi"]?></td>
                    <td><?=$value["maas"]?></td>
                    <td><?=$value["aktif"] == '1' ? "Evet" : "Hayır" ?></td>
                </tr>
                <?php
            }
        ?>
    </tbody>
</table>