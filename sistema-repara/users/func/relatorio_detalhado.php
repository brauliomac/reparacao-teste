<?php
session_start();
// Apenas usuários com o perfil "funcionario" (ou outro, conforme sua política) podem acessar o relatório detalhado.
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Consulta que retorna os dados da solicitação com os nomes do cliente e do técnico (se atribuído)
$sql = "SELECT r.*, 
               cliente.name AS cliente_name, 
               tecnico.name AS tecnico_name
        FROM pedidos r
        JOIN users cliente ON r.cliente_id = cliente.id
        LEFT JOIN users tecnico ON r.tecnico_id = tecnico.id
        ORDER BY r.data_criacao ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório Detalhado de Solicitações</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Relatório Detalhado de Solicitações</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>cliente</th>
                <th>Técnico</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Prioridade</th>
                <th>Data de Criação</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cliente_name']); ?></td>
                    <td><?php echo ($row['tecnico_name'] != NULL ? htmlspecialchars($row['tecnico_name']) : 'Não atribuído'); ?></td>
                    <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['prioridade']; ?></td>
                    <td><?php echo $row['data_criacao']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhuma solicitação encontrada.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="relatorios.php" class="btn btn-secondary">Voltar</a>
</div>
</body>
</html>
