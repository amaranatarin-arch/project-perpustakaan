<?php
include('config/cek_session.php');
include('config/koneksi.php');
include('config/fungsi.php');

$id   = (int)$_GET['id']; // id dikirim via GET (materi 8.1)
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id = '$id'");
$row  = mysqli_fetch_assoc($data);

if (!$row) {
    header("Location: dashboard.php");
    exit();
}
$ada_sampul = ($row['sampul'] != "" && file_exists("uploads/" . $row['sampul']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">
<div class="container" style="max-width:600px; margin:30px auto">
<div class="card"><div class="card-body">
<h4 class="mb-3">Edit Buku</h4>

<form action="proses_edit.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

  <label>Judul Buku</label>
  <input type="text" name="judul" class="form-control mb-2"
         value="<?php echo htmlspecialchars($row['judul']); ?>" required>

  <label>Kategori</label>
  <select name="kategori" class="form-select mb-2" required>
    <?php foreach ($daftar_kategori as $k) { ?>
      <option <?php if ($row['kategori'] == $k) { echo "selected"; } ?>><?php echo $k; ?></option>
    <?php } ?>
  </select>

  <label>Penulis</label>
  <input type="text" name="penulis" class="form-control mb-2"
         value="<?php echo htmlspecialchars($row['penulis']); ?>" required>

  <label>Tahun Terbit</label>
  <input type="number" name="tahun_terbit" min="1000" max="<?php echo date('Y'); ?>"
         class="form-control mb-2" value="<?php echo $row['tahun_terbit']; ?>" required>

  <label>Stok (Status Ketersediaan: 0 = Dipinjam, lebih dari 0 = Tersedia)</label>
  <input type="number" name="stok" min="0" class="form-control mb-2"
         value="<?php echo $row['stok']; ?>" required>

  <label>Sampul Buku</label><br>
  <img id="preview" class="sampul-img mb-2 <?php if (!$ada_sampul) { echo 'd-none'; } ?>"
       src="<?php echo $ada_sampul ? 'uploads/' . $row['sampul'] : ''; ?>" alt="Sampul"><br>
  <input type="file" name="sampul" id="sampul" accept=".jpg,.jpeg,.png" class="form-control mb-1">
  <div class="form-text mb-3">Kosongkan jika tidak ingin mengganti sampul (.jpg/.png, maksimal 2MB).</div>

  <div>
    <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
    <a href="dashboard.php" class="btn btn-secondary">Batal</a>
  </div>
</form>
</div></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('sampul').addEventListener('change', function () {
  var file = this.files[0];
  var img = document.getElementById('preview');
  if (file && file.size > 2 * 1024 * 1024) {
    alert('Ukuran file maksimal 2MB');
    this.value = '';
    return;
  }
  if (file) {
    img.src = URL.createObjectURL(file);
    img.classList.remove('d-none');
  }
});
</script>
</body>
</html>