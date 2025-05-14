<?php
    $sql_lietke_danhmucsp="SELECT * FROM tbl_danhmuc ORDER BY thutu DESC";
    // lấy có sắp xếp từ cao đến thấp.
    $row_lietke_danhmucsp = mysqli_query($mysqli,$sql_lietke_danhmucsp);
    // Hàm mysqli_query( xác định kết nối đến CSDL nào,Câu lệnh muốn thực hiện với CSDL. )
?>

<p>Liệt kê danh mục sản phẩm</p>
<table style="width:100%" border="1"  style="border-collapse: collapse">
  <tr>
    <th>Tên danh mục</th>
    <th>Thứ tự</th>
   
  </tr>

  <tr>
    <td>Jill</td>
    <td>Smith</td>
   
  </tr>

</table>