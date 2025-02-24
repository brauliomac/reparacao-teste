<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Consulta os pedidos de compra, juntando com a tabela registo para obter o nome da peça.
$sql = "SELECT pr.*, i.componente 
        FROM pedidos_compra pr 
        JOIN registo i ON pr.componente_id = i.id 
        ORDER BY pr.data_criacao ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Departamento de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Pedidos de Compra</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Peça</th>
                <th>Quantidade Necessária</th>
                <th>Status</th>
                <th>Data de Criação</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['componente']); ?></td>
                    <td><?php echo $row['quantidade_necessaria']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['data_criacao']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'pendente'): ?>
                            <a href="processar_compra.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Comprar</a>
                        <?php else: ?>
                            <span class="text-muted">Processado</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Nenhum pedido de compra encontrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="funcionario_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
