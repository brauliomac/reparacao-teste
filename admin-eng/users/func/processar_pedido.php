<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if(isset($_POST['pedido_id']) && isset($_POST['tecnico_id'])){
    $pedido_id = intval($_POST['pedido_id']);
    $tecnico_id = intval($_POST['tecnico_id']);

    $sql = "UPDATE pedidos SET tecnico_id = $tecnico_id, status = 'atribuido' WHERE id = $pedido_id";
    if($conn->query($sql) === TRUE){
        header("Location: funcionario_dashboard.php");
        exit;
    } else {
        echo "Erro ao atribuir técnico: " . $conn->error;
    }
} else {
    echo "Dados inválidos.";
}
?>
