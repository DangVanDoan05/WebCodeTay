<p>Thêm danh mục sản phẩm</p>
<table border="1" width="50%" style="border-collapse: collapse;">
 <form method="POST" action="modules/quanlydanhmucsp/xuly.php"> 
    <!-- Cấu trúc Form để truyền dữ liệu đi. -->
    <!-- Phương thức GET để lấy dữ liệu trên đường dẫn., phương thức POST để không thấy được dữ liệu trên đường dẫn. -->
    <!-- Thuộc tính Action trong Form để chỉ đường dẫn đến trang xử lý. -->
  <tr>
    <td>Tên danh mục</td>
    <td><input type="text" name="tendanhmuc"></td>
  </tr>
  <tr>
    <td>Thứ tự</td>
    <td><input type="text" name="thutu"></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="themdanhmuc" value="Thêm danh mục sản phẩm"></td>
  </tr>
  </form>
</table>