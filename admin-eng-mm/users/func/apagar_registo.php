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

// Se o formulário foi submetido (confirmação), remove o registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM registo WHERE id = $component_id";
    if ($conn->query($sql) === TRUE) {
        $success = "Componente apagado com sucesso!";
        header("Location: registo.php");
        exit;
    } else {
        $error = "Erro ao apagar componente: " . $conn->error;
    }
}

// Busca os dados do componente para exibir na confirmação
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
    <title>Apagar Componente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Apagar Componente</h2>
    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <p>Tem certeza que deseja apagar o componente <strong><?php echo htmlspecialchars($componentData['componente']); ?></strong>?</p>
    <form method="post" action="apagar_registo.php">
        <input type="hidden" name="id" value="<?php echo $componentData['id']; ?>">
        <button type="submit" class="btn btn-danger">Sim, apagar</button>
        <a href="registo.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
