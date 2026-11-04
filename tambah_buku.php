<?php
include('config/cek_session.php');
include('config/fungsi.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">
<div class="container" style="max-width:600px; margin:30px auto">
<div class="card"><div class="card-body">
<h4 class="mb-3">Tambah Buku</h4>

<form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
  <label>Judul Buku</label>
  <input type="text" name="judul" class="form-control mb-2" required>

  <label>Kategori</label>
  <select name="kategori" class="form-select mb-2" required>
    <?php foreach ($daftar_kategori as $k) { echo "<option>$k</option>"; } ?>
  </select>

  <label>Penulis</label>
  <input type="text" name="penulis" class="form-control mb-2" required>

  <label>Tahun Terbit</label>
  <input type="number" name="tahun_terbit" min="1000" max="<?php echo date('Y'); ?>" class="form-control mb-2" required>

  <label>Stok (Status Ketersediaan: 0 = Dipinjam, lebih dari 0 = Tersedia)</label>
  <input type="number" name="stok" min="0" value="1" class="form-control mb-2" required>

  <label>Sampul Buku (.jpg/.png, maksimal 2MB)</label>
  <input type="file" name="sampul" id="sampul" accept=".jpg,.jpeg,.png" class="form-control mb-2" required>
  <img id="preview" class="sampul-img mb-3 d-none" alt="Preview">

  <div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
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
    img.classList.add('d-none');
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