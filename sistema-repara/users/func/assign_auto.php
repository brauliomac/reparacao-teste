<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $request_id = intval($_GET['id']);
} else {
    die("Solicitação inválida.");
}

$sql = "SELECT u.id, COUNT(r.id) AS pending_count
        FROM users u
        LEFT JOIN requests r ON u.id = r.technician_id AND r.status = 'in_progress'
        WHERE u.role = 'technician'
        GROUP BY u.id
        ORDER BY pending_count ASC
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows == 1) {
    $tech = $result->fetch_assoc();
    $technician_id = $tech['id'];
    
    $updateSql = "UPDATE requests SET technician_id = $technician_id, status = 'in_progress' WHERE id = $request_id";
    if ($conn->query($updateSql) === TRUE) {
        header("Location: employee_dashboard.php");
        exit;
    } else {
        echo "Erro ao atualizar a solicitação: " . $conn->error;
    }
} else {
    echo "Nenhum técnico disponível.";
}
?>
