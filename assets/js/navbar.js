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
  fetch(url)
    .then((res) => res.text())
    .then((data) => {
      content.innerHTML = data;

      if (url === "pages/created-act.php") {
        initDateTime();
      }
    });
}

const navbarItem = document.querySelectorAll(".navbar-item");

navbarItem.forEach((item) => {
  item.addEventListener("click", function () {
    loadPage(`pages/${this.dataset.page}.php`);
  });
});
