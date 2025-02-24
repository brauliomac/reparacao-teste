<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

// Busca os detalhes da solicitação (apenas se o status for 'diagnosticado')
$sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r 
        JOIN users u ON r.cliente_id = u.id 
        WHERE r.id = $pedido_id AND r.status = 'diagnosticado'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada ou não está pronta para montagem.");
}
$pedido = $result->fetch_assoc();

// Verifica se existem peças faltantes para essa solicitação
$sqlParts = "SELECT SUM(quantidade_em_falta) AS total_missing FROM pedido_partes WHERE pedido_id = $pedido_id";
$partsResult = $conn->query($sqlParts);
$total_missing = 0;
if ($partsResult && $row = $partsResult->fetch_assoc()) {
    $total_missing = intval($row['total_missing']);
}
$can_montar = ($total_missing == 0);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Montagem da Solicitação #<?php echo $pedido_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Montagem da Solicitação #<?php echo $pedido_id; ?></h2>
    <p><strong>cliente:</strong> <?php echo htmlspecialchars($pedido['cliente_name']); ?></p>
    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($pedido['descricao']); ?></p>
    <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
    <h4>Peças Utilizadas no Diagnóstico</h4>
    <?php
    // Lista as peças utilizadas no diagnóstico
    $sqlList = "SELECT rp.*, i.componente FROM pedido_partes rp JOIN registo i ON rp.part_id = i.id WHERE rp.pedido_id = $pedido_id";
    $listResult = $conn->query($sqlList);
    if ($listResult && $listResult->num_rows > 0) {
        echo "<table class='table table-bordered'>
                <tr>
                    <th>Peça</th>
                    <th>Quantidade Utilizada</th>
                    <th>Quantidade Faltante</th>
                </tr>";
        while ($part = $listResult->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($part['componente']) . "</td>
                    <td>{$part['quantidade_usada']}</td>
                    <td>{$part['quantidade_em_falta']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma peça registrada.</p>";
    }
    ?>
    <?php if ($can_montar): ?>
        <form action="montar.php" method="post">
            <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
            <button type="submit" class="btn btn-success">Montar</button>
        </form>
    <?php else: ?>
        <button class="btn btn-secondary" disabled>Montar (Aguardando peças)</button>
        <p class="text-danger">Não é possível montar: faltam <?php echo $total_missing; ?> peças.</p>
    <?php endif; ?>
    <a href="tecnico_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
