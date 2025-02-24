<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if(isset($_GET['id'])){
    $pedido_id = intval($_GET['id']);
} else {
    die("Solicitação inválida.");
}

// Busca detalhes da solicitação
$sql = "SELECT * FROM pedidos WHERE id = $pedido_id";
$pedido_result = $conn->query($sql);
if($pedido_result->num_rows != 1){
    die("Solicitação não encontrada.");
}
$pedido = $pedido_result->fetch_assoc();

// Lista de técnicos disponíveis
$sqlTech = "SELECT * FROM users WHERE papel = 'tecnico'";
$tech_result = $conn->query($sqlTech);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atribuir Técnico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Atribuir Técnico para Solicitação #<?php echo $pedido['id']; ?></h2>
    <form action="processar_pedido.php" method="post">
        <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
        <div class="form-group">
            <label>Selecione o Técnico</label>
            <select name="tecnico_id" class="form-control" required>
                <?php
                if($tech_result->num_rows > 0){
                    while($tech = $tech_result->fetch_assoc()){
                        echo "<option value='{$tech['id']}'>{$tech['name']}</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum técnico disponível</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Atribuir</button>
    </form>
    <a href="funcionario_dashboard.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
</body>
</html>
