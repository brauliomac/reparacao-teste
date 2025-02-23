<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$client_id = $_SESSION['user_id'];
$sql = "SELECT * FROM requests WHERE client_id = $client_id ORDER BY created_at DESC";
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
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <!-- Exemplo: botão para visualizar detalhes da solicitação -->
                        <a href="client_request_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Ver Detalhes</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma solicitação encontrada.</p>
    <?php endif; ?>
    <a href="client_dashboard.php" class="btn btn-secondary">Voltar ao Dashboard</a>
</div>
</body>
</html>
