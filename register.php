<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Cek password match
    if($password !== $password2) {
        $alert = '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Password tidak sama!
                    </div>
                </div>';
    } else {
        // Cek nama sudah ada
        $cek_nama = mysqli_query($koneksi, "SELECT * FROM admin WHERE nama = '$nama'");
        if(mysqli_num_rows($cek_nama) > 0) {
            $alert = '<div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            Nama sudah terdaftar!
                        </div>
                    </div>';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin (nama, password) VALUES ('$nama', '$password')";

            if (mysqli_query($koneksi, $sql)) {
                $alert = '<div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Registrasi berhasil!
                            </div>
                        </div>';
                header("refresh:2;url=login.php");
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                Registrasi gagal!
                            </div>
                        </div>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register Admin</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Register Admin</h4></div>

              <div class="card-body">
                <?php if(isset($alert)) echo $alert; ?>
                <form method="POST">
                  <div class="row">
                    <div class="form-group col-12">
                      <label for="nama">Nama</label>
                      <input id="nama" type="text" class="form-control" name="nama" required autofocus>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12">
                      <label for="password2" class="d-block">Konfirmasi Password</label>
                      <input id="password2" type="password" class="form-control" name="password2" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">Saya setuju dengan syarat dan ketentuan</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Sudah punya akun? <a href="login.php">Login</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; Kelompok 6
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
