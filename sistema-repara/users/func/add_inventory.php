<?php
session_start();
// Verifica se o usuário está logado e é funcionário
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$error = "";
$success = "";

// Processa o formulário quando submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['component']) && isset($_POST['quantity'])) {
        $component = trim($_POST['component']);
        $quantity = intval($_POST['quantity']);
        
        // Valida os dados
        if (empty($component)) {
            $error = "O nome do componente é obrigatório.";
        } elseif ($quantity < 0) {
            $error = "A quantidade deve ser um número não negativo.";
        } else {
            // Sanitiza o valor antes de inserir no banco
            $component = $conn->real_escape_string($component);
            $sql = "INSERT INTO inventory (component, quantity) VALUES ('$component', $quantity)";
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
    <form method="post" action="add_inventory.php">
        <div class="form-group">
            <label for="component">Nome do Componente</label>
            <input type="text" name="component" id="component" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantidade</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Componente</button>
    </form>
    <a href="inventory.php" class="btn btn-secondary mt-3">Voltar ao Estoque</a>
</div>
</body>
</html>
