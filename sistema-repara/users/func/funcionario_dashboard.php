<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="../../style/style.css">
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
    //$sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r JOIN users u ON r.cliente_id = u.id WHERE r.status = 'pendente' ORDER BY r.data_criacao ASC";
    $sql = "SELECT r.*, u.name AS cliente_name 
        FROM pedidos r 
        JOIN users u ON r.cliente_id = u.id 
        WHERE r.status = 'pendente' 
        ORDER BY FIELD(r.prioridade, 'alta', 'media', 'baixa'), r.data_criacao ASC";

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        echo '<table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>cliente</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>';
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cliente_name']}</td>
                    <td>{$row['descricao']}</td>
                    <td>{$row['prioridade']}</td>
                    <td>{$row['data_criacao']}</td>
                    <td>
                        <a href='atribuir_tecnico.php?id={$row['id']}' class='btn btn-sm btn-primary'>Atribuir Técnico</a>
                    </td>
                  </tr>";
        }
        echo '</table>';
    } else {
        echo "<p>Nenhuma solicitação pendente.</p>";
    }
    ?>
    <!-- ATRIBUIR AUTOMATICAMENTE NAO FUNCIONA - VERIFICAR-->
    <a href="atribuir_tecnico_auto.php?id=<?php echo $row['id']; ?>" class='btn btn-warning'>Atribuição Automática</a>
    
    <!-- ESTES ESTAO A FUNCIONAR -->
    <a href="registo.php" class="btn btn-info mt-3">Estoque de Peças</a>
    <a href="funcionario_ver_clientes.php" class="btn btn-primary">Gerir clientes</a>
    <a href="funcionario_ver_tecnicos.php" class="btn btn-primary">Gerir Técnicos</a>
    <a href="funcionario_ver_funcionario.php" class="btn btn-primary">Gerir Funcionarios</a>
    <a href="pedidos_compra.php" class="btn btn-info mt-3">Departamento de Compras</a>
    <a href="relatorios.php" class="btn btn-info mt-3"> Relatórios</a>
    <a href="../../logout.php" class="btn btn-secondary mt-3">Sair</a>

</div>
</body>
</html>
