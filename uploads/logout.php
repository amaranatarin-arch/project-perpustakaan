<?php
session_start();
session_unset();
session_destroy(); // Menghapus seluruh session

// Hapus cookie (waktu kedaluwarsa di masa lalu)
setcookie("user_cookie", "", time() - 3600, "/");

header("Location: index.php?pesan=logout");
exit();