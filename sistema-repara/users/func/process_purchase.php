<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $purchase_id = intval($_GET['id']);
} else {
    die("Pedido de compra inválido.");
}

// Verifica se o pedido existe e está pendente
$sql = "SELECT * FROM purchase_requests WHERE id = $purchase_id AND status = 'pending'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Pedido de compra não encontrado ou já processado.");
}
$purchase = $result->fetch_assoc();
$component_id = $purchase['component_id'];
$quantity_needed = intval($purchase['quantity_needed']);

// Atualiza o estoque: adiciona a quantidade comprada à peça
$sqlUpdateInventory = "UPDATE inventory SET quantity = quantity + $quantity_needed WHERE id = $component_id";
if (!$conn->query($sqlUpdateInventory)) {
    die("Erro ao atualizar o estoque: " . $conn->error);
}

// Atualiza o status do pedido de compra para 'ordered'
$sqlUpdatePurchase = "UPDATE purchase_requests SET status = 'ordered' WHERE id = $purchase_id";
if (!$conn->query($sqlUpdatePurchase)) {
    die("Erro ao atualizar o pedido de compra: " . $conn->error);
}

// actualiza a tabela de pecas adicionadas no tecnico
$sqlUpdateRequestParts = "UPDATE request_parts 
                          SET quantity_used = quantity_used + quantity_missing, 
                              quantity_missing = 0 
                          WHERE part_id = $component_id 
                          AND quantity_missing > 0";
if (!$conn->query($sqlUpdateRequestParts)) {
    die("Erro ao atualizar as peças do diagnóstico: " . $conn->error);
}

// Redireciona de volta para a página de pedidos de compra
header("Location: purchase_requests.php");
exit;
?>
