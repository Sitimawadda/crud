<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Create - Tambah Mahasiswa
if(isset($_POST['tambah'])) {
    $nim = htmlspecialchars($_POST['nim']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $nomer_telephone = htmlspecialchars($_POST['nomer_telephone']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $angkatan = htmlspecialchars($_POST['angkatan']);
    $id_jurusan = htmlspecialchars($_POST['id_jurusan']);

    $query = "INSERT INTO datamahasiswa (nim, nama_lengkap, email, nomer_telephone, alamat, angkatan, id_jurusan) 
              VALUES ('$nim', '$nama_lengkap', '$email', '$nomer_telephone', '$alamat', '$angkatan', '$id_jurusan')";
    
    if(mysqli_query($koneksi, $query)) {
        $alert = '<div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Data mahasiswa berhasil ditambahkan!
                    </div>
                </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Gagal menambahkan data mahasiswa!
                    </div>
                </div>';
    }
}

// Read - Tampil Data Mahasiswa dengan JOIN
$query_select = "SELECT dm.*, j.nama_jurusan 
                FROM datamahasiswa dm 
                JOIN jurusan j ON dm.id_jurusan = j.id_jurusan";
$result = mysqli_query($koneksi, $query_select);

// Get Data Jurusan untuk Select Option
$query_jurusan = "SELECT * FROM jurusan";
$jurusan_result = mysqli_query($koneksi, $query_jurusan);

// Update - Edit Mahasiswa
if(isset($_POST['edit'])) {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $nim = htmlspecialchars($_POST['nim']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $nomer_telephone = htmlspecialchars($_POST['nomer_telephone']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $angkatan = htmlspecialchars($_POST['angkatan']);
    $id_jurusan = htmlspecialchars($_POST['id_jurusan']);

    $query = "UPDATE datamahasiswa SET 
              nim = '$nim',
              nama_lengkap = '$nama_lengkap',
              email = '$email',
              nomer_telephone = '$nomer_telephone',
              alamat = '$alamat',
              angkatan = '$angkatan',
              id_jurusan = '$id_jurusan'
              WHERE id_mahasiswa = $id_mahasiswa";
    
    if(mysqli_query($koneksi, $query)) {
        $alert = '<div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Data mahasiswa berhasil diupdate!
                    </div>
                </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Gagal mengupdate data mahasiswa!
                    </div>
                </div>';
    }
}

// Delete - Hapus Mahasiswa
if(isset($_GET['hapus'])) {
    $id_mahasiswa = $_GET['hapus'];
    $query = "DELETE FROM datamahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    if(mysqli_query($koneksi, $query)) {
        $alert = '<div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Data mahasiswa berhasil dihapus!
                    </div>
                </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        Gagal menghapus data mahasiswa!
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
  <title>Data Mahasiswa</title>

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
            <li>
              <a href="admin.php" class="nav-link"><i class="fas fa-users"></i> <span>Admin</span></a>
            </li>
            <li class="active">
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
            <h1>Data Mahasiswa</h1>
          </div>

          <?php if(isset($alert)) echo $alert; ?>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Daftar Mahasiswa</h4>
                  <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                      <i class="fas fa-plus"></i> Tambah Mahasiswa
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Nama Lengkap</th>
                          <th>Email</th>
                          <th>No. Telepon</th>
                          <th>Alamat</th>
                          <th>Angkatan</th>
                          <th>Jurusan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $row['nim'] ?></td>
                          <td><?= $row['nama_lengkap'] ?></td>
                          <td><?= $row['email'] ?></td>
                          <td><?= $row['nomer_telephone'] ?></td>
                          <td><?= $row['alamat'] ?></td>
                          <td><?= $row['angkatan'] ?></td>
                          <td><?= $row['nama_jurusan'] ?></td>
                          <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['id_mahasiswa'] ?>">
                              <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="datamahasiswa.php?hapus=<?= $row['id_mahasiswa'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                              <i class="fas fa-trash"></i> Hapus
                            </a>
                          </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $row['id_mahasiswa'] ?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Edit Data Mahasiswa</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <form method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="id_mahasiswa" value="<?= $row['id_mahasiswa'] ?>">
                                  <div class="form-group">
                                    <label>NIM</label>
                                    <input type="text" class="form-control" name="nim" value="<?= $row['nim'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $row['nama_lengkap'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $row['email'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" class="form-control" name="nomer_telephone" value="<?= $row['nomer_telephone'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" required><?= $row['alamat'] ?></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label>Angkatan</label>
                                    <input type="number" class="form-control" name="angkatan" value="<?= $row['angkatan'] ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label>Jurusan</label>
                                    <select class="form-control" name="id_jurusan" required>
                                      <?php 
                                      mysqli_data_seek($jurusan_result, 0);
                                      while($jur = mysqli_fetch_assoc($jurusan_result)) { ?>
                                        <option value="<?= $jur['id_jurusan'] ?>" <?= ($row['id_jurusan'] == $jur['id_jurusan']) ? 'selected' : '' ?>><?= $jur['nama_jurusan'] ?></option>
                                      <?php } ?>
                                    </select>
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
              <h5 class="modal-title">Tambah Mahasiswa</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
              <div class="modal-body">
                <div class="form-group">
                  <label>NIM</label>
                  <input type="text" class="form-control" name="nim" required>
                </div>
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                  <label>No. Telepon</label>
                  <input type="text" class="form-control" name="nomer_telephone" required>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamat" required></textarea>
                </div>
                <div class="form-group">
                  <label>Angkatan</label>
                  <input type="number" class="form-control" name="angkatan" required>
                </div>
                <div class="form-group">
                  <label>Jurusan</label>
                  <select class="form-control" name="id_jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <?php 
                    mysqli_data_seek($jurusan_result, 0);
                    while($jur = mysqli_fetch_assoc($jurusan_result)) { ?>
                      <option value="<?= $jur['id_jurusan'] ?>"><?= $jur['nama_jurusan'] ?></option>
                    <?php } ?>
                  </select>
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
