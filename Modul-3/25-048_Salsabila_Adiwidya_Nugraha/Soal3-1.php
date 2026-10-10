<?php
function tampilAsosiatif($nama, $data) {
    $daftar = array();
    foreach ($data as $kunci => $nilai) {
        $daftar[] = '"' . $kunci . '"=>"' . $nilai . '"';
    }
    echo $nama . " = (" . implode(", ", $daftar) . ")<br>";
}

$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

tampilAsosiatif("height", $height);
echo "Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

unset($height["Barry"]);

tampilAsosiatif("height", $height);
echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>
