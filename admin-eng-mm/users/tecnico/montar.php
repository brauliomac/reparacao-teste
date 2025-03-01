<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
$tecnico_id = $_SESSION['user_id'];

if (isset($_POST['pedido_id'])) {
    $pedido_id = intval($_POST['pedido_id']);
} else {
    die("ID da solicitação não informado.");
}

// Verifica se ainda há peças faltantes
$sqlCheck = "SELECT SUM(quantidade_em_falta) AS total_missing FROM pedido_partes WHERE pedido_id = $pedido_id";
$resultCheck = $conn->query($sqlCheck);
$total_missing = 0;
if ($resultCheck && $row = $resultCheck->fetch_assoc()) {
    $total_missing = intval($row['total_missing']);
}
if ($total_missing > 0) {
    die("Não é possível montar. Faltam peças.");
}

// Atualiza o status da solicitação para "finished"
$sqlUpdate = "UPDATE pedidos SET status='montado' WHERE id = $pedido_id";
$sqlTecnicoStatusUpdate = "UPDATE users SET status = 'disponivel' WHERE id = $tecnico_id";
if ($conn->query($sqlUpdate) === TRUE) {
    $conn->query($sqlTecnicoStatusUpdate);
    header("Location: comprovante_montagem.php?id=" . $pedido_id);
    exit;
} else {
    echo "Erro ao finalizar montagem: " . $conn->error;
}
?>
