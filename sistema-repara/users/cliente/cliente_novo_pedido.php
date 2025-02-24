<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['descricao'])) {
        $descricao = $conn->real_escape_string(trim($_POST['descricao']));
        $cliente_id = $_SESSION['user_id'];
        
        if (empty($descricao)) {
            $error = "A descrição é obrigatória.";
        } else {
            $sql = "INSERT INTO pedidos (cliente_id, descricao, status) VALUES ($cliente_id, '$descricao', 'pendente')";
            if ($conn->query($sql) === TRUE) {
                $success = "Solicitação registrada com sucesso.";
            } else {
                $error = "Erro ao registrar solicitação: " . $conn->error;
            }
        }
    } else {
        $error = "Dados inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Solicitação</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Nova Solicitação</h2>
    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="post" action="cliente_novo_pedido.php">
        <div class="form-group">
            <label for="descricao">Descrição da Solicitação:</label>
            <textarea name="descricao" id="descricao" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
    </form>
    <a href="cliente_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
