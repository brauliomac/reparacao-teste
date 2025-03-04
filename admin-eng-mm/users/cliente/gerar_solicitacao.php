<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente') {
    $error = "Acesso não autorizado.";
}

include '../../db/db.php';

$cliente_id = $_SESSION['user_id'];
$pedido_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($pedido_id <= 0) {
    $error = "ID da solicitação inválido.";
}

// Consulta ao banco para buscar os detalhes da solicitação
$sql = "SELECT r.*, t.name AS tecnico_name 
        FROM pedidos r 
        LEFT JOIN users t ON r.tecnico_id = t.id 
        WHERE r.id = $pedido_id AND r.cliente_id = $cliente_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows != 1) {
    $error = "Solicitação não encontrada ou acesso negado.";
}

$pedido = $result->fetch_assoc();

// Define os cabeçalhos para forçar o download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="solicitacao_'.$pedido_id.'.txt"');

// Conteúdo do arquivo TXT
echo "SOLICITAÇÃO DE EQUIPAMENTO\n";
echo "----------------------------------\n";
echo "ID: " . $pedido['id'] . "\n";
echo "Nome do Cliente: " . $_SESSION['name'] . "\n";
echo "Descrição: " . $pedido['descricao'] . "\n";
echo "Data de Criação: " . $pedido['data_criacao'] . "\n";
if (!empty($pedido['data_actualizacao'])) {
    echo "Última Actualização: " . $pedido['data_actualizacao'] . "\n";
}
echo "Técnico Atribuído: " . ($pedido['tecnico_name'] ? $pedido['tecnico_name'] : "Ainda não atribuído") . "\n";
echo "----------------------------------\n";

exit();
