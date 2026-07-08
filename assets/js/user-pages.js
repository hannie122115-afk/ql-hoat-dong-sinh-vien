// =================showBTN - act-detail============
let currentCta = 1;

function showCta(cta) {
  document.querySelectorAll(".act-detail-block").forEach((block) => {
    block.classList.remove("active");
  });
  document.getElementById(`act-detail-${cta}`).classList.add("active");
  currentCta = cta;
}

document.addEventListener("click", (e) => {
  if (e.target.closest(".detail-btn")) {
    showCta(1);
  } else if (e.target.closest(".register-btn")) {
    showCta(2);
  }
});
