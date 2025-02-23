<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o usuário está logado e se sua função é 'technician'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician') {
    header("Location: ../../login.php");
    exit;
}

include '../../db/db.php';

$error = "";
$success = "";
$technician_id = $_SESSION['user_id'];

// Processa o formulário quando ele é submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'], $_POST['username'])) {
        $name = $conn->real_escape_string(trim($_POST['name']));
        $username = $conn->real_escape_string(trim($_POST['username']));
        
        if (empty($name) || empty($username)) {
            $error = "Preencha todos os campos obrigatórios.";
        } else {
            // Se uma nova senha for informada, atualize-a; caso contrário, mantenha a senha atual
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $sql = "UPDATE users SET name='$name', username='$username', password='$password' WHERE id=$technician_id AND role='technician'";
            } else {
                $sql = "UPDATE users SET name='$name', username='$username' WHERE id=$technician_id AND role='technician'";
            }
            
            if ($conn->query($sql) === TRUE) {
                $success = "Dados atualizados com sucesso.";
                // Atualiza a variável de sessão, se necessário
                $_SESSION['name'] = $name;
            } else {
                $error = "Erro ao atualizar os dados: " . $conn->error;
            }
        }
    } else {
        $error = "Dados inválidos.";
    }
}

// Busca os dados atuais do técnico para preencher o formulário
$sql = "SELECT * FROM users WHERE id = $technician_id AND role='technician'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Técnico não encontrado.");
}
$technician = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Dados Pessoais</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Atualizar Dados Pessoais</h2>
    
    <?php if ($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success != ""): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="post" action="technician_edit_profile.php">
        <div class="form-group">
            <label for="name">Nome Completo:</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?php echo htmlspecialchars($technician['name']); ?>">
        </div>
        <div class="form-group">
            <label for="username">Usuário:</label>
            <input type="text" name="username" id="username" class="form-control" required value="<?php echo htmlspecialchars($technician['username']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Senha (deixe em branco para manter a atual):</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
    <a href="technician_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
