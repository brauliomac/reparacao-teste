<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

$sql = "SELECT r.*, u.name AS client_name FROM requests r JOIN users u ON r.client_id = u.id WHERE r.id = $request_id";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada.");
}
$request = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Montagem - Solicitação #<?php echo $request_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Comprovante de Montagem</h2>
    <p><strong>ID da Solicitação:</strong> <?php echo $request['id']; ?></p>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($request['client_name']); ?></p>
    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($request['description']); ?></p>
    <p><strong>Status:</strong> <?php echo $request['status']; ?></p>
    <p><strong>Data de Conclusão:</strong> <?php echo $request['updated_at']; ?></p>
    <p>O equipamento foi montado e está pronto para entrega.</p>
    <a href="technician_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
