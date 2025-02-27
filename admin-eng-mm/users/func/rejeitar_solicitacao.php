<?php
session_start();
include '../../db/db.php';

if(isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];
    
    $sql = "UPDATE pedidos 
            SET status = 'rejeitado', 
                data_actualizacao = NOW() 
            WHERE id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    
    if($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Solicitação rejeitada com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao rejeitar solicitação']);
    }
}
?>
