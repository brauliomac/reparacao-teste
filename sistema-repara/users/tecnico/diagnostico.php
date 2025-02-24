<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Obtém o ID da solicitação via GET ou via POST (caso o formulário seja submetido)
if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} elseif (isset($_POST['pedido_id'])) {
    $pedido_id = intval($_POST['pedido_id']);
} else {
    die("Solicitação inválida.");
}

// Processamento dos formulários
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // Atualização do status da solicitação
        if ($action == 'update_status') {
            if (isset($_POST['new_status'])) {
                $new_status = $_POST['new_status'];
                $allowed_status = array('pendente', 'diagnosticado'); 
                if (in_array($new_status, $allowed_status)) {
                    $sql = "UPDATE pedidos SET status = '$new_status' WHERE id = $pedido_id";
                    if (!$conn->query($sql)) {
                        $error_status = "Erro ao atualizar status: " . $conn->error;
                    } else {
                        $success_status = "Status atualizado com sucesso.";
                    }
                } else {
                    $error_status = "Status inválido.";
                }
            }
        }
        // Adição de peça necessária
        elseif ($action == 'add_part') {
            if (isset($_POST['part_id']) && isset($_POST['quantity_required'])) {
                $part_id = intval($_POST['part_id']);
                $quantity_required = intval($_POST['quantity_required']);
                if ($quantity_required <= 0) {
                    $error_part = "A quantidade deve ser maior que zero.";
                } else {
                    // Consulta a quantidade disponível em estoque para a peça selecionada
                    $sql = "SELECT quantidade FROM registo WHERE id = $part_id";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $available = intval($row['quantidade']);
                        if ($quantity_required <= $available) {
                            // Há estoque suficiente: usa a quantidade solicitada
                            $quantidade_usada = $quantity_required;
                            $quantidade_em_falta = 0;
                            $new_stock = $available - $quantity_required;
                        } else {
                            // Estoque insuficiente: usa o que está disponível e calcula a quantidade faltante
                            $quantidade_usada = $available;
                            $quantidade_em_falta = $quantity_required - $available;
                            $new_stock = 0;
                        }
                        // Atualiza o estoque para a peça
                        $updateInv = "UPDATE registo SET quantidade = $new_stock WHERE id = $part_id";
                        $conn->query($updateInv);
                        
                        // Registra a utilização da peça na solicitação
                        $insertPart = "INSERT INTO pedido_partes (pedido_id, part_id, quantidade_usada, quantidade_em_falta) VALUES ($pedido_id, $part_id, $quantidade_usada, $quantidade_em_falta)";
                        if ($conn->query($insertPart)) {
                            $success_part = "Peça adicionada ao diagnóstico.";
                            // Se houver quantidade faltante, gera um pedido de compra para o departamento de compras
                            if ($quantidade_em_falta > 0) {
                                $insertPurchase = "INSERT INTO pedidos_compra (componente_id, quantidade_necessaria) VALUES ($part_id, $quantidade_em_falta)";
                                $conn->query($insertPurchase);
                                $warning_part = "Estoque insuficiente. Pedido de compra gerado para $quantidade_em_falta unidades.";
                            }
                        } else {
                            $error_part = "Erro ao registrar a peça: " . $conn->error;
                        }
                    } else {
                        $error_part = "Peça não encontrada no estoque.";
                    }
                }
            } else {
                $error_part = "Dados da peça inválidos.";
            }
        }
    }
}

// Obtém os dados da solicitação
$sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r JOIN users u ON r.cliente_id = u.id WHERE r.id = $pedido_id";
$pedidoResult = $conn->query($sql);
if (!$pedidoResult || $pedidoResult->num_rows != 1) {
    die("Solicitação não encontrada.");
}
$pedidoData = $pedidoResult->fetch_assoc();

// Obtém as peças já adicionadas para essa solicitação
$sqlParts = "SELECT rp.*, i.componente FROM pedido_partes rp JOIN registo i ON rp.part_id = i.id WHERE rp.pedido_id = $pedido_id";
$partsResult = $conn->query($sqlParts);

// Obtém todas as peças do estoque para popular o select do formulário
$sqlAllParts = "SELECT * FROM registo ORDER BY componente ASC";
$allPartsResult = $conn->query($sqlAllParts);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico da Solicitação #<?php echo $pedido_id; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Diagnóstico da Solicitação #<?php echo $pedido_id; ?></h2>
    <p><strong>cliente:</strong> <?php echo htmlspecialchars($pedidoData['cliente_name']); ?></p>
    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($pedidoData['descricao']); ?></p>
    <p><strong>Status Atual:</strong> <?php echo $pedidoData['status']; ?></p>

    <!-- Formulário para atualizar o status da solicitação 
    <h4>Atualizar Status</h4>
    <?php if (isset($error_status)) echo "<div class='alert alert-danger'>$error_status</div>"; ?>
    <?php if (isset($success_status)) echo "<div class='alert alert-success'>$success_status</div>"; ?>
   
    <form method="post" action="diagnostico.php">
        <input type="hidden" name="action" value="update_status">
        <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
        <div class="form-group">
            <label for="new_status">Novo Status</label>
            <select name="new_status" id="new_status" class="form-control" required>
                <option value="in_progress" <?php if ($pedidoData['status'] == 'in_progress') echo "selected"; ?>>Em Andamento</option>
                <option value="completed" <?php if ($pedidoData['status'] == 'completed') echo "selected"; ?>>Concluído</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Status</button>
    </form>
    -->
    <hr>

    <!-- Formulário para adicionar peças necessárias -->
    <h4>Adicionar Peças Necessárias para Montagem</h4>
    <?php if (isset($error_part)) echo "<div class='alert alert-danger'>$error_part</div>"; ?>
    <?php if (isset($success_part)) echo "<div class='alert alert-success'>$success_part</div>"; ?>
    <?php if (isset($warning_part)) echo "<div class='alert alert-warning'>$warning_part</div>"; ?>
    <form method="post" action="diagnostico.php">
        <input type="hidden" name="action" value="add_part">
        <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
        <div class="form-group">
            <label for="part_id">Selecione a Peça</label>
            <select name="part_id" id="part_id" class="form-control" required>
                <?php
                if ($allPartsResult && $allPartsResult->num_rows > 0) {
                    while ($part = $allPartsResult->fetch_assoc()) {
                        echo "<option value='{$part['id']}'>".htmlspecialchars($part['componente'])." (Disponível: {$part['quantidade']})</option>";
                    }
                } else {
                    echo "<option value=''>Nenhuma peça encontrada</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity_required">Quantidade Necessária</label>
            <input type="number" name="quantity_required" id="quantity_required" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Peça</button>
    </form>

    <hr>

    <!-- Lista das peças já adicionadas para essa solicitação -->
    <h4>Peças Adicionadas para esta Solicitação</h4>
    <?php
    if ($partsResult && $partsResult->num_rows > 0) {
        echo "<table class='table table-bordered'>
                <tr>
                    <th>Peça</th>
                    <th>Quantidade Utilizada</th>
                    <th>Quantidade em Falta</th>
                </tr>";
        while ($rp = $partsResult->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($rp['componente']) . "</td>
                    <td>{$rp['quantidade_usada']}</td>
                    <td>{$rp['quantidade_em_falta']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma peça adicionada até o momento.</p>";
    }
    ?>
    <form action="diagnostico_complete.php" method="post">
        <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
        <button type="submit" class="btn btn-success">Concluído</button>
    </form>
    <a href="tecnico_dashboard.php" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
</body>
</html>
