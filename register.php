<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek email sudah ada
    $cek_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($cek_email) > 0) {
        echo "<script>
                alert('Email sudah terdaftar!');
                window.location.href = 'register.php';
              </script>";
        exit();
    }

    $sql = "INSERT INTO users (nama, jurusan, email, password) 
            VALUES ('$nama', '$jurusan', '$email', '$password')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Registrasi berhasil!');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal!');
                window.location.href = 'register.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
    <style>
        .container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Register User</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <select name="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Manajemen Informatika">Manajemen Informatika</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Register</button>
        </form>
    </div>
</body>
</html>
