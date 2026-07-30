const content = document.querySelector(".right-container");

function loadPage(url) {
  const separator = url.includes("?") ? "&" : "?";
  const finalUrl = url.includes("t=")
    ? url
    : `${url}${separator}t=${Date.now()}`;
  fetch(finalUrl)
    .then((res) => res.text())
    .then((data) => {
      content.innerHTML = data;

      if (url.includes("edit-management-act.php")) {
        console.log("goi init");
        initEditActivity();
      }

      if (url === "pages/created-act.php") {
        initDateTime();
      }

      if (url.includes("calendar.php")) {
        initCalendar();
      }
    })
    .catch((err) => console.error("Lỗi load trang:", err));
}

document.addEventListener("DOMContentLoaded", () => {
  const pageToLoad = sessionStorage.getItem("reloadAndLoadPage");
  if (pageToLoad) {
    sessionStorage.removeItem("reloadAndLoadPage");
    loadPage(pageToLoad);
  } else {
    loadPage("pages/dashboard.php");
  }
});

const navbarItem = document.querySelectorAll(".navbar-item");
navbarItem.forEach((item) => {
  item.addEventListener("click", function () {
    loadPage(`pages/${this.dataset.page}.php`);
  });
});

document.addEventListener("click", function (e) {
  const card = e.target.closest(".card-item");
  if (!card) return;
  const idCard = card.dataset.id;
  loadPage(`pages/act-detail.php?id=${idCard}`);
});
