<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Consulta para obter apenas os usuários com função "technician"
$sql = "SELECT * FROM users WHERE role = 'technician' ORDER BY name";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Técnicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Gerenciar Técnicos</h2>
    <!-- Botão para adicionar novo técnico -->
    <a href="employee_add_technician.php" class="btn btn-success mb-3">Adicionar Técnico</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Usuário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td>
                            <a href="employee_edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="employee_delete_technician.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este técnico?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">Nenhum técnico encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="employee_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
