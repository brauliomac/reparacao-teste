<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Funcionário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../../img/icon.png" type="image/x-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Bem-vindo, <?php echo $_SESSION['name']; ?></h2>
    <h3>Solicitações Pendentes</h3>
    <?php
    //$sql = "SELECT r.*, u.name AS client_name FROM requests r JOIN users u ON r.client_id = u.id WHERE r.status = 'pending' ORDER BY r.created_at ASC";
    $sql = "SELECT r.*, u.name AS client_name 
        FROM requests r 
        JOIN users u ON r.client_id = u.id 
        WHERE r.status = 'pending' 
        ORDER BY FIELD(r.priority, 'high', 'medium', 'low'), r.created_at ASC";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo '<table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>';
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['client_name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <a href='assign_request.php?id={$row['id']}' class='btn btn-sm btn-primary'>Atribuir Técnico</a>
                    </td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo "<p>Nenhuma solicitação pendente.</p>";
    }
    ?>
    <!-- ATRIBUIR AUTOLMATICAMENTE NAO FUNCIONA - VERIFICAR-->
    <a href="assign_auto.php?id=<?php echo $row['id']; ?>" class='btn btn-warning'>Atribuir Automático</a>
    
    <!-- ESTES ESTAO A FUNCIONAR -->
    <a href="inventory.php" class="btn btn-info mt-3">Estoque de Peças</a>
    <a href="employee_view_clients.php" class="btn btn-primary">Gerir Clientes</a>
    <a href="employee_view_technicians.php" class="btn btn-primary">Gerir Técnicos</a>
    <a href="employee_view_employee.php" class="btn btn-primary">Gerir Funcionarios</a>
    <a href="purchase_requests.php" class="btn btn-info mt-3">Departamento de Compras</a>
    <a href="reports.php" class="btn btn-info mt-3"> Relatórios</a>
    <a href="../../logout.php" class="btn btn-secondary mt-3">Sair</a>

</div>
</body>
</html>
