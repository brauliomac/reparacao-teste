<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'technician') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

// Busca os detalhes da solicitação (apenas se o status for 'diagnosed')
$sql = "SELECT r.*, u.name AS client_name FROM requests r 
        JOIN users u ON r.client_id = u.id 
        WHERE r.id = $request_id AND r.status = 'diagnosed'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada ou não está pronta para montagem.");
}
$request = $result->fetch_assoc();

// Verifica se existem peças faltantes para essa solicitação
$sqlParts = "SELECT SUM(quantity_missing) AS total_missing FROM request_parts WHERE request_id = $request_id";
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
    <title>Montagem da Solicitação #<?php echo $request_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Montagem da Solicitação #<?php echo $request_id; ?></h2>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($request['client_name']); ?></p>
    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($request['description']); ?></p>
    <p><strong>Status:</strong> <?php echo $request['status']; ?></p>
    <h4>Peças Utilizadas no Diagnóstico</h4>
    <?php
    // Lista as peças utilizadas no diagnóstico
    $sqlList = "SELECT rp.*, i.component FROM request_parts rp JOIN inventory i ON rp.part_id = i.id WHERE rp.request_id = $request_id";
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
                    <td>" . htmlspecialchars($part['component']) . "</td>
                    <td>{$part['quantity_used']}</td>
                    <td>{$part['quantity_missing']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma peça registrada.</p>";
    }
    ?>
    <?php if ($can_montar): ?>
        <form action="montar.php" method="post">
            <input type="hidden" name="request_id" value="<?php echo $request_id; ?>">
            <button type="submit" class="btn btn-success">Montar</button>
        </form>
    <?php else: ?>
        <button class="btn btn-secondary" disabled>Montar (Aguardando peças)</button>
        <p class="text-danger">Não é possível montar: faltam <?php echo $total_missing; ?> peças.</p>
    <?php endif; ?>
    <a href="technician_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
