<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
$tecnico_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Técnico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Bem-vindo, <?php echo $_SESSION['name']; ?></h2>
    <h3>Solicitações Atribuídas</h3>
    <?php
    $sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r JOIN users u ON r.cliente_id = u.id WHERE r.tecnico_id = $tecnico_id ORDER BY r.data_criacao ASC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo '<table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>cliente</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>';
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cliente_name']}</td>
                    <td>{$row['descricao']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <a href='diagnostico.php?id={$row['id']}' class='btn btn-sm btn-success'>Diagnostico</a>
                    </td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo "<p>Nenhuma solicitação atribuída.</p>";
    }
    ?>
    <!-- Trecho do tecnico_dashboard.php -->
    <a href="tecnico_editar_perfil.php" class="btn btn-primary">Atualizar Meus Dados</a>
    <a href="lista_montagem.php" class="btn btn-warning">Ir para Montagem</a>

    <a href="../../logout.php" class="btn btn-secondary mt-3">Sair</a>
</div>
</body>
</html>
