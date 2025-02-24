<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

$sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r JOIN users u ON r.cliente_id = u.id WHERE r.id = $pedido_id";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada.");
}
$pedido = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Montagem - Solicitação #<?php echo $pedido_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Comprovante de Montagem</h2>
    <p><strong>ID da Solicitação:</strong> <?php echo $pedido['id']; ?></p>
    <p><strong>cliente:</strong> <?php echo htmlspecialchars($pedido['cliente_name']); ?></p>
    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($pedido['descricao']); ?></p>
    <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
    <p><strong>Data de Conclusão:</strong> <?php echo $pedido['data_actualizacao']; ?></p>
    <p>O equipamento foi montado e está pronto para entrega.</p>
    <a href="tecnico_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
