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

// Verifica se o ID do componente foi enviado via GET ou POST
if (isset($_GET['id'])) {
    $component_id = intval($_GET['id']);
} elseif (isset($_POST['id'])) {
    $component_id = intval($_POST['id']);
} else {
    die("ID do componente não informado.");
}

// Se o formulário foi submetido, atualiza os dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['componente']) && isset($_POST['quantidade'])) {
        $componente = trim($_POST['componente']);
        $quantidade = intval($_POST['quantidade']);

        if (empty($componente)) {
            $error = "O nome do componente é obrigatório.";
        } elseif ($quantidade < 0) {
            $error = "A quantidade deve ser um número não negativo.";
        } else {
            $componente = $conn->real_escape_string($componente);
            $sql = "UPDATE registo SET componente = '$componente', quantidade = $quantidade WHERE id = $component_id";
            if ($conn->query($sql) === TRUE) {
                $success = "Componente atualizado com sucesso!";
            } else {
                $error = "Erro ao atualizar componente: " . $conn->error;
            }
        }
    } else {
        $error = "Preencha todos os campos.";
    }
}

// Busca os dados do componente para exibir no formulário
$sql = "SELECT * FROM registo WHERE id = $component_id";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    die("Componente não encontrado.");
}
$componentData = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Componente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Editar Componente</h2>
    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="post" action="editar_registo.php">
        <input type="hidden" name="id" value="<?php echo $componentData['id']; ?>">
        <div class="form-group">
            <label for="componente">Nome do Componente</label>
            <input type="text" name="componente" id="componente" class="form-control" value="<?php echo htmlspecialchars($componentData['componente']); ?>" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" value="<?php echo $componentData['quantidade']; ?>" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Componente</button>
    </form>
    <a href="registo.php" class="btn btn-secondary mt-3">Voltar ao Estoque</a>
</div>
</body>
</html>
