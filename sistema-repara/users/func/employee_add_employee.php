<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'], $_POST['password'], $_POST['name'], $_POST['role'])) {
        $username = $conn->real_escape_string(trim($_POST['username']));
        $password = $_POST['password'];
        $name = $conn->real_escape_string(trim($_POST['name']));
        $role = $conn->real_escape_string(trim($_POST['role']));
        
        // Permitir apenas as funções client e technician
        $allowed_roles = array('client', 'technician');
        if (!in_array($role, $allowed_roles)) {
            $error = "Função inválida.";
        } elseif (empty($username) || empty($password) || empty($name)) {
            $error = "Preencha todos os campos.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, role, name) VALUES ('$username', '$hashedPassword', '$role', '$name')";
            if ($conn->query($sql)) {
                $success = "Usuário adicionado com sucesso.";
            } else {
                $error = "Erro: " . $conn->error;
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
    <title>Adicionar Funcionario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Adicionar Funcionario</h2>
    <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post" action="employee_add_employee.php">
        <div class="form-group">
            <label for="name">Nome Completo</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="username">Usuário</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Função</label>
            <select name="role" id="role" class="form-control" required>
                <option value="client">Cliente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Usuário</button>
    </form>
    <a href="employee_view_clients.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
</body>
</html>
