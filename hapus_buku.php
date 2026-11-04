<?php
include('config/cek_session.php');
include('config/koneksi.php');
include('config/fungsi.php');

$id   = (int)$_GET['id'];
$data = mysqli_query($conn, "SELECT sampul FROM buku WHERE id = '$id'");
$row  = mysqli_fetch_assoc($data);

if ($row) {
    mysqli_query($conn, "DELETE FROM buku WHERE id = '$id'"); // hapus data di database
    hapus_sampul($row['sampul']);                              // hapus file gambar (unlink)
}
header("Location: dashboard.php");
exit();