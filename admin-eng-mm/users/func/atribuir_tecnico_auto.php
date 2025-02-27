<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} else {
    die("Solicitação inválida.");
}

$sql = "SELECT u.id, COUNT(r.id) AS pendente_count
        FROM users u
        LEFT JOIN pedidos r ON u.id = r.tecnico_id AND r.status = 'pendente'
        WHERE u.papel = 'tecnico'
        GROUP BY u.id
        ORDER BY pendente_count ASC
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows == 1) {
    $tech = $result->fetch_assoc();
    $tecnico_id = $tech['id'];
    
    $updateSql = "UPDATE pedidos SET tecnico_id = $tecnico_id, status = 'atribuido' WHERE id = $pedido_id";
    if ($conn->query($updateSql) === TRUE) {
        header("Location: funcionario_dashboard.php");
        exit;
    } else {
        echo "Erro ao atualizar a solicitação: " . $conn->error;
    }
} else {
    echo "Nenhum técnico disponível.";
}
?>
