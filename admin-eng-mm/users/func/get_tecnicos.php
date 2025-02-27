<?php
session_start();
include '../../db/db.php';

$sql = "SELECT id, name FROM users 
        WHERE papel = 'tecnico' 
        AND (status = 'disponivel' OR status IS NULL)
        ORDER BY name";

$result = $conn->query($sql);

$response = array();
if($result->num_rows > 0) {
    $tecnicos = array();
    while($row = $result->fetch_assoc()) {
        $tecnicos[] = $row;
    }
    $response['success'] = true;
    $response['tecnicos'] = $tecnicos;
} else {
    $response['success'] = false;
    $response['message'] = 'Nenhum técnico disponível no momento';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
