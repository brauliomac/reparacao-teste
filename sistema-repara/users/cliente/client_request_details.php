<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o cliente está logado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client') {
    header("Location: ../../login.php");
    exit;
}

include '../../db/db.php';

$client_id = $_SESSION['user_id'];

// Verifica se o ID da solicitação foi passado via GET
if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

// Consulta para buscar os detalhes da solicitação
// Aqui, usamos LEFT JOIN para buscar o nome do técnico (caso já tenha sido atribuído)
// A consulta garante que o cliente só possa ver as próprias solicitações
$sql = "SELECT r.*, t.name AS technician_name 
        FROM requests r 
        LEFT JOIN users t ON r.technician_id = t.id 
        WHERE r.id = $request_id AND r.client_id = $client_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada ou acesso não autorizado.");
}

$request = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Solicitação #<?php echo $request_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Detalhes da Solicitação #<?php echo $request_id; ?></h2>
    <div class="card">
        <div class="card-header">
            Status: <?php echo ucfirst($request['status']); ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Descrição da Solicitação</h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($request['description'])); ?></p>
            <p><strong>Data de Criação:</strong> <?php echo $request['created_at']; ?></p>
            <?php if (!empty($request['updated_at'])): ?>
                <p><strong>Data de Atualização:</strong> <?php echo $request['updated_at']; ?></p>
            <?php endif; ?>
            <p><strong>Técnico Atribuído:</strong> <?php echo ($request['technician_name'] ? htmlspecialchars($request['technician_name']) : "Ainda não atribuído"); ?></p>
        </div>
    </div>
    <a href="client_view_requests.php" class="btn btn-secondary mt-3">Voltar às Solicitações</a>
</div>
</body>
</html>
