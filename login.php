<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = MD5($_POST['password']);

    $query = mysqli_query($conn, 
        "SELECT * FROM admin WHERE username='$username' AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_assoc($query);
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_admin'] = $data['nama_admin'];
        $_SESSION['role'] = $data['role'];
        header("Location: index.php");
    } else {
        $error = "Username atau password salah!";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">

    <h1>🔐 Login Admin</h1>

    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST">

        <label>Username</label>
        <br>
        <input type="text" name="username" required>

        <br><br>

        <label>Password</label>
        <br>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit" name="login">Login</button>

    </form>

</div>

</body>
</html>