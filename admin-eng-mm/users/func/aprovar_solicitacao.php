<?php

session_start();
include '../../db/db.php';

if(isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];

    // Verificar se existem pedidos pendentes com prioridade maior antes de aceitar este
    $sql = "SELECT id FROM pedidos 
            WHERE status = 'pendente' 
            ORDER BY FIELD(prioridade, 'alta', 'media', 'baixa'), data_criacao ASC";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $primeiro_pedido = $result->fetch_assoc();
        
        if ($primeiro_pedido['id'] != $pedido_id) {
            echo json_encode(['success' => false, 'message' => 'Você deve aceitar primeiro as solicitações com prioridade mais alta.']);
            exit;
        }
    }

    // Buscar técnico disponível
    $sql = "SELECT id FROM users 
            WHERE papel = 'tecnico' 
            AND (status = 'disponivel' OR status IS NULL)
            ORDER BY RAND() 
            LIMIT 1";
    
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $tecnico = $result->fetch_assoc();
        $tecnico_id = $tecnico['id'];
        
        $conn->begin_transaction();
        
        try {
            // Atualizar solicitação
            $sql = "UPDATE pedidos 
                    SET status = 'atribuido', 
                        tecnico_id = ?, 
                        data_actualizacao = NOW() 
                    WHERE id = ? 
                    AND status = 'pendente'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $tecnico_id, $pedido_id);
            $stmt->execute();
            
            if($stmt->affected_rows > 0) {
                // Atualizar status do técnico
                $sql = "UPDATE users 
                       SET status = 'ocupado' 
                       WHERE id = ? 
                       AND papel = 'tecnico'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $tecnico_id);
                $stmt->execute();
                
                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Solicitação aprovada e técnico atribuído com sucesso!']);
            } else {
                throw new Exception('Solicitação já foi processada');
            }
        } catch(Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhum técnico disponível no momento']);
    }
}

?>
