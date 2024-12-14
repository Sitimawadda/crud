<?php
$koneksi = mysqli_connect("localhost","root","","mahasiswa");
if(!$koneksi){
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
