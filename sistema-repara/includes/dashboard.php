<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$papel = $_SESSION['papel'];

if($papel == 'cliente'){
    header("Location: ../users/cliente/cliente_dashboard.php");
    exit;
} elseif($papel == 'funcionario'){
    header("Location: ../users/func/funcionario_dashboard.php");
    exit;
} elseif($papel == 'tecnico'){
    header("Location: ../users/tecnico/tecnico_dashboard.php");
    exit;
}  elseif($papel == 'admin'){
    header("Location: ../users/admin/admin_dashboard.php");
    exit;
}else {
    echo "Função de usuário inválida.";
}
?>
