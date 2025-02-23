<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$role = $_SESSION['role'];

if($role == 'client'){
    header("Location: ../users/cliente/client_dashboard.php");
    exit;
} elseif($role == 'employee'){
    header("Location: ../users/func/employee_dashboard.php");
    exit;
} elseif($role == 'technician'){
    header("Location: ../users/tecnico/technician_dashboard.php");
    exit;
}  elseif($role == 'admin'){
    header("Location: ../users/admin/admin_dashboard.php");
    exit;
}else {
    echo "Função de usuário inválida.";
}
?>
