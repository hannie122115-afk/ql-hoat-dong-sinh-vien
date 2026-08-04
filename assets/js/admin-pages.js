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
