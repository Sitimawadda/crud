<?php
session_start();
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="register-container bg-white">
            <div class="register-header">
                <h2>Register Mahasiswa</h2>
                <p class="text-muted">Buat akun baru</p>
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
                
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="register">Daftar</button>
                </div>
            </form>

            <div class="login-link">
                <p>Sudah punya akun? <a href="login.php" class="text-decoration-none">Login disini</a></p>
            </div>

            <?php
            if(isset($_POST['register'])) {
                $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                if($password === $confirm_password) {
                    $check_user = mysqli_query($koneksi, "SELECT * FROM user WHERE nama = '$nama'");
                    
                    if(mysqli_num_rows($check_user) == 0) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO user (nama, password, created_at) VALUES ('$nama', '$hashed_password', NOW())";
                        
                        if(mysqli_query($koneksi, $sql)) {
                            header("Location: login.php");
                            exit();
                        } else {
                            echo '<div class="alert alert-danger mt-3">Terjadi kesalahan saat mendaftar.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger mt-3">Username sudah terdaftar!</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger mt-3">Password tidak cocok!</div>';
                }
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
