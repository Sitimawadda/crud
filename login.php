<?php
session_start();
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="login-container bg-white">
            <div class="login-header">
                <h2>Login Mahasiswa</h2>
                <p class="text-muted">Silakan masuk ke akun Anda</p>
            </div>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nama" class="form-label">Username</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="login">Masuk</button>
                </div>
            </form>

            <div class="register-link">
                <p>Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar disini</a></p>
            </div>

            <?php
            if(isset($_POST['login'])) {
                $nama = $_POST['nama'];
                $password = $_POST['password'];

                $query = "SELECT * FROM user WHERE nama='$nama'";
                $result = mysqli_query($koneksi, $query);

                if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if(password_verify($password, $row['password'])) {
                        $_SESSION['user'] = $row['nama'];
                        $_SESSION['user_id'] = $row['id'];
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo '<div class="alert alert-danger mt-3">Password salah!</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger mt-3">Username tidak ditemukan!</div>';
                }
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
