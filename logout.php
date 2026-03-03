<?php
// Memulai session agar sistem tahu session mana yang akan dihapus
session_start();

// Menghapus semua variabel session
$_SESSION = array();

// Jika ingin benar-benar menghancurkan session, hapus juga cookie session-nya
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Menghancurkan session secara total di server
session_destroy();

// Mengarahkan pengguna kembali ke halaman login
header("location: login.php");
exit;
?>