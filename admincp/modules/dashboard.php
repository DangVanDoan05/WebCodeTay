<body>  
<label for="province">Tỉnh/Thành phố:</label>
<select id="province" onchange="fetchDistricts()">
    <option value="">Chọn tỉnh/thành phố</option>
</select>

<label for="district">Quận/Huyện:</label>
<select id="district">
    <option value="">Chọn quận/huyện</option>
</select>

<script>

// Danh sách quận/huyện theo từng tỉnh/thành phố
const districtsData = {
    hanoi: ["Ba Đình", "Hoàn Kiếm", "Hai Bà Trưng", "Đống Đa"],
    hcm: ["Quận 1", "Quận 3", "Quận 5", "Quận 10"],
    danang: ["Hải Châu", "Thanh Khê", "Sơn Trà", "Ngũ Hành Sơn"],
    haiphong: ["Hồng Bàng", "Ngô Quyền", "Lê Chân", "Hải An"],
    cantho: ["Ninh Kiều", "Bình Thủy", "Cái Răng", "Ô Môn"]
};

// Danh sách tỉnh/thành phố
const provinces = [
    { code: "hanoi", name: "Hà Nội" },
    { code: "hcm", name: "TP. Hồ Chí Minh" },
    { code: "danang", name: "Đà Nẵng" },
    { code: "haiphong", name: "Hải Phòng" },
    { code: "cantho", name: "Cần Thơ" }
];

// Hàm để tải danh sách tỉnh/thành phố vào thẻ `<select>`
function loadProvinces() {
    const provinceSelect = document.getElementById("province");

    provinces.forEach(province => {
        let option = document.createElement("option");
        option.value = province.code;
        option.textContent = province.name;
        provinceSelect.appendChild(option);
    });
}

// Hàm để cập nhật danh sách quận/huyện khi chọn tỉnh/thành phố
function fetchDistricts() {
    const provinceSelect = document.getElementById("province");
    const selectedProvince = provinceSelect.value;
    const districtSelect = document.getElementById("district");

    // Xóa các tùy chọn cũ
    districtSelect.innerHTML = "<option value=''>Chọn quận/huyện</option>";

    // Kiểm tra nếu có dữ liệu
    if (districtsData[selectedProvince]) {
        districtsData[selectedProvince].forEach(district => {
            let option = document.createElement("option");
            option.value = district.toLowerCase().replace(/\s/g, "-");
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }
}

// Chạy hàm khi trang tải xong
window.onload = loadProvinces;

</script>

</body>