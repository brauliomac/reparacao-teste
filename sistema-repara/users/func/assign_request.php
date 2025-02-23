<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if(isset($_GET['id'])){
    $request_id = intval($_GET['id']);
} else {
    die("Solicitação inválida.");
}

// Busca detalhes da solicitação
$sql = "SELECT * FROM requests WHERE id = $request_id";
$request_result = $conn->query($sql);
if($request_result->num_rows != 1){
    die("Solicitação não encontrada.");
}
$request = $request_result->fetch_assoc();

// Lista de técnicos disponíveis
$sqlTech = "SELECT * FROM users WHERE role = 'technician'";
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
    <h2 class="mt-5">Atribuir Técnico para Solicitação #<?php echo $request['id']; ?></h2>
    <form action="process_assignment.php" method="post">
        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
        <div class="form-group">
            <label>Selecione o Técnico</label>
            <select name="technician_id" class="form-control" required>
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
    <a href="employee_dashboard.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
</body>
</html>
