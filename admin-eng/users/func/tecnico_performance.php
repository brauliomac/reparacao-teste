<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$sql = "SELECT 
            u.id AS tecnico_id,
            u.name AS tecnico_name,
            COUNT(r.id) AS total_completed,
            AVG(TIMESTAMPDIFF(MINUTE, r.data_criacao, r.data_actualizacao)) AS avg_completion_time
        FROM pedidos r
        JOIN users u ON r.tecnico_id = u.id
        WHERE r.status = 'montado'
        GROUP BY r.tecnico_id
        ORDER BY total_completed DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Desempenho dos Técnicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Desempenho dos Técnicos</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Solicitações Concluídas</th>
                <th>Tempo Médio de Conclusão (min)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['tecnico_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['tecnico_name']); ?></td>
                        <td><?php echo $row['total_completed']; ?></td>
                        <td><?php echo round($row['avg_completion_time'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum dado de desempenho disponível.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="relatorios.php" class="btn btn-secondary">Voltar ao Relatório</a>
</div>
</body>
</html>
