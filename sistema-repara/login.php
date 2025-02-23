<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Solicitações</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container ">
    <h2 class="mt-5 ml-">Login</h2>
    <form action="includes/authenticate.php" method="post" >
        <div class="form-group w-50">
            <label>Usuário</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group w-50">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-50">Entrar</button>
    </form>
</div>
</body>
</html>
