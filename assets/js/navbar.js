// const navbarItem = document.querySelectorAll(".navbar-item");
// const content = document.querySelector(".right-container");

// navbarItem.forEach((item) => {
//   item.addEventListener("click", function () {
//     const url = `pages/${this.dataset.page}.php`;
//     fetch(url)
//       .then((res) => res.text())
//       .then((data) => {
//         content.innerHTML = data;
//       });
//   });
// });

const content = document.querySelector(".right-container");

function loadPage(url) {
  const separator = url.includes("?") ? "&" : "?";
  fetch(url + separator + "t=" + Date.now())
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
    });
}

loadPage("pages/dashboard.php");

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
