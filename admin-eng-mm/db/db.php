<?php
$servername = "localhost";
$username = "root";      
$password = "";         
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Erro ao conectar a base de dados: " . $conn->connect_error);
}
?>
