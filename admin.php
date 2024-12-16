<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Create - Tambah Admin
if(isset($_POST['tambah'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO admin (nama, password) VALUES ('$nama', '$password')";
    if(mysqli_query($koneksi, $query)) {
        $alert = '<div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Admin berhasil ditambahkan!
                    </div>
                </div>';
    }
}

// Read - Tampil Data Admin
$query_select = "SELECT * FROM admin";
$result = mysqli_query($koneksi, $query_select);

// Update - Edit Admin
if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);
    
    if(!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE admin SET nama = '$nama', password = '$password' WHERE id = $id";
    } else {
        $query = "UPDATE admin SET nama = '$nama' WHERE id = $id";
    }
    
    if(mysqli_query($koneksi, $query)) {
        $alert = '<div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Data admin berhasil diupdate!
                    </div>
                </div>';
    }
}

// Delete - Hapus Admin
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Cek jika admin yang akan dihapus sedang login
    if($id != $_SESSION['id']) {
        $query = "DELETE FROM admin WHERE id = $id";
        if(mysqli_query($koneksi, $query)) {
            $alert = '<div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            Admin berhasil dihapus!
                        </div>
                    </div>';
        }
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Tidak dapat menghapus akun yang sedang aktif!
                    </div>
                </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Data Admin</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  
  <style>
    .modal-backdrop {
        display: none;
    }
    .modal {
        background: rgba(0,0,0,0.5);
    }
  </style>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $_SESSION['nama']; ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Sidebar -->
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="dashboard.php">Dashboard</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="dashboard.php">DB</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a href="dashboard.php" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Menu</li>
            <li class="active">
              <a href="admin.php" class="nav-link"><i class="fas fa-users"></i> <span>Admin</span></a>
            </li>
            <li>
              <a href="datamahasiswa.php" class="nav-link"><i class="fas fa-user-graduate"></i> <span>Mahasiswa</span></a>
            </li>
            <li>
              <a href="jurusan.php" class="nav-link"><i class="fas fa-graduation-cap"></i> <span>Jurusan</span></a>
            </li>
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Data Admin</h1>
          </div>

          <?php if(isset($alert)) echo $alert; ?>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Daftar Admin</h4>
                  <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                      <i class="fas fa-plus"></i> Tambah Admin
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $row['nama'] ?></td>
                          <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>">
                              <i class="fas fa-edit"></i> Edit
                            </button>
                            <?php if($row['id'] != $_SESSION['id']) { ?>
                            <a href="admin.php?hapus=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')">
                              <i class="fas fa-trash"></i> Hapus
                            </a>
                            <?php } ?>
                          </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $row['id'] ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <form method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                  <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?= $row['nama'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label>Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" class="form-control" name="password">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                  <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Modal Tambah -->
      <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Admin</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
              <div class="modal-body">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 <div class="bullet"></div> Design By <a href="#">Your Name</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <script>
    // Auto dismiss alerts after 3 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 3000);

    // Refresh table data after modal actions
    $('#modalTambah, [id^=modalEdit]').on('hidden.bs.modal', function () {
        location.reload();
    });
  </script>
</body>
</html>
