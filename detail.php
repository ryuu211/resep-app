<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT resep.*, kategori.nama_kategori 
FROM resep 
LEFT JOIN kategori ON resep.id_kategori = kategori.id_kategori 
WHERE resep.id_resep='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['kirim'])){
    $id_resep = $_POST['id_resep'];
    $nama_user = $_POST['nama_user'];
    $isi_komentar = $_POST['isi_komentar'];
    $tanggal = date('Y-m-d');

    mysqli_query($conn,
        "INSERT INTO komentar (id_resep, nama_user, isi_komentar, tanggal)
        VALUES ('$id_resep','$nama_user','$isi_komentar','$tanggal')"
    );
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Resep</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    🍳 Resep Makanan
    <a href="index.php">Beranda</a>

    <?php if(isset($_SESSION['username'])): ?>
    <a href="tambah.php">Tambah Resep</a>
    <a href="kelola-admin.php">Kelola Admin</a>
    <a href="logout.php" class="logout">Logout</a>
    <?php endif; ?>

</div>

<div class="container">

    <div class="card">

        <h1>
            <?php echo $data['nama_resep']; ?>
        </h1>

        <p>📂 <?php echo $data['nama_kategori']; ?></p>

        <hr>

        <img src="upload/<?php echo $data['gambar']; ?>" width="300">

        <h3>🥘 Bahan</h3>

        <p>
            <?php echo nl2br($data['bahan']); ?>
        </p>

        <h3>👨‍🍳 Langkah Memasak</h3>

        <p>
            <?php echo nl2br($data['langkah']); ?>
        </p>

        <br>

        <a href="index.php" class="btn">
            ← Kembali
        </a>

        <hr>

        <h3>💬 Komentar</h3>

        <form method="POST">
        <input type="hidden" name="id_resep" value="<?php echo $data['id_resep']; ?>">
    
        <label>Nama</label>
        <br>
        <input type="text" name="nama_user" required>
    
        <br><br>
    
        <label>Komentar</label>
        <br>
        <textarea name="isi_komentar" rows="3" required></textarea>
    
        <br><br>
    
        <button type="submit" name="kirim">Kirim Komentar</button>
        </form>

        <?php
        $komentar = mysqli_query($conn,
        "SELECT * FROM komentar WHERE id_resep='$id' ORDER BY tanggal DESC"
        );

        while($k = mysqli_fetch_assoc($komentar)){
           echo "
            <div class='komentar-box'>
                <strong>".$k['nama_user']."</strong>
                <small>".$k['tanggal']."</small>
                <p>".$k['isi_komentar']."</p>
            </div>
        ";
        }
        ?>

    </div>

</div>

</body>
</html>