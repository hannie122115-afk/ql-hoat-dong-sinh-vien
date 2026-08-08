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

  document.getElementById("notice-account-modal").classList.add("show");

  fetch("pages/account.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        // alert(data.message);
        // sessionStorage.setItem("reloadAndLoadPage", "pages/account.php");
        // location.reload();
        // loadPage("pages/account.php");
        document.getElementById("notice-account-message").textContent =
          data.message;
        document
          .getElementById("btn-cancel-notice-account")
          .classList.remove("hidden");
        document
          .getElementById("btn-cancel-notice-error-account")
          .classList.add("hidden");

        e.target.reset();
      } else {
        // alert(data.message);
        document.getElementById("notice-account-message").textContent =
          data.message;
        document
          .getElementById("btn-cancel-notice-error-account")
          .classList.remove("hidden");
        document
          .getElementById("btn-cancel-notice-account")
          .classList.add("hidden");
      }
    })
    .catch(console.error);
});
document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-notice-account");
  if (!btnCancel) return;
  document.getElementById("notice-account-modal").classList.remove("show");
  loadPage("pages/account.php");
});
document.addEventListener("click", (e) => {
  const btnCancelError = e.target.closest("#btn-cancel-notice-error-account");
  if (!btnCancelError) return;
  document.getElementById("notice-account-modal").classList.remove("show");
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

// =================popupDeleteAccount - account============
let deleteAccountId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".delete-account-btn");
  if (!btn) return;
  deleteAccountId = btn.dataset.id;
  document.getElementById("delete-account-message").textContent =
    `Bạn có chắc chắn muốn xóa tài khoản "${btn.dataset.name}"?`;
  document.getElementById("delete-account-modal").classList.add("show");
  if (
    document.getElementById("btn-confirm-delete-account").classList == "hidden"
  ) {
    document
      .getElementById("btn-confirm-delete-account")
      .classList.remove("hidden");
  }
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
        document.getElementById("delete-account-message").textContent =
          "Xóa tài khoản thành công!";
        document
          .getElementById("btn-confirm-delete-account")
          .classList.add("hidden");
        document.getElementById("delete-account-modal-title").textContent =
          "Thông báo";
        document.getElementById("btn-cancel-delete-account").textContent =
          "Đóng";
      } else {
        document.getElementById("delete-account-message").textContent =
          "Không thể xóa tài khoản!";
        document
          .getElementById("btn-confirm-delete-account")
          .classList.add("hidden");
        document.getElementById("delete-account-modal-title").textContent =
          "Lỗi";
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-delete-account");
  if (!btnCancel) return;
  document.getElementById("delete-account-modal").classList.remove("show");
  loadPage("pages/account.php");
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
        document.getElementById("block-account-message").textContent =
          "Khóa tài khoản thành công";
        document
          .getElementById("btn-confirm-block-account")
          .classList.add("hidden");
        document.getElementById("block-account-modal-title").textContent =
          "Thông báo";
        document.getElementById("btn-cancel-block-account").textContent =
          "Đóng";
      } else {
        document.getElementById("block-account-message").textContent =
          "Không thể khóa tài khoản!";
        document
          .getElementById("btn-confirm-block-account")
          .classList.add("hidden");
        document.getElementById("block-account-modal-title").textContent =
          "Lỗi";
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-block-account");
  if (!btnCancel) return;
  document.getElementById("block-account-modal").classList.remove("show");
  loadPage("pages/account.php");
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
        document.getElementById("unblock-account-message").textContent =
          "Mở khóa tài khoản thành công";
        document
          .getElementById("btn-confirm-unblock-account")
          .classList.add("hidden");
        document.getElementById("unblock-account-modal-title").textContent =
          "Thông báo";
        document.getElementById("btn-cancel-unblock-account").textContent =
          "Đóng";
      } else {
        document.getElementById("unblock-account-message").textContent =
          "Không thể mở khóa tài khoản!";
        document
          .getElementById("btn-confirm-unblock-account")
          .classList.add("hidden");
        document.getElementById("unblock-account-modal-title").textContent =
          "Lỗi";
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-unblock-account");
  if (!btnCancel) return;
  document.getElementById("unblock-account-modal").classList.remove("show");
  loadPage("pages/account.php");
});

// =================popupInfoAccount - account============
// let infoAccountId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".table-row-account");
  if (!btn) return;

  const accountName = btn.dataset.name || "Không có dữ liệu";
  const accountUnit = btn.dataset.unit || "Không có dữ liệu";
  const accountEmail = btn.dataset.email || "Không có dữ liệu";
  const accountDate = btn.dataset.date || "Không có dữ liệu";

  let accountStatus = "Đã khóa";
  if (btn.dataset.status == 1) {
    accountStatus = "Đang hoạt động";
  }

  let accountRole = "Sinh viên";
  if (btn.dataset.role == 1) {
    accountRole = "Tổ chức";
  } else if (btn.dataset.role == 2) {
    accountRole = "Quản trị viên";
  }

  document.getElementById("info-account-message-container").innerHTML = `
    <div class="info-account-message">
      <div class="info-account-message-item">Tên tổ chức / sinh viên</div>
      <div class="info-account-message-item">${accountName}</div>
    </div>
    <div class="info-account-message">
      <div class="info-account-message-item">Tên đơn vị</div>
      <div class="info-account-message-item">${accountUnit}</div>
    </div>
    <div class="info-account-message">
      <div class="info-account-message-item">Email liên hệ</div>
      <div class="info-account-message-item">${accountEmail}</div>
    </div>
    <div class="info-account-message">
      <div class="info-account-message-item">Vai trò</div>
      <div class="info-account-message-item">${accountRole}</div>
    </div>
    <div class="info-account-message">
      <div class="info-account-message-item">Ngày tạo</div>
      <div class="info-account-message-item">${accountDate}</div>
    </div>
    <div class="info-account-message">
      <div class="info-account-message-item">Trạng thái</div>
      <div class="info-account-message-item">${accountStatus}</div>
    </div>`;

  document.getElementById("info-account-modal").classList.add("show");
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-info-account");
  if (!btnCancel) return;
  document.getElementById("info-account-modal").classList.remove("show");
});

// =================dropdownCreateSemester - semester============

document.addEventListener("click", (e) => {
  const dropdown = e.target.closest(".semester-create-item");
  if (!dropdown) {
    document
      .querySelectorAll(".semester-dropdown-menu")
      .forEach((menu) => menu.classList.remove("show"));
    return;
  }

  // click vào ô
  if (e.target.closest(".semester-dropdown-selected")) {
    const currentMenu = dropdown.querySelector(".semester-dropdown-menu");

    document.querySelectorAll(".semester-dropdown-menu").forEach((m) => {
      if (m !== currentMenu) m.classList.remove("show");
    });

    if (currentMenu) {
      currentMenu.classList.toggle("show");
    }
    return;
  }

  // click chọn option
  const option = e.target.closest(".semester-dropdown-option");
  if (option) {
    const selectedText = dropdown.querySelector(".semester-selected-text");
    if (selectedText) {
      selectedText.textContent = option.textContent;
    }

    const parentContainer = option.closest(".semester-create-item");
    const input = parentContainer.querySelector("input[type='hidden']");
    if (input) {
      input.value = option.dataset.value ?? "";
    }

    dropdown.querySelector(".semester-dropdown-menu").classList.remove("show");

    return;
  }
});

// =================dropdownYear - semester============

document.addEventListener("click", (e) => {
  const dropdown = e.target.closest(".semester-search");
  if (!dropdown) {
    document
      .querySelectorAll(".semester-year-dropdown-menu.show")
      .forEach((menu) => {
        menu.classList.remove("show");
      });
    return;
  }

  // click vào ô
  if (e.target.closest(".semester-year-dropdown-selected")) {
    const currentMenu = dropdown.querySelector(".semester-year-dropdown-menu");

    document.querySelectorAll(".semester-year-dropdown-menu").forEach((m) => {
      if (m !== currentMenu) m.classList.remove("show");
    });

    if (currentMenu) {
      currentMenu.classList.toggle("show");
    }
    return;
  }

  // click chọn option
  const option = e.target.closest(".semester-year-dropdown-option");
  if (option) {
    const selectedText = dropdown.querySelector(".semester-year-selected-text");
    if (selectedText) {
      selectedText.textContent = option.textContent;
    }

    dropdown
      .querySelector(".semester-year-dropdown-menu")
      .classList.remove("show");

    const filterYear = option.dataset.value ?? "";
    const queryUrl = `pages/semester.php?filterYear=${encodeURIComponent(filterYear)}`;
    loadPage(queryUrl);

    return;
  }
});

// =================createSemester - semester============

document.addEventListener("submit", (e) => {
  if (e.target.id !== "semesterForm") return;
  e.preventDefault();
  const formData = new FormData(e.target);

  document.getElementById("notice-semester-modal").classList.add("show");

  fetch("pages/semester.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        document.getElementById("notice-semester-message").textContent =
          data.message;

        document
          .getElementById("btn-cancel-notice-semester")
          .classList.remove("hidden");
        document
          .getElementById("btn-cancel-notice-error-semester")
          .classList.add("hidden");

        e.target.reset();
        const semesterText = e.target.querySelector(
          '.semester-create-item[data-type="semester"] .semester-selected-text',
        );
        if (semesterText) semesterText.textContent = "--Chọn học kỳ--";
        const yearText = e.target.querySelector(
          '.semester-create-item[data-type="year"] .semester-selected-text',
        );
        if (yearText) yearText.textContent = "--Chọn năm học--";
      } else {
        document.getElementById("notice-semester-message").textContent =
          data.message;
        document
          .getElementById("btn-cancel-notice-error-semester")
          .classList.remove("hidden");
        document
          .getElementById("btn-cancel-notice-semester")
          .classList.add("hidden");
      }
    })
    .catch(console.error);
});
document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-notice-semester");
  if (!btnCancel) return;
  document.getElementById("notice-semester-modal").classList.remove("show");
  loadPage("pages/semester.php");
});
document.addEventListener("click", (e) => {
  const btnCancelError = e.target.closest("#btn-cancel-notice-error-semester");
  if (!btnCancelError) return;
  document.getElementById("notice-semester-modal").classList.remove("show");
});

document.addEventListener("submit", (e) => {
  if (e.target.id !== "editSemesterForm") return;
  e.preventDefault();

  const formData = new FormData(e.target);
  formData.append("action", "edit");

  document.getElementById("notice-semester-modal").classList.add("show");

  fetch("pages/semester.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        document.getElementById("notice-semester-message").textContent =
          data.message;

        document
          .getElementById("btn-cancel-notice-semester")
          .classList.remove("hidden");
        document
          .getElementById("btn-cancel-notice-error-semester")
          .classList.add("hidden");

        document.getElementById("edit-form-wrapper").classList.add("hidden");
        document
          .getElementById("create-form-wrapper")
          .classList.remove("hidden");

        e.target.reset();
      } else {
        document.getElementById("notice-semester-message").textContent =
          data.message;
        document
          .getElementById("btn-cancel-notice-error-semester")
          .classList.remove("hidden");
        document
          .getElementById("btn-cancel-notice-semester")
          .classList.add("hidden");
      }
    })
    .catch(console.error);
});

document.addEventListener("click", (e) => {
  const btnEdit = e.target.closest(".edit-semester-btn");
  if (btnEdit) {
    const id = btnEdit.dataset.id;
    const hk = btnEdit.dataset.hk;
    const nam = btnEdit.dataset.nam;
    const start = btnEdit.dataset.start;
    const end = btnEdit.dataset.end;

    // document.getElementById("edit-maHocKy").value = id;
    document.getElementById("edit-input-semester").value = hk;
    document.getElementById("edit-input-year").value = nam;
    document.getElementById("edit-semester-text").value = "Học kỳ " + hk;
    document.getElementById("edit-year-text").value = nam;
    document.getElementById("edit-dateStart").value = start;
    document.getElementById("edit-dateEnd").value = end;

    document.getElementById("create-form-wrapper").classList.add("hidden");
    document.getElementById("edit-form-wrapper").classList.remove("hidden");
    return;
  }

  const btnCancelEdit = e.target.closest("#btn-cancel-edit");
  if (btnCancelEdit) {
    document.getElementById("edit-form-wrapper").classList.add("hidden");
    document.getElementById("create-form-wrapper").classList.remove("hidden");
  }
});

// =================popupDeleteSemester - semester============
let deleteSemesterId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".delete-semester-btn");
  if (!btn) return;
  deleteSemesterId = btn.dataset.id;
  document.getElementById("delete-semester-message").textContent =
    `Bạn có chắc chắn muốn xóa học kỳ ${btn.dataset.name}?`;
  document.getElementById("delete-semester-modal").classList.add("show");
  if (
    document.getElementById("btn-confirm-delete-semester").classList == "hidden"
  ) {
    document
      .getElementById("btn-confirm-delete-semester")
      .classList.remove("hidden");
  }
});

document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-confirm-delete-semester");
  if (!btn) return;
  fetch("../includes/delete-semester.php", {
    method: "POST",
    body: new URLSearchParams({
      id: deleteSemesterId,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        document.getElementById("delete-semester-message").textContent =
          data.message;
        document
          .getElementById("btn-confirm-delete-semester")
          .classList.add("hidden");
        document.getElementById("delete-semester-modal-title").textContent =
          "Thông báo";
        document.getElementById("btn-cancel-delete-semester").textContent =
          "Đóng";
        loadPage("pages/semester.php");
      } else {
        document.getElementById("delete-semester-message").textContent =
          data.message;
        document
          .getElementById("btn-confirm-delete-semester")
          .classList.add("hidden");
        document.getElementById("delete-semester-modal-title").textContent =
          "Lỗi";
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-delete-semester");
  if (!btnCancel) return;
  document.getElementById("delete-semester-modal").classList.remove("show");
});

