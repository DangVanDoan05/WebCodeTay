<?php
# Mã lệnh để kết nối cơ sở dữ liệu mà mình tạo

$mysqli = new mysqli("localhost","root","","webcodetay");

// Check connection
if ($mysqli->connect_errno) {
  echo "Kết nối MYSQLi lỗi." .$mysqli->connect_error;
  exit();
}

?>