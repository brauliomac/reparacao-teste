<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $compra_id = intval($_GET['id']);
} else {
    die("Pedido de compra inválido.");
}

// Verifica se o pedido existe e está pendente
$sql = "SELECT * FROM pedidos_compra WHERE id = $compra_id AND status = 'pendente'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Pedido de compra não encontrado ou já processado.");
}
$compra = $result->fetch_assoc();
$componente_id = $compra['componente_id'];
$quantidade_necessaria = intval($compra['quantidade_necessaria']);

// Atualiza o estoque: adiciona a quantidade comprada à peça
$sqlUpdateInventory = "UPDATE registo SET quantidade = 0 WHERE id = $componente_id";
if (!$conn->query($sqlUpdateInventory)) {
    die("Erro ao atualizar o estoque: " . $conn->error);
}

// Atualiza o status do pedido de compra para 'encomendado'
$sqlUpdatePurchase = "UPDATE pedidos_compra SET status = 'comprado' WHERE id = $compra_id";
if (!$conn->query($sqlUpdatePurchase)) {
    die("Erro ao atualizar o pedido de compra: " . $conn->error);
}

// actualiza a tabela de pecas adicionadas no tecnico
$sqlUpdateRequestParts = "UPDATE pedido_partes 
                          SET quantidade_usada = quantidade_usada + quantidade_em_falta, 
                              quantidade_em_falta = 0 
                          WHERE part_id = $componente_id 
                          AND quantidade_em_falta > 0";
if (!$conn->query($sqlUpdateRequestParts)) {
    die("Erro ao atualizar as peças do diagnóstico: " . $conn->error);
}

// Redireciona de volta para a página de pedidos de compra
header("Location: pedidos_compra.php");
exit;
?>
