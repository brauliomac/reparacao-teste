<?php
session_start();
// Verifica se o usuário está logado e é funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$error = "";
$success = "";

// Processa o formulário quando submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['componente']) && isset($_POST['quantidade'])) {
        $componente = trim($_POST['componente']);
        $quantidade = intval($_POST['quantidade']);
        
        // Valida os dados
        if (empty($componente)) {
            $error = "O nome do componente é obrigatório.";
        } elseif ($quantidade < 0) {
            $error = "A quantidade deve ser um número não negativo.";
        } else {
            // Sanitiza o valor antes de inserir no banco
            $componente = $conn->real_escape_string($componente);
            $sql = "INSERT INTO registo (componente, quantidade) VALUES ('$componente', $quantidade)";
            if ($conn->query($sql) === TRUE) {
                $success = "Componente adicionado com sucesso!";
            } else {
                $error = "Erro ao adicionar componente: " . $conn->error;
            }
        }
    } else {
        $error = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Componente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Adicionar Novo Componente ao Estoque</h2>
    
    <!-- Exibe mensagem de erro, se houver -->
    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <!-- Exibe mensagem de sucesso, se houver -->
    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <!-- Formulário para adicionar o componente -->
    <form method="post" action="add_registo.php">
        <div class="form-group">
            <label for="componente">Nome do Componente</label>
            <input type="text" name="componente" id="componente" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Componente</button>
    </form>
    <a href="registo.php" class="btn btn-secondary mt-3">Voltar ao Estoque</a>
</div>
</body>
</html>
