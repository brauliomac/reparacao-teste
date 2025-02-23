<?php
session_start();
include '../db/db.php';

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        // Para produção, use funções de hash para senha (ex.: password_verify)
        if($user['password'] == $password){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            header("Location: dashboard.php");
            exit;
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "Preencha todos os campos.";
}
?>
