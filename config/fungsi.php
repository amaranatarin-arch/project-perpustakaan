<?php
// Array daftar kategori buku
$daftar_kategori = array("Teknologi", "Sains", "Novel", "Sejarah", "Bisnis", "Pendidikan");

// Percabangan if-else: status berdasarkan stok
function tentukan_status($stok) {
    if ($stok > 0) {
        return "Tersedia";
    } else {
        return "Dipinjam";
    }
}

// Percabangan switch: warna badge sesuai status
function warna_badge($status) {
    switch ($status) {
        case "Tersedia":
            return "success";
        case "Dipinjam":
            return "danger";
        default:
            return "secondary";
    }
}

// Tampilkan pesan lalu kembali ke halaman sebelumnya
function kembali_dengan_pesan($pesan) {
    echo "<script>alert('" . addslashes($pesan) . "'); history.back();</script>";
    exit();
}

// Operasi upload file (materi 10.1) + validasi tipe dan ukuran (maks 2MB)
function upload_sampul($file) {
    $namaFile   = $file['name'];
    $tmpName    = $file['tmp_name'];
    $ukuranFile = $file['size'];
    $error      = $file['error'];
    $dirTujuan  = "uploads/";
    $ekstensiBoleh = array("jpg", "jpeg", "png");
    $ukuranMaks    = 2 * 1024 * 1024;

    if ($error === 4) {
        return array('sukses' => false, 'nama' => '', 'pesan' => 'Sampul buku wajib diupload.');
    }
    if ($error === 1 || $error === 2) {
        return array('sukses' => false, 'nama' => '', 'pesan' => 'Ukuran file maksimal 2MB.');
    }
    if ($error !== 0) {
        return array('sukses' => false, 'nama' => '', 'pesan' => 'Terjadi kesalahan saat mengunggah file.');
    }
    if ($ukuranFile > $ukuranMaks) {
        return array('sukses' => false, 'nama' => '', 'pesan' => 'Ukuran file maksimal 2MB.');
    }

    $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensiBoleh)) {
        return array('sukses' => false, 'nama' => '', 'pesan' => 'File harus berekstensi .jpg atau .png.');
    }
    if (@getimagesize($tmpName) === false) {
        return array('sukses' => false, 'nama' => '', 'pesan' => 'Isi file bukan gambar yang valid.');
    }

    // Buat folder jika belum ada
    if (!is_dir($dirTujuan)) {
        mkdir($dirTujuan, 0777, true);
    }

    // Nama baru unik agar tidak menimpa file lain
    $namaBaru   = time() . "_" . rand(100, 999) . "." . $ekstensi;
    $pathTujuan = $dirTujuan . $namaBaru;

    // Pindahkan file dari folder sementara ke folder tujuan
    if (move_uploaded_file($tmpName, $pathTujuan)) {
        return array('sukses' => true, 'nama' => $namaBaru, 'pesan' => '');
    }
    return array('sukses' => false, 'nama' => '', 'pesan' => 'Gagal mengunggah file.');
}

// Hapus file gambar dari folder uploads
function hapus_sampul($nama) {
    $path = "uploads/" . basename($nama);
    if ($nama != "" && file_exists($path)) {
        unlink($path);
    }
}