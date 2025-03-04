<?php
session_start();
include 'db/db.php';
$error = "";

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
 
        if($user['password'] == $password){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['papel'] = $user['papel'];
            $_SESSION['name'] = $user['name'];

            header("Location: includes/dashboard.php");
            exit;
        } else {
            $error = "Senha incorreta.";
           // header("Location: login.php");
           // exit;
        }
    } else {
        $error = "Usuário não encontrado.";
       // header("Location: ../login.php");
       // exit;
    }
} //else {
   // $error = "Preencha todos os campos.";
//}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Solicitações</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-4 shadow-sm" style="width: 350px;">
        <?php if ($error != ""): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <h4 class="text-center mb-3">Login</h4>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="username" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>


</body>
</html>
