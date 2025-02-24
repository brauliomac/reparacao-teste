<?php
session_start();
// Aqui, consideramos que somente técnicos devem acessar essa página
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Consulta para obter as solicitações com status 'diagnosticado' (diagnóstico concluído)
$sql = "SELECT r.*, u.name AS cliente_name 
        FROM pedidos r 
        JOIN users u ON r.cliente_id = u.id 
        WHERE r.status = 'diagnosticado'
        ORDER BY r.data_criacao DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Montagens Pendentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Solicitações para Montagem</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>cliente</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['cliente_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                        <td><?php echo $row['data_criacao']; ?></td>
                        <td>
                            <!-- Botão para acessar a página de montagem da solicitação -->
                            <a href="montagem.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Montar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma solicitação encontrada para montagem.</p>
    <?php endif; ?>
    <a href="tecnico_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
