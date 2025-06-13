<?php
require_once '../auth.php';
if (!isLoggedIn()) header('Location: login.php');
require_once '../db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

header('Location: dashboard.php');
exit;
?>
