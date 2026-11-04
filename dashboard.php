<?php
include('config/cek_session.php');
include('config/koneksi.php');
include('config/fungsi.php');

$data = mysqli_query($conn, "SELECT * FROM buku ORDER BY id DESC");

// Statistik ringkas
$stat = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total, COALESCE(SUM(stok > 0), 0) AS tersedia FROM buku"));
$total     = (int)$stat['total'];
$tersedia  = (int)$stat['tersedia'];
$dipinjam  = $total - $tersedia;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - Mini Digital Library</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4"><div class="container">
  <span class="navbar-brand">Mini Digital Library</span>
  <span class="text-white">Halo, <?php echo htmlspecialchars($_SESSION['user']); ?>
    <a href="logout.php" class="btn btn-light btn-sm ms-2">Logout</a></span>
</div></nav>

<div class="container pb-5">
  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card"><div class="card-body">
      <div class="text-muted">Total Buku</div><h3><?php echo $total; ?></h3></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
      <div class="text-muted">Tersedia</div><h3><?php echo $tersedia; ?></h3></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
      <div class="text-muted">Dipinjam</div><h3><?php echo $dipinjam; ?></h3></div></div></div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar Buku</h4>
    <a href="tambah_buku.php" class="btn btn-primary">+ Tambah Buku</a>
  </div>

  <div class="table-responsive">
  <table class="table table-bordered align-middle">
    <tr class="table-light">
      <th>No</th><th>Sampul</th><th>Judul</th><th>Kategori</th><th>Penulis</th>
      <th>Tahun</th><th>Stok</th><th>Status</th><th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
        $status = tentukan_status($row['stok']);
    ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td>
        <?php if ($row['sampul'] != "" && file_exists("uploads/" . $row['sampul'])) { ?>
          <img src="uploads/<?php echo $row['sampul']; ?>" class="sampul-img" alt="Sampul">
        <?php } else { ?>
          <div class="sampul-kosong">Tanpa sampul</div>
        <?php } ?>
      </td>
      <td><?php echo htmlspecialchars($row['judul']); ?></td>
      <td><?php echo htmlspecialchars($row['kategori']); ?></td>
      <td><?php echo htmlspecialchars($row['penulis']); ?></td>
      <td><?php echo $row['tahun_terbit']; ?></td>
      <td><?php echo $row['stok']; ?></td>
      <td><span class="badge bg-<?php echo warna_badge($status); ?>"><?php echo $status; ?></span></td>
      <td class="text-nowrap">
        <a href="edit_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="hapus_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin hapus buku ini beserta file sampulnya?')">Hapus</a>
      </td>
    </tr>
    <?php } ?>
    <?php if ($total == 0) { ?>
      <tr><td colspan="9" class="text-center">Belum ada data buku.</td></tr>
    <?php } ?>
  </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>