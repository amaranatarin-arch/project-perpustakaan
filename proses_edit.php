<?php
include('config/cek_session.php');
include('config/koneksi.php');
include('config/fungsi.php');

if (isset($_POST['ubah'])) {
    $id       = (int)$_POST['id'];
    $judul    = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $penulis  = mysqli_real_escape_string($conn, trim($_POST['penulis']));
    $tahun    = (int)$_POST['tahun_terbit'];
    $stok     = (int)$_POST['stok'];

    // Ambil sampul lama dari database
    $data = mysqli_query($conn, "SELECT sampul FROM buku WHERE id = '$id'");
    $lama = mysqli_fetch_assoc($data);
    if (!$lama) {
        header("Location: dashboard.php");
        exit();
    }

    // Validasi isian
    if ($judul == "" || $penulis == "") {
        kembali_dengan_pesan("Judul dan penulis wajib diisi.");
    }
    if (!in_array($kategori, $daftar_kategori)) {
        kembali_dengan_pesan("Kategori tidak valid.");
    }
    if ($tahun < 1000 || $tahun > (int)date("Y")) {
        kembali_dengan_pesan("Tahun terbit tidak valid.");
    }
    if ($stok < 0) {
        kembali_dengan_pesan("Stok tidak boleh negatif.");
    }

    $status = tentukan_status($stok);

    // Default: tetap pakai sampul lama
    $sampul     = $lama['sampul'];
    $ganti_file = false;

    // Ada file baru dipilih? (error 4 = tidak ada file)
    if ($_FILES['sampul']['error'] !== 4) {
        $hasil = upload_sampul($_FILES['sampul']);
        if (!$hasil['sukses']) {
            kembali_dengan_pesan($hasil['pesan']);
        }
        $sampul     = $hasil['nama'];
        $ganti_file = true;
    }

    $query = "UPDATE buku SET judul = '$judul', kategori = '$kategori', penulis = '$penulis',
              tahun_terbit = '$tahun', stok = '$stok', status = '$status', sampul = '$sampul'
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        if ($ganti_file) {
            hapus_sampul($lama['sampul']); // hapus file lama dari folder
        }
        header("Location: dashboard.php");
        exit();
    } else {
        if ($ganti_file) {
            hapus_sampul($sampul); // batalkan file baru jika query gagal
        }
        kembali_dengan_pesan("Gagal mengubah data.");
    }
}
header("Location: dashboard.php");
exit();