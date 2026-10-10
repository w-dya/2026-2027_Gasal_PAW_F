<?php
function tampilAsosiatif($nama, $data) {
    $daftar = array();
    foreach ($data as $kunci => $nilai) {
        $daftar[] = '"' . $kunci . '"=>"' . $nilai . '"';
    }
    echo $nama . " = (" . implode(", ", $daftar) . ")<br>";
}

$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
$kunci = array_keys($weight);
$jumlah = count($weight);

tampilAsosiatif("weight", $weight);
echo "<br>";

for ($i = 0; $i < $jumlah; $i++) {
    $nama = $kunci[$i];
    echo $nama . " is " . $weight[$nama] . " kg.<br>";
}
?>
