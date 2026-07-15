// =================chuyenSangActDetail - dashboard============
let currentActId = null;
document.addEventListener("click", (e) => {
  const card = e.target.closest(".card-item");
  if (!card) return;
  currentActId = card.dataset.id;
  loadPage(`pages/act-detail.php?id=${currentActId}`);
});

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

// ================registerBtn - act-detail============

document.addEventListener("click", (e) => {
  const btn = e.target.closest("#register-act-btn");
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

