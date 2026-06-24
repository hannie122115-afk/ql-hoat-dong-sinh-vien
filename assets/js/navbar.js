const navbarItem = document.querySelectorAll(".navbar-item");
const content = document.querySelector(".right-container");

navbarItem.forEach((item) => {
  item.addEventListener("click", function () {
    const url = `pages/${this.dataset.page}.php`;
    fetch(url)
      .then((res) => res.text())
      .then((data) => {
        content.innerHTML = data;
      });
  });
});
