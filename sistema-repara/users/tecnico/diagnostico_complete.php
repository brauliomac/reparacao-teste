<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);
    // Atualiza o status para "diagnosed", indicando que o diagnóstico foi concluído
    $sql = "UPDATE requests SET status='diagnosed' WHERE id = $request_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: technician_dashboard.php");
        exit;
    } else {
        echo "Erro ao atualizar o status: " . $conn->error;
    }
} else {
    echo "ID da solicitação não informado.";
}
?>
