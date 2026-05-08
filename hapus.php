<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id = $_GET['id'];

$hapus = mysqli_query($conn,
    "DELETE FROM resep
    WHERE id_resep='$id'"
);

if($hapus){
    header("Location: index.php");
} else {
    echo "Gagal menghapus data";
}
?>