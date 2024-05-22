<?php
require '../model/DB.php'; // Tệp kết nối cơ sở dữ liệu
$query = $conn->query("SELECT MaHSX as id, TenHSX as name FROM HangSanXuat");
echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>
