// const { act } = require("react");

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
    actBonusId: "",
    actPoint: "",
    actContent: "",
    actImgAvt: "",
    actImgCover: "",
  },
  step2: {
    autoQuestions: [],
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

      document.getElementById("bonusId").value = document.querySelector(
        "[data-type='bonus']",
      ).dataset.id;
      activityData.step1.actBonusId = document.getElementById("bonusId").value;

      activityData.step1.actPoint = document.querySelector("#act-point").value;
      activityData.step1.actContent =
        document.querySelector("#act-content").value;
      activityData.step1.actImgAvt =
        document.querySelector("#act-img-avt").value;
      activityData.step1.actImgCover =
        document.querySelector("#act-img-cover").value;
      showStep(2);
    } else if (currentStep === 2) {
      const unsaveCustomQues = document.querySelectorAll(
        ".custom-ques-input input:not(.is-saved",
      );
      if (unsaveCustomQues.length > 0) {
        alert("Vui lòng chọn 'lưu' hoặc 'hủy bỏ' câu hỏi để tiếp tục.");
        unsaveCustomQues[0].focus();
        return;
      }

      activityData.step2.autoQuestions = [];
      const checkBoxes = document.querySelectorAll(
        ".auto-ques-container input[type='checkbox']:checked",
      );
      checkBoxes.forEach((checkbox) => {
        activityData.step2.autoQuestions.push({
          aqType: checkbox.dataset.id,
          aqContent: checkbox.value,
        });
      });

      renderPreview();
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
        if (parseInt(input.value) > parseInt(maxPoint)) {
          errMessage.textContent = `Điểm rèn luyện nhập vào không được lớn hơn điểm rèn luyện tối đa ở mục đã chọn. Điểm rèn luyện tối đa của mục này là: ${maxPoint}`;
        } else {
          errMessage.textContent = "";
        }
      }
      // ràng buộc định dạng file tải lên là ảnh
      if (input.classList.contains("act-img-input")) {
        const file = input.files[0];
        if (!file.type.startsWith("image/")) {
          errMessage.textContent =
            "Chỉ chọn file định dạng hình ảnh (png, jpg, jpeg...)!. Vui lòng chọn lại";
          input.value = "";
        } else {
          errMessage.textContent = "";
        }
      }
    }
  },
  true,
);

// ràng buộc ngày

function initDateTime() {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, "0");
  const dd = String(today.getDate()).padStart(2, "0");
  const hh = String(today.getHours()).padStart(2, "0");
  const mi = String(today.getMinutes()).padStart(2, "0");

  const actStartInput = document.getElementById("act-start");
  if (actStartInput) {
    actStartInput.min = `${yyyy}-${mm}-${dd}T${hh}:${mi}`;
    console.log("toi buoc actStart");
  }

  const actEndInput = document.getElementById("act-end");
  if (actEndInput && actStartInput) {
    actEndInput.min = `${yyyy}-${mm}-${dd}T${hh}:${mi}`;

    actStartInput.addEventListener("change", function () {
      const now = new Date();
      const selected = new Date(this.value);
      if (selected < now) {
        alert("Thời gian bắt đầu phải từ thời điểm hiện tại trở đi.");
        this.value = "";
      }

      actEndInput.min = actStartInput.value;
      if (actEndInput.value && actEndInput.value < actStartInput.value) {
        actEndInput.value = actStartInput.value;
      }
    });
  }
}

// document.addEventListener("change", function (e) {
//   const actImgInput = e.target.closest(".act-img-input");
//   if (!actImgInput) {
//     return;
//   }
//   const errMessage = actImgInput
//     .closest(".act-info-item")
//     .querySelector(".error-message");

//   if (actImgInput.files.length === 0) {
//     return;
//   }
//   const file = actImgInput.files[0];
//   if (!file.type.startsWith("images/")) {
//     errMessage.textContent =
//       "Chỉ chọn file định dạng hình ảnh (png, jpg, jpeg...)!";
//     actImgInput.value = "";
//   }
//   errMessage.textContent = "";
// });

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
      const newId = Date.now();
      activityData.step2.customQuestions.push({
        cqId: newId,
        cqContent: valueInputCustom,
      });
    }

    inputCustom.readOnly = true;
    inputCustom.classList.add("is-saved");

    // xóa form nhập tạm thời
    divSaveBtn.remove();
    divCancelBtn.remove();

    const HTMLbtn = `
        <div class="edit-custom-ques-btn" data-id="{newId}">Chỉnh sửa</div>
        <div class="del-custom-ques-btn" data-id="{newId}">Xóa</div>`;
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

// ===============step3 - created-act===================

function renderPreview() {
  const previewContainer = document.querySelector(".preview-container-step3");

  document.getElementById("preview-act-name").textContent =
    activityData.step1.actName;
  document.getElementById("preview-act-locate").textContent =
    activityData.step1.actLocate;
  document.getElementById("preview-act-amount").textContent =
    activityData.step1.actMaxSlot;
  document.getElementById("preview-act-start").textContent =
    activityData.step1.actStart;
  document.getElementById("preview-act-end").textContent =
    activityData.step1.actEnd;
  document.getElementById("preview-act-score").textContent =
    activityData.step1.actPoint;
  document.getElementById("preview-act-bonus").textContent =
    activityData.step1.actBonus;
  document.getElementById("preview-act-describe").textContent =
    activityData.step1.actContent;

  // lưu tạm thời ảnh
  const avtFile = document.getElementById("act-img-avt").files[0];
  document.getElementById("preview-act-img-avt").src =
    URL.createObjectURL(avtFile);
  const coverFile = document.getElementById("act-img-cover").files[0];
  document.getElementById("preview-act-img-cover").src =
    URL.createObjectURL(coverFile);

  const autoQuesBlock = document.getElementById("preview-block-auto-ques");
  autoQuesBlock.innerHTML = "";

  if (activityData.step2.autoQuestions.length > 0) {
    let numberAutoQues = 0;
    activityData.step2.autoQuestions.forEach((autoQues) => {
      numberAutoQues += 1;
      autoQuesBlock.innerHTML += `
        <div class="preview-auto-ques-item">
            <div class="preview-auto-ques">
              <span class="number-auto-ques">${numberAutoQues}</span>
              <span>${autoQues.aqContent}</span>
            </div>
            <input type="text" disabled placeholder="Hệ thống tự động điền...">
        </div>
      `;
    });
  }

  const customQuesBlock = document.getElementById("preview-block-custom-ques");
  customQuesBlock.innerHTML = "";

  if (activityData.step2.customQuestions.length > 0) {
    let numberCustomQues = 0;
    activityData.step2.customQuestions.forEach((customQues) => {
      numberCustomQues += 1;
      customQuesBlock.innerHTML += `
        <div class="preview-custom-ques-item">
            <div class="preview-custom-ques">
              <span class="number-custom-ques">${numberCustomQues}</span>
              <span>${customQues.cqContent}</span>
            </div>
            <input type="text" disabled placeholder="Nhập vào câu trả lời của bạn...">
        </div>
      `;
    });
  }
}

// ===============created-act===================
document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-submit-act");
  if (!btn) {
    return;
  }

  e.preventDefault();
  // vì có file ảnh nên dùng form data mới gửi đc dữ liệu
  const formData = new FormData();
  formData.append("activityData", JSON.stringify(activityData));
  formData.append("actImgAvt", document.getElementById("act-img-avt").files[0]);
  formData.append(
    "actImgCover",
    document.getElementById("act-img-cover").files[0],
  );

  fetch("pages/created-act.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        loadPage(`pages/act-detail.php`);
      } else {
        alert(data.message);
      }
    });
});
