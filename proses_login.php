<?php
session_start();
include('config/koneksi.php');

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = MD5('$password')";
    $data  = mysqli_query($conn, $query);

    if (mysqli_num_rows($data) > 0) {
        $_SESSION['user']   = $username;
        $_SESSION['status'] = "login";

        // Remember Me: simpan username di cookie selama 30 hari
        if (isset($_POST['remember'])) {
            setcookie("user_cookie", $username, time() + (30 * 24 * 3600), "/");
        } else {
            setcookie("user_cookie", "", time() - 3600, "/");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: index.php?pesan=gagal");
        exit();
    }
}
header("Location: index.php");
exit();