// ===============toggle===================

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
    btn.textContent = "Xem tất cả ";
  }
});
