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
echo "<br>";

foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.<br>";
}
?>
