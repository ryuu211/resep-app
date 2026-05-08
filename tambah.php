<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}


include 'koneksi.php';

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_resep'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $id_kategori = $_POST['id_kategori'];

    move_uploaded_file(
        $tmp,
        "upload/" . $gambar
    );

    $query = mysqli_query($conn,
        "INSERT INTO resep
        (nama_resep, bahan, langkah, gambar, id_kategori)
        VALUES
        ('$nama','$bahan','$langkah','$gambar','$id_kategori')"
        
    );

    if($query){
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan data";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Resep</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    🍳 Resep Makanan
    <a href="index.php">Beranda</a>
    <a href="tambah.php">Tambah Resep</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

    <h1>➕ Tambah Resep</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Resep</label>
        <br>
        <input type="text" name="nama_resep" required>

        <br><br>

        
        <label>Kategori</label>
        <br>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kat = mysqli_query($conn, "SELECT * FROM kategori");
            while($k = mysqli_fetch_assoc($kat)){
                echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>";
            }
            ?>
        </select>

        <br><br>


        <label>Bahan</label>
        <br>
        <textarea name="bahan" rows="5" required></textarea>

        <br><br>

        <label>Langkah</label>
        <br>
        <textarea name="langkah" rows="5" required></textarea>

        <br><br>

        <label>Gambar Resep</label>
        <br>
        <input type="file" name="gambar">

        <br><br>

        <button type="submit" name="simpan">
            Simpan
        </button>

    </form>

</div>

</body>
</html>