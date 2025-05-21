<?php
    $sql_lietke_danhmucsp="SELECT * FROM tbl_danhmuc ORDER BY thutu DESC";
    // lấy có sắp xếp từ cao đến thấp.
    $row_lietke_danhmucsp = mysqli_query($mysqli,$sql_lietke_danhmucsp);
    // Hàm mysqli_query( xác định kết nối đến CSDL nào,Câu lệnh muốn thực hiện với CSDL. )
?>
<body>
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
<h2>Thông tin giao hàng</h2>
    <label for="province">Tỉnh/Thành phố:</label>
    <select id="province" onchange="fetchDistricts()">
        <option value="">Chọn tỉnh/thành phố</option>
    </select>

    <label for="district">Quận/Huyện:</label>
    <select id="district" onchange="fetchWards()">
        <option value="">Chọn quận/huyện</option>
    </select>

    <label for="ward">Xã/Phường/Thị trấn:</label>
    <select id="ward">
        <option value="">Chọn xã/phường/thị trấn</option>
    </select>

    <label for="address">Địa chỉ chi tiết:</label>
    <input type="text" id="address" placeholder="Nhập địa chỉ chi tiết">

    <button onclick="calculateShippingFee()">Tính phí giao hàng</button>
    <p id="shippingFee"></p>



    <script> // Nó đổ dữ liệu vào kiểu gì nhỉ.
        const token = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; // Thay thế bằng token hợp lệ của bạn

        async function fetchProvinces() {
            const url = "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";
            const response = await fetch(url, {
                method: "GET",
                headers: { "Content-Type" : "application/json", "Token": token }
            });
            const data = await response.json();
            if (data.code === 200) {
                const select = document.getElementById("province");
                data.data.forEach(province => {
                    const option = document.createElement("option");
                    option.value = province.ProvinceID;
                    option.textContent = province.ProvinceName;
                    select.appendChild(option);
                });
            }
        }

        async function fetchDistricts() {
            const provinceId = document.getElementById('province').value;
            console.log(provinceId);
            if (!provinceId) return;
 
            const url = "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";
            const response = await fetch(url, {
                method: "POST",
              
                headers: { "Content-Type": "application/json", "Token": token },
                body: JSON.stringify({ province_id: provinceId })
            });
            console.log(response);
            const data = await response.json();
            console.log(data.data)
            if (data.code === 200) {
                const select = document.getElementById("district");
                select.innerHTML = "<option value=''>Chọn quận/huyện</option>";
                data.data.forEach(district => {
                    const option = document.createElement("option");
                    option.value = district.DistrictID;
                    option.textContent = district.DistrictName;
                    select.appendChild(option);
                });
            }
        }

        async function fetchWards() {
            const districtId = document.getElementById("district").value;
            if (!districtId) return;
            const url = "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward";
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json", "Token": token },
                body: JSON.stringify({ district_id: districtId })
               
            });
            const data = await response.json();
            if (data.code === 200) {
                const select = document.getElementById("ward");
                select.innerHTML = "<option value=''>Chọn xã/phường/thị trấn</option>";
                data.data.forEach(ward => {
                    const option = document.createElement("option");
                    option.value = ward.WardCode;
                    option.textContent = ward.WardName;
                    select.appendChild(option);
                });
            }
        }

        async function calculateShippingFee() {
            const fromDistrict = "2045"; // Thay thế bằng ID quận/huyện của shop
            const toDistrict = document.getElementById("district").value;
            if (!toDistrict) return alert("Vui lòng chọn địa chỉ đầy đủ!");

            const url = "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee";
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json", "Token": token },
                body: JSON.stringify({
                    from_district_id: fromDistrict,
                    to_district_id: toDistrict,
                    service_id: 53320, // ID dịch vụ giao hàng
                    weight: 1000, // Trọng lượng gói hàng (gram)
                    length: 30,
                    width: 20,
                    height: 10
                })
            });

            const data = await response.json();
            if (data.code === 200) {
                document.getElementById("shippingFee").textContent = `Phí giao hàng: ${data.data.total} VND`;
            } else {
                alert("Không thể tính phí giao hàng!");
            }
        }

        fetchProvinces();
    </script>
</body>


