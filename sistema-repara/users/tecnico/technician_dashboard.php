<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
$technician_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Técnico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Bem-vindo, <?php echo $_SESSION['name']; ?></h2>
    <h3>Solicitações Atribuídas</h3>
    <?php
    $sql = "SELECT r.*, u.name AS client_name FROM requests r JOIN users u ON r.client_id = u.id WHERE r.technician_id = $technician_id ORDER BY r.created_at ASC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo '<table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>';
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['client_name']}</td>
                    <td>{$row['description']}</td>
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
    <!-- Trecho do technician_dashboard.php -->
    <a href="technician_edit_profile.php" class="btn btn-primary">Atualizar Meus Dados</a>
    <a href="montagem_list.php" class="btn btn-warning">Ir para Montagem</a>

    <a href="../../logout.php" class="btn btn-secondary mt-3">Sair</a>
</div>
</body>
</html>
