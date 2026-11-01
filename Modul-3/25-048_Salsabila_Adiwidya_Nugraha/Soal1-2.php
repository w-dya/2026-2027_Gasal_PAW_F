<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

$dihapus = $fruits[1];
unset($fruits[1]);
$fruits = array_values($fruits);

$indeksTertinggi = count($fruits) - 1;

echo "Data " . $dihapus . " dihapus.<br>";
echo 'fruits = ( "' . implode('", "', $fruits) . '")<br>';
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeksTertinggi];
?>
