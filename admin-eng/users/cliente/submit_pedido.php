<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if(isset($_POST['descricao']) && isset($_POST['prioridade'])){
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $prioridade = $conn->real_escape_string($_POST['prioridade']);
    $cliente_id = $_SESSION['user_id'];

    $sql = "INSERT INTO pedidos (cliente_id, descricao, prioridade, status) VALUES ($cliente_id, '$descricao', '$prioridade', 'pendente')";
    if($conn->query($sql) === TRUE){
        header("Location: cliente_dashboard.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
} else {
    echo "Descrição é obrigatória.";
}
?>
