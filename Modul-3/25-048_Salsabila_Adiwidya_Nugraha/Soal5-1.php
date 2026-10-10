<?php
function tampilStudents($data) {
    $daftar = array();
    foreach ($data as $baris) {
        $daftar[] = '("' . implode('", "', $baris) . '")';
    }
    echo "students = (<br>" . implode(",<br>", $daftar) . "<br>)<br>";
}

$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
tampilStudents($students);
echo "<br>";

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

echo "Data setelah ditambah 5 data lain:<br>";
tampilStudents($students);
echo "<br>";

echo "<table border='1'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";
foreach ($students as $baris) {
    echo "<tr>";
    echo "<td>" . $baris[0] . "</td>";
    echo "<td>" . $baris[1] . "</td>";
    echo "<td>" . $baris[2] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
