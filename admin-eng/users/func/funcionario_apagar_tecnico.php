<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} elseif (isset($_POST['id'])) {
    $user_id = intval($_POST['id']);
} else {
    die("ID do usuário não informado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM users WHERE id = $user_id";
    if ($conn->query($sql)) {
        header("Location: funcionario_apagar_tecnico.php");
        exit;
    } else {
        $error = "Erro ao remover usuário: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    if (!$result || $result->num_rows != 1) {
        die("Usuário não encontrado.");
    }
    $userData = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Remover Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Remover Usuário</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <p>Tem certeza que deseja remover o usuário <strong><?php echo htmlspecialchars($userData['name']); ?></strong> (<?php echo htmlspecialchars($userData['papel']); ?>)?</p>
    <form method="post" action="funcionario_apagar_cliente.php"> 
        <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">
        <button type="submit" class="btn btn-danger">Sim, remover</button> 
        <a href="funcionario_ver_tecnicos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
