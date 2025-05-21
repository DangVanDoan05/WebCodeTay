document.addEventListener("DOMContentLoaded", () => {
  const provinceSelect = document.getElementById("province");
  const districtSelect = document.getElementById("district");
  const wardSelect = document.getElementById("ward");

  // **IMPORTANT: Replace with your actual GHN API Token**
  const GHN_API_TOKEN = "YOUR_GHN_API_TOKEN";
  const GHN_BASE_URL =
    "https://dev-online-gateway.ghn.vn/shipper-hub/public-api/master-data/";

  // Function to fetch provinces
  async function fetchProvinces() {
    try {
      const response = await fetch(`${GHN_BASE_URL}province`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Token: GHN_API_TOKEN,
        },
      });
      const data = await response.json();
      if (data.code === 200 && data.data) {
        populateSelect(provinceSelect, data.data, "ProvinceID", "ProvinceName");
      } else {
        console.error("Error fetching provinces:", data.message);
      }
    } catch (error) {
      console.error("Network error fetching provinces:", error);
    }
  }

  // Function to fetch districts based on province ID
  async function fetchDistricts(provinceId) {
    if (!provinceId) {
      districtSelect.innerHTML =
        '<option value="">-- Chọn Quận/Huyện --</option>';
      wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      return;
    }
    try {
      const response = await fetch(
        `${GHN_BASE_URL}district?province_id=${provinceId}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Token: GHN_API_TOKEN,
          },
        }
      );
      const data = await response.json();
      if (data.code === 200 && data.data) {
        populateSelect(districtSelect, data.data, "DistrictID", "DistrictName");
        // Clear wards when district changes
        wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      } else {
        console.error("Error fetching districts:", data.message);
      }
    } catch (error) {
      console.error("Network error fetching districts:", error);
    }
  }

  // Function to fetch wards based on district ID
  async function fetchWards(districtId) {
    if (!districtId) {
      wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
      return;
    }
    try {
      const response = await fetch(
        `${GHN_BASE_URL}ward?district_id=${districtId}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            Token: GHN_API_TOKEN,
          },
        }
      );
      const data = await response.json();
      if (data.code === 200 && data.data) {
        populateSelect(wardSelect, data.data, "WardCode", "WardName");
      } else {
        console.error("Error fetching wards:", data.message);
      }
    } catch (error) {
      console.error("Network error fetching wards:", error);
    }
  }

  // Helper function to populate select elements
  function populateSelect(selectElement, data, valueKey, textKey) {
    selectElement.innerHTML = `<option value="">-- Chọn ${selectElement.previousElementSibling.textContent.replace(
      ":",
      ""
    )} --</option>`;
    data.forEach((item) => {
      const option = document.createElement("option");
      option.value = item[valueKey];
      option.textContent = item[textKey];
      selectElement.appendChild(option);
    });
  }

  // Event listeners
  provinceSelect.addEventListener("change", (event) => {
    const provinceId = event.target.value;
    fetchDistricts(provinceId);
  });

  districtSelect.addEventListener("change", (event) => {
    const districtId = event.target.value;
    fetchWards(districtId);
  });

  // Initial fetch of provinces when the page loads
  fetchProvinces();
});
