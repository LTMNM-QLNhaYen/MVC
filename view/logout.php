<?php
session_start();

// Hủy bỏ tất cả các biến session
$_SESSION = array();

// Hủy bỏ phiên làm việc
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập hoặc trang chính
header("Location: Login_Admin.php");
exit();
?>
