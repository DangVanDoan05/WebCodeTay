<p>Welcome to dashboard</p>
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

    <script>
        const token = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; // Thay thế bằng token hợp lệ của bạn

        async function fetchProvinces() {
            const url = "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";
            const response = await fetch(url, {
                method: "GET",
                headers: { "Content-Type": "application/json", "Token": token }
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
            const provinceId = document.getElementById("province").value;
            if (!provinceId) return;
            const url = "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json", "Token": token },
                body: JSON.stringify({ province_id: provinceId })
            });
            const data = await response.json();
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

        fetchProvinces();
    </script>