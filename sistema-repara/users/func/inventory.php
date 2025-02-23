<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

$sql = "SELECT * FROM inventory ORDER BY component ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Estoque de Componentes</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Componente</th>
            <th>Quantidade</th>
            <th>Ação</th>
        </tr>
        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['component']}</td>
                    <td>{$row['quantity']}</td>
                    <td>
                        <a href='edit_inventory.php?id={$row['id']}' class='btn btn-sm btn-primary'>Editar</a>
                        <a href='delete_inventory.php?id={$row['id']}' class='btn btn-sm btn-danger'>Apagar</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum componente cadastrado.</td></tr>";
        }
        ?>
    </table>
    <a href="add_inventory.php" class="btn btn-success">Adicionar Componente</a>
    <a href="employee_dashboard.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
</body>
</html>
