<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resep Makanan</title>
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

    <h1>🍳Resep Makanan</h1>

<form method="GET">
    <input type="text" name="search" class="search-input" placeholder="Cari resep..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <button type="submit">Cari</button>
</form>

    <br><br>

    <?php

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query = mysqli_query($conn, "SELECT resep.*, kategori.nama_kategori 
    FROM resep 
    LEFT JOIN kategori ON resep.id_kategori = kategori.id_kategori 
    WHERE resep.nama_resep LIKE '%$search%'");

    while($data = mysqli_fetch_assoc($query)) {

    ?>

    <div class="card">

        <img 
        src="upload/<?php echo $data['gambar']; ?>">

        <h2>
            <?php echo $data['nama_resep']; ?>
        </h2>

        <small>
            📂 <?php echo $data['nama_kategori']; ?>
        </small>

        <p>
            <?php echo substr($data['bahan'], 0, 100); ?>...
        </p>

        <a href="detail.php?id=<?php echo $data['id_resep']; ?>" class="btn-detail">
            Detail
        </a>

        
        <?php if(isset($_SESSION['username'])): ?>
        
        |
        
        <a href="edit.php?id=<?php echo $data['id_resep']; ?>" class="btn-edit">
            Edit
        </a>

        |

        <a href="hapus.php?id=<?php echo $data['id_resep']; ?>"
        onclick="return confirm('Yakin ingin menghapus resep ini?')" class="btn-hapus">
            Hapus
        </a>
        <?php endif; ?>
    </div>

    <?php } ?>

</div>

</body>
</html>