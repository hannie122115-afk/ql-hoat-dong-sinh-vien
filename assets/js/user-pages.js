// =================chuyenSangMyCalendar - dashboard============
document.addEventListener("click", (e) => {
  const btn = e.target.closest("#my-calendar-btn");
  if (!btn) return;
  loadPage(`pages/my-calendar.php`);
});

// =================chuyenSangActDetail - dashboard============
let currentActId = null;
document.addEventListener("click", (e) => {
  const card = e.target.closest(".card-item");
  if (!card) return;
  currentActId = card.dataset.id;
  loadPage(`pages/act-detail.php?id=${currentActId}`);
});

// =================showBTN - act-detail============
let currentCtaUser = 1;

function showCta(cta) {
  document.querySelectorAll(".act-detail-block").forEach((block) => {
    block.classList.remove("active");
  });
  document.getElementById(`act-detail-${cta}`).classList.add("active");
  currentCtaUser = cta;
}

document.addEventListener("click", (e) => {
  if (e.target.closest(".detail-btn")) {
    showCta(1);
  } else if (e.target.closest(".register-btn")) {
    showCta(2);
  }
});

// ================registerBtn - act-detail============

document.addEventListener("click", (e) => {
  const btn = e.target.closest(".register-act-btn");
  if (!btn) {
    return;
  }
  e.preventDefault();
  const actId = btn.dataset.actId;
  const form = document.querySelector("#act-register-form");
  const inputs = form.querySelectorAll("input[type='text']");

  let isValid = true;
  inputs.forEach((input) => {
    if (input.readOnly) return;
    if (input.value.trim() === "") {
      alert("Vui lòng trả lời đầy đủ các câu hỏi!");
      input.style.border = "1px solid red";
      input.focus();
      return;
    } else {
      input.style.border = "";
    }
  });

  if (!isValid) return;

  const formData = new FormData(form);
  fetch(`pages/act-detail.php?id=${currentActId}`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        loadPage(`pages/act-detail.php?id=${currentActId}`);
      } else {
        alert(data.message);
      }
    });
});

// ================dropdown - profile============
let profileFilters = {
  semester: "",
  year: "",
};
function searchProfilePoint() {
  let queryUrl =
    `pages/profile.php?semester=${encodeURIComponent(profileFilters.semester)}` +
    `&year=${encodeURIComponent(profileFilters.year)}`;

  loadPage(queryUrl);
}
document.addEventListener("click", function (e) {
  const dropdown = e.target.closest(".profile-custom-dropdown");
  if (!dropdown) {
    document.querySelectorAll(".profile-dropdown-menu").forEach((menu) => {
      menu.classList.remove("show");
    });
    return;
  }

  if (e.target.closest(".profile-dropdown-selected")) {
    const currentMenu = dropdown.querySelector(".profile-dropdown-menu");
    document.querySelectorAll(".profile-dropdown-menu").forEach((menu) => {
      if (menu !== currentMenu) {
        menu.classList.remove("show");
      }
    });
    currentMenu.classList.toggle("show");
    return;
  }
  const option = e.target.closest(".profile-dropdown-option");
  if (option) {
    dropdown.querySelector(".profile-selected-text").textContent =
      option.textContent;
    dropdown.querySelector(".profile-dropdown-menu").classList.remove("show");
    const type = dropdown.dataset.type;
    profileFilters[type] = option.dataset.value;
    searchProfilePoint();
  }
});

// =================my-calender============

function initCalendar() {
  const calendarEl = document.getElementById("calendar");

  if (!calendarEl) return;

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridWeek",
    locale: "vi",
    height: "auto",
    contentHeight: 550,
    displayEventTime: false,
    events: "pages/calendar-data.php",
    eventClick(info) {
      loadPage(`pages/act-detail.php?id=${info.event.id}`);
    },
    eventContent(info) {
      const start = info.event.start.toLocaleTimeString("vi-VN", {
        hour: "2-digit",
        minute: "2-digit",
      });

      const end = info.event.end.toLocaleTimeString("vi-VN", {
        hour: "2-digit",
        minute: "2-digit",
      });

      return {
        html: `
            <div class="event-box">
                <div class="event-title">${info.event.title}</div>
                <div class="event-time">${start} - ${end}</div>
            </div>
        `,
      };
    },
  });

  calendar.render();
}

