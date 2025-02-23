<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Bem-vindo, <?php echo $_SESSION['name']; ?></h2>
    <h3>Nova Solicitação</h3>
    <form action="submit_request.php" method="post">
        <div class="form-group">
            <label>Descrição do Equipamento/Problema</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Prioridade</label>
            <select name="priority" class="form-control" required>
                <option value="low">Baixa</option>
                <option value="medium" selected>Média</option>
                <option value="high">Alta</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
    </form>
    <hr>
    <h3>Minhas Solicitações</h3>
    <?php
    $client_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM requests WHERE client_id = $client_id ORDER BY created_at ASC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo '<table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>';
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo "<p>Nenhuma solicitação encontrada.</p>";
    }
    ?>
    <!-- Trecho do client_dashboard.php -->
    <a href="client_edit_profile.php" class="btn btn-primary">Atualizar Meus Dados</a>
    <!-- Botão para visualizar todas as solicitações -->
    <a href="client_view_requests.php" class="btn btn-primary">Ver Todas as Solicitações</a>
        <!-- Botão para realizar uma nova solicitação -->
        <a href="client_new_request.php" class="btn btn-success">Nova Solicitação</a>
    <a href="../../logout.php" class="btn btn-secondary mt-3">Sair</a>
</div>
</body>
</html>
