<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    die("ID do usuário não informado.");
}

// Evita que o administrador exclua seu próprio usuário
if ($user_id == $_SESSION['user_id']) {
    die("Você não pode excluir o seu próprio usuário.");
}

$sql = "DELETE FROM users WHERE id = $user_id";
if ($conn->query($sql) === TRUE) {
    header("Location: admin_dashboard.php");
    exit;
} else {
    die("Erro ao excluir usuário: " . $conn->error);
}
?>
