<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$error = "";
$success = "";

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} elseif (isset($_POST['id'])) {
    $user_id = intval($_POST['id']);
} else {
    die("ID do usuário não informado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'], $_POST['username'], $_POST['papel'])) {
        $name = $conn->real_escape_string(trim($_POST['name']));
        $username = $conn->real_escape_string(trim($_POST['username']));
        $papel = $conn->real_escape_string(trim($_POST['papel']));
        $allowed_roles = array('cliente', 'tecnico', 'funcionario');
        if (!in_array($papel, $allowed_roles)) {
            $error = "Função inválida.";
        } elseif (empty($name) || empty($username)) {
            $error = "Preencha todos os campos.";
        } else {
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
                $sql = "UPDATE users SET name='$name', username='$username', papel='$papel', password='$password' WHERE id=$user_id";
            } else {
                $sql = "UPDATE users SET name='$name', username='$username', papel='$papel' WHERE id=$user_id";
            }
            if ($conn->query($sql)) {
                $success = "Usuário atualizado com sucesso.";
            } else {
                $error = "Erro ao atualizar usuário: " . $conn->error;
            }
        }
    } else {
        $error = "Dados inválidos.";
    }
}

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Usuário não encontrado.");
}
$userData = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Editar Usuário</h2>
    <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post" action="funcionario_edit_user.php">
        <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">
        <div class="form-group">
            <label for="name">Nome Completo</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Usuário</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Senha (deixe em branco para manter a atual)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="papel">Função</label>
            <select name="papel" id="papel" class="form-control" required>
                <option value="cliente" <?php if ($userData['papel'] == 'cliente') echo "selected"; ?>>cliente</option>
                <option value="tecnico" <?php if ($userData['papel'] == 'tecnico') echo "selected"; ?>>Técnico</option>
                <option value="funcionario" <?php if ($userData['papel'] == 'funcionario') echo "selected"; ?>>Funcionario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
    </form>
    <a href="funcionario_dashboard.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
</body>
</html>
