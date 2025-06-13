<?php
require_once 'db.php';
session_start();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Password tidak cocok.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = "Username sudah digunakan.";
        } else {
            $hash = hash('sha256', $password);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);
            $success = "Registrasi berhasil. Silakan <a href='views/login.php'>login</a>.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        .register-card {
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

        .register-card.show {
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

        /* === Dark Mode Styles === */
        body.dark-mode {
            background: #1e1e1e;
            color: #f1f1f1;
        }

        body.dark-mode .register-card {
            background-color: #2c2c2c;
            color: white;
        }

        body.dark-mode .form-control {
            background-color: #3a3a3a;
            color: white;
            border-color: #555;
        }

        body.dark-mode .form-control::placeholder {
            color: #bbb;
        }

        body.dark-mode .btn-primary {
            background-color: #4facfe;
            color: black;
        }

        body.dark-mode .btn-link {
            color: #00cec9;
        }

        body.dark-mode .btn-link:hover {
            color: #81ecec;
        }
    </style>

    <script>
        // Terapkan tema dark mode dari localStorage saat halaman dimuat
        document.addEventListener("DOMContentLoaded", () => {
            if (localStorage.getItem("theme") === "dark") {
                document.body.classList.add("dark-mode");
            }

            document.getElementById("registerCard").classList.add("show");
        });
    </script>
</head>
<body>

    <div class="register-card" id="registerCard">
        <h3 class="mb-4 text-center">Registrasi Agenda Planner</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-floating mb-3 position-relative">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="password" name="confirm" class="form-control" placeholder="Konfirmasi Password" required>
                <label for="confirm">Konfirmasi Password</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary">Daftar</button>
                <a href="views/login.php" class="btn btn-link">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>

</body>
</html>