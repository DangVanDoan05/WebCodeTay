<?php
include('../../config/config.php');

$tenloaisp = $_POST['tendanhmuc']; 
// Lấy trùng với phần Name của phần Input để lấy ra được tên biến
$thutu= $_POST['thutu'];
if(isset($_POST['themdanhmuc']))
// isset là tồn tại
// Nếu có Click vào nút thêm danh mục.
{
    $sql_them = "INSERT INTO tbl_danhmuc(tendanhmuc,thutu) VALUE('".$tenloaisp."','".$thutu."')";
    mysqli_query($mysqli,$sql_them);
    header('Location:../../index.php?action=quanlydanhmucsanpham');
}

?>