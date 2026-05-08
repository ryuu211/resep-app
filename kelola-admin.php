<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Tambah admin baru
if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $password = MD5($_POST['password']);
    $nama_admin = $_POST['nama_admin'];

    mysqli_query($conn,
        "INSERT INTO admin (username, password, nama_admin)
        VALUES ('$username','$password','$nama_admin')"
    );
    header("Location: kelola-admin.php");
}

// Hapus admin
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM admin WHERE id_admin='$id'");
    header("Location: kelola-admin.php");
}

$admins = mysqli_query($conn, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Admin</title>
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

    <h1>👤 Kelola Admin</h1>

    <div class="card">
        <h3>Tambah Admin Baru</h3>
        <form method="POST">
            <label>Nama Admin</label><br>
            <input type="text" name="nama_admin" required>
            <br><br>
            <label>Username</label><br>
            <input type="text" name="username" required>
            <br><br>
            <label>Password</label><br>
            <input type="password" name="password" required>
            <br><br>
            <button type="submit" name="tambah">Tambah</button>
        </form>
    </div>

    <div class="card">
        <h3>Daftar Admin</h3>
        <table width="100%" cellpadding="10">
            <tr>
                <th align="left">Nama</th>
                <th align="left">Username</th>
                <th align="left">Aksi</th>
            </tr>
            <?php while($a = mysqli_fetch_assoc($admins)): ?>
            <tr>
                <td><?php echo $a['nama_admin']; ?></td>
                <td><?php echo $a['username']; ?></td>
                <td>
                    <?php if($_SESSION['role'] == 'superadmin' && $a['username'] != $_SESSION['username']): ?>
                    <a href="kelola-admin.php?hapus=<?php echo $a['id_admin']; ?>"
                    onclick="return confirm('Yakin ingin menghapus admin ini?')"
                    class="btn-hapus">Hapus</a>
                    <?php else: ?>
                    <small style="color:gray">Akun aktif</small>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>