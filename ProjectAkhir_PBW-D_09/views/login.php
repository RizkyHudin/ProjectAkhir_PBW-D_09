<?php
require_once '../auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (login($_POST['username'], $_POST['password'])) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background 0.5s, color 0.5s;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .login-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .form-floating > .form-control {
            padding-left: 2.5rem;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .position-relative .form-floating {
            padding-left: 0;
        }

        .btn-primary {
            background-color: #4facfe;
            border-color: #00f2fe;
        }

        .btn-primary:hover {
            background-color: #00f2fe;
            border-color: #4facfe;
        }

        .btn-link {
            color: #00b894;
        }

        .btn-link:hover {
            color: #008080;
            text-decoration: underline;
        }

        body.dark-mode {
            background: #1e1e1e;
            color: #f1f1f1;
        }

        body.dark-mode .login-card {
            background-color: #2c2c2c;
            color: white;
        }

        body.dark-mode .form-control {
            background-color: #3a3a3a;
            color: white;
            border-color: #555;
        }

        .dark-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .form-label {
            margin-bottom: 0.3rem;
        }
    </style>

    <script>
        // Terapkan tema dari localStorage saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function () {
            const theme = localStorage.getItem("theme");
            if (theme === "dark") {
                document.body.classList.add("dark-mode");
            }
        });

        // Fungsi toggle dan simpan tema ke localStorage
        function toggleDarkMode() {
            const isDark = document.body.classList.toggle("dark-mode");
            localStorage.setItem("theme", isDark ? "dark" : "light");
        }
    </script>
</head>
<body>

    <!-- Tombol mode gelap -->
    <button class="btn btn-sm btn-dark dark-toggle" onclick="toggleDarkMode()">
        <i class="fas fa-moon"></i>
    </button>

    <div class="login-card" id="loginCard">
        <h3 class="mb-4 text-center">Login Agenda Planner</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-floating mb-3 position-relative">
                <input name="username" class="form-control" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input name="password" type="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary">Login</button>
                <a href="../register.php" class="btn btn-link">Daftar</a>
            </div>
        </form>
    </div>

    <script>
        // Tampilkan login card dengan animasi
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("loginCard").classList.add("show");
        });
    </script>
</body>
</html>