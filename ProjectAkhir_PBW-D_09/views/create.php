<?php
require_once '../auth.php';
if (!isLoggedIn()) header('Location: login.php');
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $due_date, $status]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 25px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .dark-mode {
            background-color: #1e1e1e !important;
            color: #f1f1f1;
        }

        .dark-mode .form-container {
            background-color: #2c2c2c;
            color: white;
        }

        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #333;
            color: white;
            border-color: #555;
        }

        .dark-toggle {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 999;
        }
    </style>
</head>
<body>
   

    <div class="form-container">
        <h3 class="mb-4">Tambah Tugas Baru</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Tanggal Jatuh Tempo</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending">Belum</option>
                    <option value="completed">Selesai</option>
                    <option value="priority">Prioritas</option>
                </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        function toggleDarkMode() {
            const isDark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
            }
        });
    </script>
</body>
</html>