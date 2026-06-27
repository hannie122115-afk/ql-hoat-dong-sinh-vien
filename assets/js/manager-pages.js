console.log("js loaded");
// ===============searchCard - dashboard===================
function searchAct() {
  const inputAct = document.getElementById("activity");
  let keyword = inputAct.value.trim();
  let url = `pages/dashboard.php?keyword=${encodeURIComponent(keyword)}`;
  const content = document.querySelector(".right-container");
  fetch(url)
    .then((res) => res.text())
    .then((data) => {
      content.innerHTML = data;
    });
}

document
  .getElementById("btn-search-act")
  .addEventListener("click", function (e) {
    e.preventDefault();
    searchAct();
  });

document.getElementById("activity").addEventListener("keydown", function (e) {
  if (e.key === "Enter" || e.keyCode === 13) {
    e.preventDefault();
    searchAct();
  }
});
// ===============toggleCard - dashboard===================

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

const activityData = {
  step1: {
    actName: "",
    actObject: "",
    actLocate: "",
    actStart: "",
    actMaxSlot: "",
    actEnd: "",
    actBonus: "",
    actPoint: "",
    actContent: "",
    actImg: "",
  },
  step2: {
    autoQuestions: {
      aqId: "",
    },
    customQuestions: [],
  },
};

document.addEventListener("click", function (e) {
  if (e.target.classList.contains("btn-step-next")) {
    if (currentStep === 1) {
      const inputs = document.querySelectorAll(
        ".act-info-item-input input, .act-info-item-input textarea",
      );

      let isValid = true;
      inputs.forEach((input) => {
        if (input.value.trim() === "") {
          isValid = false;
        }
      });

      if (!isValid) {
        alert("Vui lòng nhập đầy đủ toàn bộ thông tin!");
        return;
      }

      activityData.step1.actName = document.querySelector("#act-name").value;
      activityData.step1.actObject =
        document.querySelector("#act-object").value;
      activityData.step1.actLocate =
        document.querySelector("#act-locate").value;
      activityData.step1.actStart = document.querySelector("#act-start").value;
      activityData.step1.actMaxSlot =
        document.querySelector("#act-max-slot").value;
      activityData.step1.actEnd = document.querySelector("#act-end").value;
      activityData.step1.actBonus = document.querySelector("#bonus").value;
      activityData.step1.actPoint = document.querySelector("#act-point").value;
      activityData.step1.actContent =
        document.querySelector("#act-content").value;
      activityData.step1.actImg = document.querySelector("#act-img").value;
      showStep(2);
    } else if (currentStep === 2) {
      // code sau
      showStep(3);
    }
  }
  if (e.target.classList.contains("btn-step-previous")) {
    if (currentStep > 1) {
      showStep(currentStep - 1);
    }
  }
});

// ===============errorStep1 - created-act===================

document.addEventListener(
  "blur",
  function (e) {
    if (e.target.classList.contains("validate-input")) {
      const input = e.target;
      const errMessage = input
        .closest(".act-info-item")
        .querySelector(".error-message");
      if (input.value.trim() === "") {
        errMessage.textContent = "Không được để trống nội dung này.";
      } else {
        errMessage.textContent = "";
      }

      if (input.classList.contains("act-point")) {
        const maxPoint = document.querySelector("#bonus").dataset.maxPoint;

        console.log("Đang kiểm tra điểm");
        if (parseInt(input.value) > parseInt(maxPoint)) {
          errMessage.textContent =
            "Điểm rèn luyện nhập vào không được lớn hơn điểm rèn luyện tối đa ở mục đã chọn.";
        } else {
          errMessage.textContent = "";
        }
      }
    }
  },
  true,
);

// ===============addQuestion - created-act===================

document.addEventListener("click", function (e) {
  // phần tử gần nhất với thẻ đó hoặc chính nó
  const btnAdd = e.target.closest(".add-question-btn");
  if (!btnAdd) {
    return;
  }
  const customContainer = btnAdd.parentElement.querySelector(
    ".custom-ques-container",
  );
  const divCustomItem = document.createElement("div");
  divCustomItem.classList.add("custom-ques-item");
  customContainer.append(divCustomItem);

  const divCustomInput = document.createElement("div");
  divCustomInput.classList.add("custom-ques-input");
  const inputCustom = document.createElement("input");
  inputCustom.dataset.type = "text";
  inputCustom.placeholder = "Nhập câu hỏi của bạn ...";
  divCustomInput.append(inputCustom);
  divCustomItem.append(divCustomInput);

  const divBtnSave = document.createElement("div");
  divBtnSave.classList.add("save-custom-ques-btn");
  divBtnSave.textContent = "Lưu";
  divCustomItem.append(divBtnSave);

  const divBtnCancel = document.createElement("div");
  divBtnCancel.classList.add("cancel-custom-ques-btn");
  divBtnCancel.textContent = "Hủy";
  divCustomItem.append(divBtnCancel);
});

// ===============btnActionQuestion - created-act===================

// save question
document.addEventListener("click", function (e) {
  const btnSave = e.target.closest(".save-custom-ques-btn");
  if (btnSave) {
    const customItem1 = btnSave.parentElement;
    const inputCustom = customItem1.querySelector(".custom-ques-input input");
    const divSaveBtn = customItem1.querySelector(".save-custom-ques-btn");
    const divCancelBtn = customItem1.querySelector(".cancel-custom-ques-btn");

    if (!inputCustom) return;

    const valueInputCustom = inputCustom.value.trim();
    if (valueInputCustom === "") {
      alert("Vui lòng nhập nội dung câu hỏi trước khi lưu");
      inputCustom.focus();
      return;
    }

    const existingId = btnSave.dataset.id ? Number(btnSave.dataset.id) : null;

    if (existingId) {
      const questionIndex = activityData.step2.customQuestions.findIndex(
        (item) => item.cqId === existingId,
      );
      if (questionIndex !== -1) {
        activityData.step2.customQuestions[questionIndex].cqContent =
          valueInputCustom;
      }
    } else {
      activityData.step2.customQuestions.push({
        cqId: Date.now(),
        cqContent: valueInputCustom,
      });
    }

    inputCustom.readOnly = true;
    inputCustom.classList.add("is-saved");

    // xóa form nhập tạm thời
    divSaveBtn.remove();
    divCancelBtn.remove();

    const HTMLbtn = `<div class="edit-custom-ques-btn">Chỉnh sửa</div>
                    <div class="del-custom-ques-btn">Xóa</div>`;
    customItem1.insertAdjacentHTML("beforeend", HTMLbtn);
  }

  // cancel question
  const btnCancel = e.target.closest(".cancel-custom-ques-btn");
  if (btnCancel) {
    const customItem2 = btnCancel.parentElement;
    if (customItem2) {
      customItem2.remove();
    }
  }

  // edit question
  const btnEdit = e.target.closest(".edit-custom-ques-btn");
  if (btnEdit) {
    const customItem3 = btnEdit.parentElement;
    const inputCustom = customItem3.querySelector(".custom-ques-input input");
    const divEditBtn = customItem3.querySelector(".edit-custom-ques-btn");
    const divDelBtn = customItem3.querySelector(".del-custom-ques-btn");

    if (!inputCustom) return;

    inputCustom.readOnly = false;
    inputCustom.focus();
    inputCustom.classList.remove("is-saved");

    divEditBtn.remove();
    divDelBtn.remove();

    const HTMLbtn = `<div class="save-custom-ques-btn">Lưu</div>
                    <div class="cancel-custom-ques-btn">Hủy</div>`;
    customItem3.insertAdjacentHTML("beforeend", HTMLbtn);
  }

  // delete question
  const btnDel = e.target.closest(".del-custom-ques-btn");
  if (btnDel) {
    const questionId = Number(btnDel.dataset.id);
    activityData.step2.customQuestions =
      activityData.step2.customQuestions.filter(
        (item) => item.cqId !== questionId,
      );
    const customItem4 = btnDel.parentElement;
    const divEditBtn = customItem4.querySelector(".edit-custom-ques-btn");
    const divDelBtn = customItem4.querySelector(".del-custom-ques-btn");
    const divInputCustom = customItem4.querySelector(".custom-ques-input");
    if (customItem4) {
      divEditBtn.remove();
      divDelBtn.remove();
      divInputCustom.remove();
    }
  }
});

// ===============editQuestion - created-act===================
