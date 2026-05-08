<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "resep-app"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>