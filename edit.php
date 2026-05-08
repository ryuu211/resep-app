<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
    "SELECT * FROM resep WHERE id_resep='$id'"
);

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nama = $_POST['nama_resep'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $id_kategori = $_POST['id_kategori'];

if(!empty($_FILES['gambar']['name'])){
    $gambar = $_FILES['gambar']['name'];
     move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/" . $gambar);
} else {
    $gambar = $data['gambar']; // pakai gambar lama
}

    $update = mysqli_query($conn,
        "UPDATE resep SET
        nama_resep='$nama',
        bahan='$bahan',
        langkah='$langkah',
        gambar='$gambar',
        id_kategori='$id_kategori'
        WHERE id_resep='$id'"
    );

    if($update){
        header("Location: index.php");
    } else {
        echo "Gagal update data";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Resep</title>
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

    <h1>✏️ Edit Resep</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Resep</label>
        <br>
        <input
            type="text"
            name="nama_resep"
            value="<?php echo $data['nama_resep']; ?>"
            required
        >

        <br><br>

        <label>Kategori</label>
        <br>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kat = mysqli_query($conn, "SELECT * FROM kategori");
            while($k = mysqli_fetch_assoc($kat)){
                $selected = ($k['id_kategori'] == $data['id_kategori']) ? 'selected' : '';
                    echo "<option value='".$k['id_kategori']."' $selected>".$k['nama_kategori']."</option>";
            }
            ?>
        </select>

        <br><br>

        <label>Bahan</label>
        <br>
        <textarea
            name="bahan"
            rows="5"
            required
        ><?php echo $data['bahan']; ?></textarea>

        <br><br>

        <label>Langkah</label>
        <br>
        <textarea
            name="langkah"
            rows="5"
            required
        ><?php echo $data['langkah']; ?></textarea>

        <br><br>

        <button type="submit" name="update">
            Update
        </button>

        <label>Gambar Resep</label>
        <br>
        <img src="upload/<?php echo $data['gambar']; ?>" width="150">
        <br>
        <input type="file" name="gambar" accept="image/*">
        <small>Kosongkan jika tidak ingin mengganti gambar.</small>
        <br><br>

    </form>

</div>

</body>
</html>