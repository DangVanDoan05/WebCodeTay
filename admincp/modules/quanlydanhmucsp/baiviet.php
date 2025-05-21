<p>Test ghn</p>
<body>
<label for="province">Tỉnh/Thành phố:</label>
<select id="province" onchange="fetchDistrictsFromAPI()">
    <option value="">Chọn tỉnh/thành phố</option>
</select>

<label for="district">Quận/Huyện:</label>
<select id="district" onchange="fetchWardsFromAPI()">
    <option value="">Chọn quận/huyện</option>
</select>

<label for="ward">Phường/Xã:</label>
<select id="ward">
    <option value="">Chọn phường/xã</option>
</select>
<script>
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; // Thay thế bằng API Key của GHN

// Hàm gọi API GHN để lấy danh sách tỉnh/thành phố
function loadProvincesFromAPI() {
    const provinceSelect = document.getElementById("province");
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";

    fetch(apiUrl, {
        method: "GET",
        headers: {
            "Token": apiKey
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.data) {
            data.data.forEach(province => {
                let option = document.createElement("option");
                option.value = province.ProvinceID; // ID của tỉnh
                option.textContent = province.ProvinceName; // Tên tỉnh
                provinceSelect.appendChild(option);
            });
        }
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}

// Hàm gọi API GHN để lấy danh sách quận/huyện dựa trên tỉnh đã chọn
function fetchDistrictsFromAPI() {
    const provinceSelect = document.getElementById("province");
    let selectedProvince = provinceSelect.value;
    const districtSelect = document.getElementById("district");
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; // Thay thế bằng API Key thực tế

    // Xóa danh sách cũ
    districtSelect.innerHTML = "<option value=''>Chọn quận/huyện</option>";

    if (!selectedProvince) {
        console.warn("Chưa chọn tỉnh/thành phố!");
        return;
    }

    // Ép kiểu thành số nguyên
    selectedProvince = parseInt(selectedProvince, 10);
    console.log("Gửi yêu cầu API với province_id:", selectedProvince);

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Token": apiKey
        },
        body: JSON.stringify({ province_id: selectedProvince }) // 🔥 Đảm bảo gửi số nguyên
    })
    .then(response => response.json())
    .then(data => {
        console.log("Dữ liệu quận/huyện từ API:", data);

        if (data.data) {
            data.data.forEach(district => {
                let option = document.createElement("option");
                option.value = district.DistrictID;
                option.textContent = district.DistrictName;
                districtSelect.appendChild(option);
            });
        } else {
            console.error("Không có dữ liệu quận/huyện từ API!");
        }
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}



// Hàm gọi API GHN để lấy danh sách phường/xã dựa trên quận/huyện đã chọn
function fetchWardsFromAPI() {
    const districtSelect = document.getElementById("district");
    const selectedDistrict = districtSelect.value;
    const wardSelect = document.getElementById("ward");
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward";
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; // Thay thế bằng API Key thực tế

    // Xóa danh sách cũ
    wardSelect.innerHTML = "<option value=''>Chọn phường/xã</option>";

    if (!selectedDistrict) {
        console.warn("Chưa chọn quận/huyện!");
        return;
    }

    console.log("Gửi yêu cầu API với district_id:", selectedDistrict);

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Token": apiKey // 🔥 Đảm bảo API Key chính xác
        },
        body: JSON.stringify({ district_id: parseInt(selectedDistrict, 10) }) // 🔥 Ép kiểu ID thành số nguyên
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Lỗi kết nối API GHN: " + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log("Dữ liệu phường/xã từ API:", data); // Kiểm tra dữ liệu trả về

        if (data.data) {
            data.data.forEach(ward => {
                let option = document.createElement("option");
                option.value = ward.WardCode;
                option.textContent = ward.WardName;
                wardSelect.appendChild(option);
            });
        } else {
            console.error("Không có dữ liệu phường/xã từ API!");
        }
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}


// Gọi API GHN để tải danh sách tỉnh/thành phố khi trang tải
window.onload = loadProvincesFromAPI;

</script>





</body>

