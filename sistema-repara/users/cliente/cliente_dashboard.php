<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Bem-vindo, <?php echo $_SESSION['name']; ?></h2>
    <h3>Nova Solicitação</h3>
    <form action="submit_pedido.php" method="post">
        <div class="form-group">
            <label>Descrição do Equipamento/Problema</label>
            <textarea name="descricao" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Prioridade</label>
            <select name="prioridade" class="form-control" required>
                <option value="baixa">Baixa</option>
                <option value="media" selected>Média</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
    </form>
    <hr>
    <h3>Minhas Solicitações</h3>
    <?php
    $cliente_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM pedidos WHERE cliente_id = $cliente_id ORDER BY data_criacao ASC";
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
                    <td>{$row['descricao']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['data_criacao']}</td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo "<p>Nenhuma solicitação encontrada.</p>";
    }
    ?>
    <!-- Trecho do cliente_dashboard.php -->
    <a href="cliente_editar_perfil.php" class="btn btn-primary">Atualizar Meus Dados</a>
    <!-- Botão para visualizar todas as solicitações -->
    <a href="cliente_ver_pedidos.php" class="btn btn-primary">Ver Todas as Solicitações</a>
        <!-- Botão para realizar uma nova solicitação -->
        <a href="cliente_novo_pedido.php" class="btn btn-success">Nova Solicitação</a>
    <a href="../../logout.php" class="btn btn-secondary mt-3">Sair</a>
</div>
</body>
</html>
