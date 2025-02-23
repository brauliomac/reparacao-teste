<?php
session_start();
// Apenas usuários com o perfil "employee" (ou outro, conforme sua política) podem acessar o relatório detalhado.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Consulta que retorna os dados da solicitação com os nomes do cliente e do técnico (se atribuído)
$sql = "SELECT r.*, 
               client.name AS client_name, 
               technician.name AS technician_name
        FROM requests r
        JOIN users client ON r.client_id = client.id
        LEFT JOIN users technician ON r.technician_id = technician.id
        ORDER BY r.created_at ASC";

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
                <th>Cliente</th>
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
                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                    <td><?php echo ($row['technician_name'] != NULL ? htmlspecialchars($row['technician_name']) : 'Não atribuído'); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['priority']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhuma solicitação encontrada.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="reports.php" class="btn btn-secondary">Voltar</a>
</div>
</body>
</html>
