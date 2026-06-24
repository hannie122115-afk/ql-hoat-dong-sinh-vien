// toggle

// const seeAllBtn = document.querySelectorAll(".see-all-card-btn");
// seeAllBtn.forEach((btn) => {
//   btn.addEventListener("click", function () {
//     const container = this.previousElementSibling;

//     this.classList.toggle("isShowing");
//     if (this.classList.contains("isShowing")) {
//       container.querySelectorAll(".hidden-card-item").forEach((card) => {
//         card.style.display = "block";
//       });
//       this.textContent = "Thu gọn";
//     } else {
//       container.querySelectorAll(".hidden-card-item").forEach((card) => {
//         card.style.display = "none";
//       });
//       this.textContent = "Xem tất cả";
//     }
//   });
// });

document.addEventListener("click", function (e) {
  if (!e.target.classList.contains("see-all-card-btn")) {
    console.log("Khong tim thay the");
    return;
  }
  const btn = e.target;
  const cardContainer = btn.previousElementSibling;

  btn.classList.toggle("isShowing");

  if (btn.classList.contains("isShowing")) {
    cardContainer.querySelectorAll(".hidden-card-item").forEach((card) => {
      card.style.display = "block";
    });
    btn.textContent = "Thu gọn";
  } else {
    cardContainer.querySelectorAll(".hidden-card-item").forEach((card) => {
      card.style.display = "none";
    });
    btn.textContent = "Xem tất cả";
  }
});
