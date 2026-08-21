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
  // inputs.forEach((input) => {
  //   if (input.readOnly) return;
  //   if (input.value.trim() === "") {
  //     alert("Vui lòng trả lời đầy đủ các câu hỏi!");
  //     input.style.border = "1px solid red";
  //     input.focus();
  //     return;
  //   } else {
  //     input.style.border = "";
  //   }
  // });

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
        // alert(data.message);
        document.getElementById("notice-save-register-message").textContent =
          data.message;
        document
          .getElementById("notice-save-register-modal")
          .classList.add("show");
      }
    });
});

document.addEventListener("click", (e) => {
  const btnNotice = e.target.closest("#btn-cancel-notice-save-register");
  if (btnNotice) {
    document
      .getElementById("notice-save-register-modal")
      .classList.remove("show");
    return;
  }
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

// function initCalendar() {
//   const calendarEl = document.getElementById("calendar");

//   if (!calendarEl) return;

//   const calendar = new FullCalendar.Calendar(calendarEl, {
//     initialView: "dayGridWeek",
//     locale: "vi",
//     height: "auto",
//     contentHeight: 550,
//     displayEventTime: false,
//     events: "pages/calendar-data.php",
//     eventClick(info) {
//       loadPage(`pages/act-detail.php?id=${info.event.id}`);
//     },
//     eventContent(info) {
//       const start = info.event.start.toLocaleTimeString("vi-VN", {
//         hour: "2-digit",
//         minute: "2-digit",
//       });

//       const end = info.event.end.toLocaleTimeString("vi-VN", {
//         hour: "2-digit",
//         minute: "2-digit",
//       });

//       return {
//         html: `
//             <div class="event-box">
//                 <div class="event-title">${info.event.title}</div>
//                 <div class="event-time">${start} - ${end}</div>
//             </div>
//         `,
//       };
//     },
//   });

//   calendar.render();
// }

function initCalendar() {
  const calendarEl = document.getElementById("calendar");

  if (!calendarEl) return;

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridWeek",
    locale: "vi",
    height: "auto",
    contentHeight: 550,
    displayEventTime: false,
    dayMaxEventRows: false,
    events: "pages/calendar-data.php",

    eventClick(info) {
      loadPage(`pages/act-detail.php?id=${info.event.id}`);
    },

    eventContent(info) {
      const start = info.event.start.toLocaleTimeString("vi-VN", {
        hour: "2-digit",
        minute: "2-digit",
      });

      const end = info.event.end
        ? info.event.end.toLocaleTimeString("vi-VN", {
            hour: "2-digit",
            minute: "2-digit",
          })
        : "";

      return {
        html: `
          <div class="event-box">
            <div class="event-title">${info.event.title}</div>
            <div class="event-time">${start} - ${end}</div>
          </div>
        `,
      };
    },

    eventDidMount(info) {
      info.el.dataset.eventId = info.event.id;
      // thời gian để set từng event
      setTimeout(() => {
        arrangeCalendarEvents(calendar);
      }, 50);
    },
    // thời gian set qua tuần mới
    datesSet() {
      setTimeout(() => {
        arrangeCalendarEvents(calendar);
      }, 100);
    },
  });

  calendar.render();
}

function arrangeCalendarEvents(calendar) {
  const events = calendar.getEvents();

  if (!events.length) return;

  const sortedEvents = [...events].sort((a, b) => {
    return a.start - b.start;
  });

  const rowMap = new Map();

  sortedEvents.forEach((event, index) => {
    rowMap.set(String(event.id), index);
  });

  const ROW_HEIGHT = 58; //cach 58px

  const eventEls = document.querySelectorAll(".fc-daygrid-event");

  eventEls.forEach((eventEl) => {
    const eventId = eventEl.dataset.eventId;

    if (!eventId) return;

    const row = rowMap.get(String(eventId));

    if (row === undefined) return;

    const harness = eventEl.closest(".fc-daygrid-event-harness");

    if (!harness) return;

    harness.style.setProperty("top", `${row * ROW_HEIGHT}px`, "important");
  });

  document.querySelectorAll(".fc-daygrid-day-events").forEach((container) => {
    container.style.minHeight = `${sortedEvents.length * ROW_HEIGHT}px`;
  });
}

// =================dropdown - joined-act============

let filterRegister = {
  semester: "",
  year: "",
};

document.addEventListener("click", (e) => {
  const selected = e.target.closest(".registered-act-dropdown-selected");
  if (selected) {
    const dropdown = selected.closest(".registered-act-dropdown-block");
    document
      .querySelectorAll(".registered-act-dropdown-menu")
      .forEach((menu) => {
        if (menu !== dropdown.querySelector(".registered-act-dropdown-menu")) {
          menu.classList.remove("show");
        }
      });
    dropdown
      .querySelector(".registered-act-dropdown-menu")
      .classList.toggle("show");
    return;
  }

  const item = e.target.closest(".registered-act-dropdown-item");
  if (item) {
    const dropdown = item.closest(".registered-act-dropdown-block");
    const type = dropdown.dataset.type;
    dropdown.querySelector(".selected-text").textContent = item.textContent;
    dropdown
      .querySelector(".registered-act-dropdown-menu")
      .classList.remove("show");
    filterRegister[type] = item.dataset.value;
    loadRegisteredAct();
  } else {
    document
      .querySelectorAll(".registered-act-dropdown-menu")
      .forEach((menu) => {
        menu.classList.remove("show");
      });
  }
});

function loadRegisteredAct() {
  const currentCardContainer = document.querySelector(".card-container");

  // Hiển thị hiệu ứng mờ lập tức để người dùng biết đang tải
  if (currentCardContainer) {
    currentCardContainer.style.opacity = "0.4";
    currentCardContainer.style.pointerEvents = "none";
  }

  const params = new URLSearchParams({
    semester: filterRegister.semester,
    year: filterRegister.year,
  });

  fetch(`pages/joined-act.php?${params.toString()}`)
    .then((response) => response.text())
    .then((html) => {
      const doc = new DOMParser().parseFromString(html, "text/html");
      const newCardContainer = doc.querySelector(".card-container");

      if (newCardContainer && currentCardContainer) {
        // Cập nhật lại HTML card
        currentCardContainer.innerHTML = newCardContainer.innerHTML;
      }
    })
    .catch((error) => console.error("Error loading activities:", error))
    .finally(() => {
      // Khôi phục lại độ mờ sau khi tải xong
      if (currentCardContainer) {
        currentCardContainer.style.opacity = "1";
        currentCardContainer.style.pointerEvents = "auto";
      }
    });
}
