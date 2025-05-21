<p>Quản lý danh mục bài viết</p>
<p>Test thêm chức năng giao vận đơn.</p>

<body>
<label for="store_province">Tỉnh/Thành phố cửa hàng:</label>
<select id="store_province" onchange="fetchStoreDistricts()">
    <option value="">Chọn tỉnh/thành phố</option>
</select>

<label for="store_district">Quận/Huyện cửa hàng:</label>
<select id="store_district" onchange="fetchStoreWards()">
    <option value="">Chọn quận/huyện</option>
</select>

<label for="store_ward">Phường/Xã cửa hàng:</label>
<select id="store_ward">
    <option value="">Chọn phường/xã</option>
</select>

<hr>

<label for="customer_province">Tỉnh/Thành phố khách hàng:</label>
<select id="customer_province" onchange="fetchCustomerDistricts()">
    <option value="">Chọn tỉnh/thành phố</option>
</select>

<label for="customer_district">Quận/Huyện khách hàng:</label>
<select id="customer_district" onchange="fetchCustomerWards()">
    <option value="">Chọn quận/huyện</option>
</select>

<label for="customer_ward">Phường/Xã khách hàng:</label>
<select id="customer_ward">
    <option value="">Chọn phường/xã</option>
</select>

<label for="product_weight">Trọng lượng sản phẩm (gram):</label>
<input type="number" id="product_weight" placeholder="Nhập trọng lượng sản phẩm">

<label for="product_width">Chiều rộng (cm):</label>
<input type="number" id="product_width" placeholder="Nhập chiều rộng sản phẩm">

<label for="product_height">Chiều cao (cm):</label>
<input type="number" id="product_height" placeholder="Nhập chiều cao sản phẩm">

<label for="product_length">Chiều dài (cm):</label>
<input type="number" id="product_length" placeholder="Nhập chiều dài sản phẩm">

<label for="shipping_service">Hình thức giao hàng:</label>
<select id="shipping_service" onchange="calculateShippingFee()">
    <option value="">Chọn hình thức giao hàng</option>
</select>

<p id="shipping_fee"></p>

<button onclick="calculateShippingFee()">Tính phí giao hàng</button>

<p id="shipping_fee"></p>

<script>
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; // Thay bằng API Key thực tế

// Hàm gọi API GHN để tải danh sách tỉnh/thành phố
function loadProvinces() {
    const provinceLists = ["store_province", "customer_province"]; // Các thẻ <select>
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";

    fetch(apiUrl, {
        method: "GET",
        headers: { "Token": apiKey }
    })
    .then(response => response.json())
    .then(data => {
        provinceLists.forEach(selectId => {
            const selectElement = document.getElementById(selectId);
            selectElement.innerHTML = "<option value=''>Chọn tỉnh/thành phố</option>";

            data.data.forEach(province => {
                let option = document.createElement("option");
                option.value = province.ProvinceID;
                option.textContent = province.ProvinceName;
                selectElement.appendChild(option);
            });
        });
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}

// Hàm gọi API GHN để tải danh sách quận/huyện dựa trên tỉnh/thành phố
function fetchDistricts(provinceSelectId, districtSelectId) {
    const provinceSelect = document.getElementById(provinceSelectId);
    const selectedProvince = parseInt(provinceSelect.value, 10);
    const districtSelect = document.getElementById(districtSelectId);
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";

    districtSelect.innerHTML = "<option value=''>Chọn quận/huyện</option>";
    if (!selectedProvince) return;

    fetch(apiUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json", "Token": apiKey },
        body: JSON.stringify({ province_id: selectedProvince })
    })
    .then(response => response.json())
    .then(data => {
        data.data.forEach(district => {
            let option = document.createElement("option");
            option.value = district.DistrictID;
            option.textContent = district.DistrictName;
            districtSelect.appendChild(option);
        });
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}

// Hàm gọi API GHN để tải danh sách phường/xã dựa trên quận/huyện
function fetchWards(districtSelectId, wardSelectId) {
    const districtSelect = document.getElementById(districtSelectId);
    const selectedDistrict = parseInt(districtSelect.value, 10);
    const wardSelect = document.getElementById(wardSelectId);
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward";

    wardSelect.innerHTML = "<option value=''>Chọn phường/xã</option>";
    if (!selectedDistrict) return;

    fetch(apiUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json", "Token": apiKey },
        body: JSON.stringify({ district_id: selectedDistrict })
    })
    .then(response => response.json())
    .then(data => {
        data.data.forEach(ward => {
            let option = document.createElement("option");
            option.value = ward.WardCode;
            option.textContent = ward.WardName;
            wardSelect.appendChild(option);
        });
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}


function calculateShippingFee() {

    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee";
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; 
    const shopId = parseInt("5774843", 10); // 🔥 Đảm bảo là số nguyên

    const fromDistrict = parseInt(document.getElementById("store_district").value, 10);
    const toDistrict = parseInt(document.getElementById("customer_district").value, 10);
    const serviceId = 53320;

    const weight = parseInt(document.getElementById("product_weight").value, 10);
    const width = parseInt(document.getElementById("product_width").value, 10);
    const height = parseInt(document.getElementById("product_height").value, 10);
    const length = parseInt(document.getElementById("product_length").value, 10);

    // Kiểm tra nếu thiếu dữ liệu
    if (!shopId || !fromDistrict || !toDistrict || !serviceId || !weight || !width || !height || !length) {
        console.error("Thiếu dữ liệu khi gửi API GHN!", { shopId, fromDistrict, toDistrict, serviceId, weight, width, height, length });
        alert("Vui lòng nhập đầy đủ thông tin!");
        return;
    }

    console.log("Gửi yêu cầu API GHN với:", { shopId, fromDistrict, toDistrict, serviceId, weight, width, height, length });

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Token": apiKey
        },
        body: JSON.stringify({
            shop_id: shopId,
            from_district_id: fromDistrict,
            to_district_id: toDistrict,
            service_id: serviceId,
            weight: weight,
            width: width,
            height: height,
            length: length
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Lỗi API GHN: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.data) {
            document.getElementById("shipping_fee").innerHTML = `📦 Phí giao hàng: <strong>${data.data.total} VND</strong>`;
        } else {
            console.error("Không có dữ liệu từ API GHN!");
        }
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}



// Hàm lấy danh sách dịch vụ giao hàng từ GHN
function fetchShippingServices() {
    const apiUrl = "https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/available-services";
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d"; 

    const fromDistrict = parseInt(document.getElementById("store_district").value, 10);
    const toDistrict = parseInt(document.getElementById("customer_district").value, 10);

    if (!fromDistrict || !toDistrict) {
        console.error("Thiếu thông tin địa chỉ để lấy dịch vụ giao hàng!");
        return;
    }

    console.log("Gửi yêu cầu API GHN để lấy dịch vụ giao hàng với:", { fromDistrict, toDistrict });

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Token": apiKey
        },
        body: JSON.stringify({
            from_district: fromDistrict,
            to_district: toDistrict
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Lỗi API GHN: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const serviceSelect = document.getElementById("shipping_service");
        serviceSelect.innerHTML = "<option value=''>Chọn hình thức giao hàng</option>";

        if (data.data) {
            data.data.forEach(service => {
                let option = document.createElement("option");
                option.value = service.service_id;
                option.textContent = `${service.name} - ${service.service_type_id}`;
                serviceSelect.appendChild(option);
            });
        } else {
            console.error("Không có dữ liệu hình thức giao hàng từ API GHN!");
        }
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}


function calculateShippingFee() {
    const apiUrl = "https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee";
    const apiKey = "2156da59-2fc6-11f0-ae7f-0ebaff1a480d";
    const shopId = parseInt("5774843", 10); // 🔥 Đảm bảo là số nguyên

    const fromDistrict = parseInt(document.getElementById("store_district").value, 10);
    const toDistrict = parseInt(document.getElementById("customer_district").value, 10);
    const selectedService = document.getElementById("shipping_service").value; // 🔥 Hình thức giao hàng

    const weight = parseInt(document.getElementById("product_weight").value, 10);
    const width = parseInt(document.getElementById("product_width").value, 10);
    const height = parseInt(document.getElementById("product_height").value, 10);
    const length = parseInt(document.getElementById("product_length").value, 10);

    // Kiểm tra nếu thiếu dữ liệu
    if (!shopId || !fromDistrict || !toDistrict || !selectedService || !weight || !width || !height || !length) {
        console.error("Thiếu dữ liệu khi gửi API GHN!", { shopId, fromDistrict, toDistrict, selectedService, weight, width, height, length });
        alert("Vui lòng nhập đầy đủ thông tin!");
        return;
    }

    console.log("Gửi yêu cầu API GHN với:", { shopId, fromDistrict, toDistrict, selectedService, weight, width, height, length });

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Token": apiKey
        },
        body: JSON.stringify({
            shop_id: shopId,
            from_district_id: fromDistrict,
            to_district_id: toDistrict,
            service_id: parseInt(selectedService, 10), // 🔥 Hình thức giao hàng
            weight: weight,
            width: width,
            height: height,
            length: length
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.data) {
            document.getElementById("shipping_fee").innerHTML = `📦 Phí giao hàng: <strong>${data.data.total} VND</strong>`;
        } else {
            console.error("Không có dữ liệu từ API GHN!");
        }
    })
    .catch(error => console.error("Lỗi khi gọi API GHN:", error));
}




// Gọi các hàm riêng biệt cho địa chỉ cửa hàng & khách hàng
function fetchStoreDistricts() { fetchDistricts("store_province", "store_district"); }
function fetchStoreWards() { fetchWards("store_district", "store_ward"); }
function fetchCustomerDistricts() { fetchDistricts("customer_province", "customer_district"); }
function fetchCustomerWards() { fetchWards("customer_district", "customer_ward"); }

// Tải danh sách tỉnh/thành phố khi trang tải xong
window.onload = loadProvinces;

</script>





</body>
