<?php
    if (isset($_POST["musteri_adisoyadi"]) && isset($_POST["musteri_telefon"]) && isset($_POST["musteri_adres"])) {
        require './database.php';

        $query = $db->query("SELECT id, tc FROM sofor WHERE aktif = '0'", PDO::FETCH_ASSOC);

        if ($query->rowCount() > 0) {
            $sofor = $query->fetch();

            $araba = $db->prepare("SELECT * FROM arac WHERE sofor_id = ?");
            $araba->execute([$sofor["id"]]);

            if ($araba->rowCount() > 0) {
                // arabası varsa
                $db->prepare("UPDATE sofor SET aktif = ? WHERE id = ?")->execute(["1", $sofor["id"]]);

                $insert = $db->prepare("INSERT INTO cagri SET sofor_id = ?, musteri_adisoyadi = ?, musteri_telefon = ?, musteri_adres = ?, aktif = ?");
                $insert = $insert->execute([
                    $sofor["id"],
                    $_POST["musteri_adisoyadi"],
                    $_POST["musteri_telefon"],
                    $_POST["musteri_adres"],
                    1
                ]);
                
                if ($insert) {
                    echo "Araç yola çıkmıştır";
                }
                else {
                    echo "Taksi çağrılırken bir sorun oluştu";
                }   
            }
            else {
                // arabası yoksa
                $araba = $db->prepare("SELECT plaka FROM arac WHERE sofor_id IS NULL")->execute([$sofor["id"]])->fetch();
                if (!$araba) {
                    echo "Boşta aracımız yoktur";
                }
                else {
                    // o soför'e araç tahsis edilir
                    $db->prepare("UPDATE arac SET sofor_id = ? WHERE plaka = ?")->execute([$sofor["id"]], $araba["plaka"]);

                    // araba atandığı için soför yola çıkmaya hazır
                    $db->prepare("UPDATE sofor SET aktif = ? WHERE id = ?")->execute(["1", $sofor["id"]]);

                    echo "Araç yola çıkmıştır";
                }
            }
        }
        else {
            echo "Boşta aracımız yoktur";
        }
    }

?>
<h2>Taksi Çağır</h2>

<form action="" method="POST">
    <table>
        <tbody>
            <tr>
                <td>İsminiz</td>
                <td><input type="text" name="musteri_adisoyadi" id=""></td>
            </tr>
            <tr>
                <td>Telefonunuz</td>
                <td><input type="text" name="musteri_telefon" id=""></td>
            </tr>
            <tr>
                <td>Adresiniz</td>
                <td><input type="text" name="musteri_adres" id=""></td>
            </tr>
            <tr>
                <td></td>
                <td><button>Ekle</button></td>
            </tr>
        </tbody>
    </table>
</form>