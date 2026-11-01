<?php
function tampilUrut($label, $data) {
    echo "Hasil " . $label . ": ";
    foreach ($data as $kunci => $nilai) {
        echo $kunci . "=> " . $nilai . ", ";
    }
    echo "<br>";
}

$huruf = array("A");
array_push($huruf, "B");
echo 'Array awal: ("A")<br>';
echo "Hasil array_push: " . implode(" ", $huruf) . "<br><br>";

$gabung = array_merge(array("A", "B"), array("C"));
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo "Hasil array_merge: " . implode(" ", $gabung) . "<br><br>";

$asosiatif = array("x" => 1, "y" => 2);
$nilai = array_values($asosiatif);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: " . implode(" ", $nilai) . "<br><br>";

$cari = array("A", "B", "C");
$posisi = array_search("B", $cari);
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . $posisi . "<br><br>";

$campur = array(0, 1, false, 2, "", 3, "array");
$bersih = array_filter($campur);
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: " . implode(" ", $bersih) . "<br><br>";

$angka = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($angka);
echo "Hasil sort: " . implode(" ", $angka) . "<br>";
rsort($angka);
echo "Hasil rsort: " . implode(" ", $angka) . "<br><br>";

$age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';
asort($age);
tampilUrut("asort", $age);
ksort($age);
tampilUrut("ksort", $age);
arsort($age);
tampilUrut("arsort", $age);
krsort($age);
tampilUrut("krsort", $age);
?>
