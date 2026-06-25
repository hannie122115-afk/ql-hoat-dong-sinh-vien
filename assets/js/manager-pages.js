console.log("js loaded");

// ===============toggle-card - dashboard===================

document.addEventListener("click", function (e) {
  const btn = e.target.closest(".see-all-card-btn");

  if (!btn) return;

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

// ===============step - created-act===================

let currentStep = 1;

function showStep(step) {
  document.querySelectorAll(".step-block").forEach((block) => {
    block.classList.remove("active");
  });

  document.querySelectorAll(".step-line-item").forEach((item) => {
    item.classList.remove("active");
  });

  document.getElementById(`step${step}`).classList.add("active");

  document
    .querySelector(`.step-line-item[data-step="${step}"]`)
    .classList.add("active");

  currentStep = step;
}

document.addEventListener("click", function (e) {
  if (e.target.classList.contains("btn-step-next")) {
    if (currentStep < 3) {
      showStep(currentStep + 1);
    }
  }
  if (e.target.classList.contains("btn-step-previous")) {
    if (currentStep > 1) {
      showStep(currentStep - 1);
    }
  }
});
