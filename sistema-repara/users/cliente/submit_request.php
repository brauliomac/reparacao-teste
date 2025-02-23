<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'client'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if(isset($_POST['description']) && isset($_POST['priority'])){
    $description = $conn->real_escape_string($_POST['description']);
    $priority = $conn->real_escape_string($_POST['priority']);
    $client_id = $_SESSION['user_id'];

    $sql = "INSERT INTO requests (client_id, description, priority) VALUES ($client_id, '$description', '$priority')";
    if($conn->query($sql) === TRUE){
        header("Location: client_dashboard.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
} else {
    echo "Descrição é obrigatória.";
}
?>
