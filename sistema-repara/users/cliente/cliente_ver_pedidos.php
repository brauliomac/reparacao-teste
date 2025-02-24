<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$cliente_id = $_SESSION['user_id'];
$sql = "SELECT * FROM pedidos WHERE cliente_id = $cliente_id ORDER BY data_criacao DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Solicitações</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Minhas Solicitações</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['data_criacao']; ?></td>
                    <td>
                        <!-- Exemplo: botão para visualizar detalhes da solicitação -->
                        <a href="cliente_pedido_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Ver Detalhes</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma solicitação encontrada.</p>
    <?php endif; ?>
    <a href="cliente_dashboard.php" class="btn btn-secondary">Voltar ao Dashboard</a>
</div>
</body>
</html>
