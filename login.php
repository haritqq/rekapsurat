<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    if(mysqli_num_rows($cek) > 0){
        $data = mysqli_fetch_assoc($cek);
        $_SESSION['status'] = "login";
        $_SESSION['nama'] = $data['nama']; // Opsional: simpan nama user
        header("location:index.php");
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Arsip Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            background: #ffffff;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
            border-color: #4e73df;
        }
        .login-icon {
            font-size: 3rem;
            color: #4e73df;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="login-card p-5 shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="text-center">
            <div class="login-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <h4 class="fw-bold text-gray-900">Selamat Datang</h4>
            <p class="text-muted mb-4">Silakan masuk ke akun Anda</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger d-flex align-items-center py-2" role="alert" style="font-size: 0.85rem;">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div><?= $error; ?></div>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">USERNAME</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control border-start-0" placeholder="Masukkan username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">PASSWORD</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="••••••••" required>
                    <button class="btn btn-outline-light border border-start-0 text-muted" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 mb-3">
                MASUK <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
        </form>
        
        <div class="text-center">
            <small class="text-muted">E-Arsip Digital &copy; <?= date('Y'); ?></small>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle ikon mata
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>