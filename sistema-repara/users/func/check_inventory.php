<?php
include '../../db.php';

$threshold = 5; // Limite mínimo para o componente
$sql = "SELECT * FROM inventory WHERE quantity < $threshold";
$result = $conn->query($sql);

if($result->num_rows > 0){
   while($row = $result->fetch_assoc()){
       $component_id = $row['id'];
       $quantity_needed = $threshold - $row['quantity'];
       
       // Verifica se já existe um pedido pendente para o componente
       $checkSql = "SELECT * FROM purchase_requests WHERE component_id = $component_id AND status = 'pending'";
       $checkResult = $conn->query($checkSql);
       if($checkResult->num_rows == 0){
           $insertSql = "INSERT INTO purchase_requests (component_id, quantity_needed) VALUES ($component_id, $quantity_needed)";
           $conn->query($insertSql);
       }
   }
}
// Após verificar, redireciona de volta à página de estoque (ou outra página desejada)
header("Location: inventory.php");
exit;
?>
