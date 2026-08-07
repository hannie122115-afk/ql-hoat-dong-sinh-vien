// =================updateChart - dashboard============
let orgChart = null;

function loadChart() {
  const bodyData =
    typeof filterStatistic !== "undefined" ? filterStatistic : {};
  fetch("pages/chart-data.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(bodyData),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.chart && data.chart.length > 0) {
        updateChart(data.chart);
      } else {
        // Nếu không có dữ liệu, xóa chart cũ đi cho đỡ bị treo
        if (orgChart) {
          orgChart.destroy();
        }
      }
    })
    .catch((err) => console.error("Lỗi:", err));
}

function updateChart(chartData) {
  const labels = chartData.map((item) => item.TenToChuc);
  const dataSoHoatDong = chartData.map((item) => item.SoHoatDong);

  if (orgChart) {
    orgChart.destroy();
  }

  const ctx = document.getElementById("orgChart").getContext("2d");

  orgChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Số hoạt động",
          data: dataSoHoatDong,
          backgroundColor: "#2563eb",
          hoverBackgroundColor: "#1d4ed8",
          borderRadius: 6,
          borderSkipped: false,
          barPercentage: 0.6,
          categoryPercentage: 0.5,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "top",
          align: "end",
          labels: {
            usePointStyle: true,
            boxWidth: 8,
            boxHeight: 8,
            font: { size: 12, weight: "500" },
            padding: 15,
          },
        },
        tooltip: {
          backgroundColor: "#1e293b",
          titleFont: { size: 13 },
          bodyFont: { size: 12 },
          padding: 10,
          cornerRadius: 8,
          mode: "index",
          intersect: false,
        },
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: {
            autoSkip: false,
            maxRotation: 0,
            minRotation: 0,
            color: "#64748b",
            font: { size: 11 },
            callback: function (value) {
              const label = this.getLabelForValue(value);
              if (!label) return "";

              const maxLength = 12;
              if (label.length > maxLength) {
                const words = label.split(" ");
                const lines = [];
                let currentLine = "";

                words.forEach((word) => {
                  if ((currentLine + " " + word).trim().length > maxLength) {
                    if (currentLine) lines.push(currentLine.trim());
                    currentLine = word;
                  } else {
                    currentLine += " " + word;
                  }
                });
                if (currentLine) lines.push(currentLine.trim());
                return lines;
              }
              return label;
            },
          },
        },
        y: {
          beginAtZero: true,
          grid: {
            color: "#f1f5f9",
            borderDash: [4, 4],
          },
          ticks: {
            color: "#64748b",
            precision: 0,
          },
        },
      },
    },
  });
}

// =================createNewAccount4Org - account============

document.addEventListener("submit", (e) => {
  if (e.target.id !== "accountForm") return;
  e.preventDefault();
  const formData = new FormData(e.target);

  fetch("pages/account.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert(data.message);
        sessionStorage.setItem("reloadAndLoadPage", "pages/account.php");
        location.reload();
      } else {
        alert(data.message);
      }
    })
    .catch(console.error);
});

// =================search - account============
document.addEventListener("click", (e) => {
  const dropdownSelected = e.target.closest(".account-dropdown-selected");
  if (dropdownSelected) {
    const dropdownMenu = dropdownSelected.nextElementSibling;
    dropdownMenu?.classList.toggle("show");
    return;
  }

  const option = e.target.closest(".account-dropdown-option");
  if (option) {
    const container = option.closest(".account-search-container");
    if (!container) return;

    const selectedText = container.querySelector(".account-selected-text");
    const dropdownMenu = container.querySelector(".account-dropdown-menu");

    const searchInput = container.querySelector(".account-search-input");
    const suggestBox = container.querySelector(".account-suggest-box");

    selectedText.textContent = option.textContent;

    if (option.dataset.value === "unit") {
      searchInput.dataset.type = "unit";
      searchInput.dataset.value = "account";
      searchInput.placeholder = "Tìm kiếm tên đơn vị...";
    } else {
      searchInput.dataset.type = "account";
      searchInput.removeAttribute("data-value");
      searchInput.placeholder = "Tìm kiếm tên tổ chức / sinh viên...";
    }

    searchInput.value = "";
    delete searchInput.dataset.id;

    if (suggestBox) {
      suggestBox.innerHTML = "";
    }
    dropdownMenu.classList.remove("show");
    return;
  }

  if (!e.target.closest(".account-custom-dropdown")) {
    document.querySelectorAll(".account-dropdown-menu.show").forEach((menu) => {
      menu.classList.remove("show");
    });
  }
});

function searchAccount() {
  const input = document.getElementById("searchInput");
  const keyword = input.value.trim();
  const type = input.dataset.type;

  let queryUrl =
    `pages/account.php?keyword=${encodeURIComponent(keyword)}` +
    `&type=${encodeURIComponent(type)}`;

  loadPage(queryUrl);
}

document.addEventListener("click", function (e) {
  const btn = e.target.closest("#btn-search-account");
  if (!btn) return;
  e.preventDefault();
  searchAccount();
});
document.addEventListener("keydown", function (e) {
  const input = e.target.closest("#searchInput");
  if (!input) return;
  if (e.key === "Enter") {
    e.preventDefault();
    searchAccount();
  }
});

// =================popupDeleteAcoount - account============
let deleteAccountId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".delete-account-btn");
  if (!btn) return;
  deleteAccountId = btn.dataset.id;
  document.getElementById("delete-account-message").textContent =
    `Bạn có chắc chắn muốn xóa tài khoản "${btn.dataset.name}"?`;
  document.getElementById("delete-account-modal").classList.add("show");
});

document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-confirm-delete-account");
  if (!btn) return;
  fetch("../includes/delete-account.php", {
    method: "POST",
    body: new URLSearchParams({
      id: deleteAccountId,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Xóa tài khoảng thành công!");
        loadPage("pages/account.php");
      } else {
        alert(data.message);
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-delete-account");
  if (!btnCancel) return;
  document.getElementById("delete-account-modal").classList.remove("show");
});

// =================popupBlockAccount - account============
let blockAccountId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".block-account-btn");
  if (!btn) return;
  blockAccountId = btn.dataset.id;
  document.getElementById("block-account-message").textContent =
    `Bạn có chắc chắn muốn khóa tài khoản "${btn.dataset.name}"?`;
  document.getElementById("block-account-modal").classList.add("show");
});

document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-confirm-block-account");
  if (!btn) return;
  fetch("../includes/block-account.php", {
    method: "POST",
    body: new URLSearchParams({
      id: blockAccountId,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Khóa tài khoản thành công!");
        loadPage("pages/account.php");
      } else {
        alert(data.message);
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-block-account");
  if (!btnCancel) return;
  document.getElementById("block-account-modal").classList.remove("show");
});

// =================popupUnblockAccount - account============
let unblockAccountId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".unblock-account-btn");
  if (!btn) return;
  unblockAccountId = btn.dataset.id;
  document.getElementById("unblock-account-message").textContent =
    `Bạn có chắc chắn muốn mở khóa tài khoản "${btn.dataset.name}"?`;
  document.getElementById("unblock-account-modal").classList.add("show");
});

document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-confirm-unblock-account");
  if (!btn) return;
  fetch("../includes/unblock-account.php", {
    method: "POST",
    body: new URLSearchParams({
      id: unblockAccountId,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Mở khóa tài khoản thành công!");
        loadPage("pages/account.php");
      } else {
        alert(data.message);
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-unblock-account");
  if (!btnCancel) return;
  document.getElementById("unblock-account-modal").classList.remove("show");
});
