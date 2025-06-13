<?php
require_once '../auth.php';
if (!isLoggedIn()) header('Location: login.php');
require_once '../db.php';

$stmt = $pdo->prepare("
    SELECT * FROM tasks 
    WHERE user_id = ? 
    ORDER BY 
        FIELD(status, 'priority', 'pending', 'completed'),
        due_date ASC
");
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

function statusBadge($status)
{
    switch ($status) {
        case 'completed':
            return '<span class="badge bg-success">Selesai</span>';
        case 'priority':
            return '<span class="badge bg-danger">Prioritas</span>';
        default:
            return '<span class="badge bg-warning text-dark">Belum</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            min-height: 100vh;
            padding: 30px;
            font-family: 'Segoe UI', sans-serif;
            transition: background 0.4s, color 0.4s;
        }

        .dashboard-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            max-width: 1000px;
            margin: auto;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .dashboard-container.show {
            opacity: 1;
            transform: translateY(0);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-sm i {
            margin-right: 5px;
        }

        .btn-logout {
            float: right;
        }

        /* ===== Dark Mode ===== */
        body.dark {
            background: #1e1e1e !important;
            color: #f1f1f1;
        }

        body.dark .dashboard-container {
            background-color: #2c2c2c;
            color: white;
        }

        body.dark .table {
            color: #e1e1e1;
            border-color: #555;
        }

        body.dark .table-hover tbody tr:hover {
            background-color: #3a3a3a;
        }

        body.dark .table thead {
            background-color: #3c3c3c;
            color: white;
        }

        body.dark .btn {
            color: white;
        }

        body.dark .btn-secondary {
            background-color: #444;
            border-color: #666;
        }

        body.dark .btn-secondary:hover {
            background-color: #555;
        }

        body.dark .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        body.dark .btn-danger {
            background-color: #dc3545;
        }

        body.dark .btn-success {
            background-color: #198754;
        }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.body.classList.add('dark');
        }

        document.getElementById('dashboardBox').classList.add('show');
    });
    </script>
</head>
<body>

    <div class="dashboard-container" id="dashboardBox">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?></h2>
            <a href="../logout.php" class="btn btn-secondary btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

        <a href="create.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Tugas
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= $task['due_date'] ?></td>
                            <td><?= statusBadge($task['status']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $task['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($tasks)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada tugas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>