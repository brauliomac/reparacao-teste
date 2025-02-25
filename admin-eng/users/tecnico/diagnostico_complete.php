<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_POST['pedido_id'])) {
    $pedido_id = intval($_POST['pedido_id']);
    // Atualiza o status para "diagnosticado", indicando que o diagnóstico foi concluído
    $sql = "UPDATE pedidos SET status='diagnosticado' WHERE id = $pedido_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: tecnico_solicitacao_pendente.php");
        exit;
    } else {
        echo "Erro ao atualizar o status: " . $conn->error;
    }
} else {
    echo "ID da solicitação não informado.";
}
?>
