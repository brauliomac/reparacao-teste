<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);
} else {
    die("ID da solicitação não informado.");
}

// Verifica se ainda há peças faltantes
$sqlCheck = "SELECT SUM(quantity_missing) AS total_missing FROM request_parts WHERE request_id = $request_id";
$resultCheck = $conn->query($sqlCheck);
$total_missing = 0;
if ($resultCheck && $row = $resultCheck->fetch_assoc()) {
    $total_missing = intval($row['total_missing']);
}
if ($total_missing > 0) {
    die("Não é possível montar. Faltam peças.");
}

// Atualiza o status da solicitação para "finished"
$sqlUpdate = "UPDATE requests SET status='mounted' WHERE id = $request_id";
if ($conn->query($sqlUpdate) === TRUE) {
    header("Location: comprovante_montagem.php?id=" . $request_id);
    exit;
} else {
    echo "Erro ao finalizar montagem: " . $conn->error;
}
?>
