<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Exemplo: contagem de solicitações por status
$sql = "SELECT status, COUNT(*) as total FROM pedidos GROUP BY status";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Relatórios de Solicitações</h2>
    <h3>Status das Solicitações</h3>
    <table class="table table-bordered">
        <tr>
            <th>Status</th>
            <th>Total</th>
        </tr>
        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>{$row['status']}</td>
                        <td>{$row['total']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nenhum dado encontrado.</td></tr>";
        }
        ?>
    </table>
    <a href="relatorio_detalhado.php" class="btn btn-info mt-3">Relatório Detalhado</a>
    <a href="tecnico_performance.php" class="btn btn-info mt-3"> Desempenho dos Técnicos</a>
    <a href="funcionario_dashboard.php" class="btn btn-secondary">Voltar</a>
</div>
</body>
</html>
