<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if(isset($_POST['request_id']) && isset($_POST['technician_id'])){
    $request_id = intval($_POST['request_id']);
    $technician_id = intval($_POST['technician_id']);

    $sql = "UPDATE requests SET technician_id = $technician_id, status = 'in_progress' WHERE id = $request_id";
    if($conn->query($sql) === TRUE){
        header("Location: employee_dashboard.php");
        exit;
    } else {
        echo "Erro ao atribuir técnico: " . $conn->error;
    }
} else {
    echo "Dados inválidos.";
}
?>
