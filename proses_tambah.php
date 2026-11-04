<?php
include('config/cek_session.php');
include('config/koneksi.php');
include('config/fungsi.php');

if (isset($_POST['simpan'])) {
    $judul    = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $penulis  = mysqli_real_escape_string($conn, trim($_POST['penulis']));
    $tahun    = (int)$_POST['tahun_terbit'];
    $stok     = (int)$_POST['stok'];

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

    // Percabangan status dari stok
    $status = tentukan_status($stok);

    // Upload sampul (validasi tipe dan ukuran ada di fungsi upload_sampul)
    $hasil = upload_sampul($_FILES['sampul']);
    if (!$hasil['sukses']) {
        kembali_dengan_pesan($hasil['pesan']);
    }
    $sampul = $hasil['nama'];

    $query = "INSERT INTO buku (judul, kategori, penulis, tahun_terbit, stok, status, sampul)
              VALUES ('$judul', '$kategori', '$penulis', '$tahun', '$stok', '$status', '$sampul')";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit();
    } else {
        hapus_sampul($sampul); // batalkan file jika query gagal
        kembali_dengan_pesan("Gagal menyimpan data.");
    }
}
header("Location: tambah_buku.php");
exit();