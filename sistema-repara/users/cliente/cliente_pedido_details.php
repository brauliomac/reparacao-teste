<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o cliente está logado
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente') {
    header("Location: ../../login.php");
    exit;
}

include '../../db/db.php';

$cliente_id = $_SESSION['user_id'];

// Verifica se o ID da solicitação foi passado via GET
if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

// Consulta para buscar os detalhes da solicitação
// Aqui, usamos LEFT JOIN para buscar o nome do técnico (caso já tenha sido atribuído)
// A consulta garante que o cliente só possa ver as próprias solicitações
$sql = "SELECT r.*, t.name AS tecnico_name 
        FROM pedidos r 
        LEFT JOIN users t ON r.tecnico_id = t.id 
        WHERE r.id = $pedido_id AND r.cliente_id = $cliente_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada ou acesso não autorizado.");
}

$pedido = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Solicitação #<?php echo $pedido_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Detalhes da Solicitação #<?php echo $pedido_id; ?></h2>
    <div class="card">
        <div class="card-header">
            Status: <?php echo ucfirst($pedido['status']); ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Descrição da Solicitação</h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($pedido['descricao'])); ?></p>
            <p><strong>Data de Criação:</strong> <?php echo $pedido['data_criacao']; ?></p>
            <?php if (!empty($pedido['data_actualizacao'])): ?>
                <p><strong>Data de Atualização:</strong> <?php echo $pedido['data_actualizacao']; ?></p>
            <?php endif; ?>
            <p><strong>Técnico Atribuído:</strong> <?php echo ($pedido['tecnico_name'] ? htmlspecialchars($pedido['tecnico_name']) : "Ainda não atribuído"); ?></p>
        </div>
    </div>
    <a href="cliente_ver_pedidos.php" class="btn btn-secondary mt-3">Voltar às Solicitações</a>
</div>
</body>
</html>
