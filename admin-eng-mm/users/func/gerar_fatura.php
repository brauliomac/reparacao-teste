<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario'){
    $error = "Acesso não autorizado.";
}

include '../../db/db.php';

$pedido_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($pedido_id <= 0) {
    $error = "ID do pedido inválido.";
}

// Consulta ao banco para buscar os detalhes do pedido
$sql = "SELECT p.*, c.name AS cliente_name, t.name AS tecnico_name 
        FROM pedidos p 
        JOIN users c ON p.cliente_id = c.id 
        LEFT JOIN users t ON p.tecnico_id = t.id
        WHERE p.id = $pedido_id AND p.status = 'montado'";

$result = $conn->query($sql);

if (!$result || $result->num_rows != 1) {
    $error = "Pedido não encontrado ou acesso negado.";
}

$pedido = $result->fetch_assoc();

// Definir cabeçalhos para forçar o download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="fatura_'.$pedido_id.'.txt"');

// Criar o conteúdo do arquivo TXT
echo "FACTURA DE SERVIÇO\n";
echo "----------------------------------\n";
echo "ID do Pedido: " . $pedido['id'] . "\n";
echo "Cliente: " . $pedido['cliente_name'] . "\n";
echo "Descrição: " . $pedido['descricao'] . "\n";
echo "Data de Finalização: " . $pedido['data_actualizacao'] . "\n";
echo "Técnico Responsável: " . ($pedido['tecnico_name'] ? $pedido['tecnico_name'] : "Não atribuído") . "\n";
echo "----------------------------------\n";
echo "Obrigado por utilizar nossos serviços!\n";

exit();
?>
