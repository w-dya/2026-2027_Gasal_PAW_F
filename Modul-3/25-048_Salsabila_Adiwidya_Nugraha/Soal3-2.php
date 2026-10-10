<?php
function tampilAsosiatif($nama, $data) {
    $daftar = array();
    foreach ($data as $kunci => $nilai) {
        $daftar[] = '"' . $kunci . '"=>"' . $nilai . '"';
    }
    echo $nama . " = (" . implode(", ", $daftar) . ")<br>";
}

$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

tampilAsosiatif("weight", $weight);
echo "Data kedua: " . $weight["Barry"];
?>
