// const { act } = require("react");

console.log("js loaded");

// ===============searchCard - dashboard===================
function searchActCard() {
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
//
document
  .getElementById("btn-search-act")
  .addEventListener("click", function (e) {
    e.preventDefault();
    searchActCard();
  });

document.getElementById("activity").addEventListener("keydown", function (e) {
  if (e.key === "Enter" || e.keyCode === 13) {
    e.preventDefault();
    searchActCard();
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
        if (input.dataset.required === "false" && input.type === "file") {
          return;
        }

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
      // activityData.step1.actImgAvt =
      //   document.querySelector("#act-img-avt").value;
      // activityData.step1.actImgCover =
      //   document.querySelector("#act-img-cover").value;

      const avtFile = document.getElementById("act-img-avt").files[0];
      const coverFile = document.getElementById("act-img-cover").files[0];
      if (avtFile) {
        activityData.step1.actImgAvt = URL.createObjectURL(avtFile);
      }
      if (coverFile) {
        activityData.step1.actImgCover = URL.createObjectURL(coverFile);
      }

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
  const dd = String(today.getDate() + 1).padStart(2, "0");
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

  const tempId = Date.now().toString();

  const divCustomItem = document.createElement("div");
  divCustomItem.classList.add("custom-ques-item");
  divCustomItem.dataset.id = tempId;
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
  divBtnSave.dataset.id = tempId;
  divCustomItem.append(divBtnSave);

  const divBtnCancel = document.createElement("div");
  divBtnCancel.classList.add("cancel-custom-ques-btn");
  divBtnCancel.textContent = "Hủy";
  divBtnCancel.dataset.id = tempId;
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
    const questionId = btnSave.dataset.id;

    if (!inputCustom) return;

    const valueInputCustom = inputCustom.value.trim();
    if (valueInputCustom === "") {
      alert("Vui lòng nhập nội dung câu hỏi trước khi lưu");
      inputCustom.focus();
      return;
    }

    const questionIndex = activityData.step2.customQuestions.findIndex(
      (item) => item.cqId == questionId,
    );
    if (questionIndex !== -1) {
      // nếu có tồn tại => sửa câu hỏi cũ trong eidt act
      activityData.step2.customQuestions[questionIndex].cqContent =
        valueInputCustom;
      if (activityData.step2.customQuestions[questionIndex].status === "old") {
        activityData.step2.customQuestions[questionIndex].status = "update";
      }
    } else {
      // nếu chưa tồn tại => thêm câu hỏi mới trong create act
      activityData.step2.customQuestions.push({
        cqId: questionId,
        cqContent: valueInputCustom,
        status: "new",
      });
    }
    inputCustom.readOnly = true;
    inputCustom.classList.add("is-saved");

    // xóa form nhập tạm thời
    divSaveBtn.remove();
    divCancelBtn.remove();
    // customItem1.dataset.id = buttonId;
    const HTMLbtn = `
        <div class="edit-custom-ques-btn" data-id="${questionId}">Chỉnh sửa</div>
        <div class="del-custom-ques-btn" data-id="${questionId}">Xóa</div>`;
    customItem1.insertAdjacentHTML("beforeend", HTMLbtn);
  }

  // cancel question
  const btnCancel = e.target.closest(".cancel-custom-ques-btn");
  if (btnCancel) {
    const customItem2 = btnCancel.parentElement;
    const questionId = btnCancel.dataset.id;

    const existingQuestion = activityData.step2.customQuestions.find(
      (item) => item.cqId == questionId,
    );
    if (existingQuestion) {
      // Nếu câu hỏi đã tồn tại thì hủy = hủy chỉnh sửa, vẫn lưu câu hỏi cũ
      const inputCustom = customItem2.querySelector(".custom-ques-input input");
      inputCustom.value = existingQuestion.cqContent;
      inputCustom.readOnly = true;
      inputCustom.classList.add("is-saved");

      customItem2.querySelector(".save-custom-ques-btn").remove();
      btnCancel.remove();

      const HTMLbtn = `
          <div class="edit-custom-ques-btn" data-id="${questionId}">Chỉnh sửa</div>
          <div class="del-custom-ques-btn" data-id="${questionId}">Xóa</div>`;
      customItem2.insertAdjacentHTML("beforeend", HTMLbtn);
    } else {
      customItem2.remove();
    }

    // if (customItem2) {
    //   customItem2.remove();
    // }
  }

  // edit question
  const btnEdit = e.target.closest(".edit-custom-ques-btn");
  if (btnEdit) {
    const customItem3 = btnEdit.parentElement;
    const inputCustom = customItem3.querySelector(".custom-ques-input input");
    const divEditBtn = customItem3.querySelector(".edit-custom-ques-btn");
    const divDelBtn = customItem3.querySelector(".del-custom-ques-btn");
    // const questionId = btnEdit.dataset.id;

    if (!inputCustom) return;

    inputCustom.readOnly = false;
    inputCustom.focus();
    inputCustom.classList.remove("is-saved");

    divEditBtn.remove();
    divDelBtn.remove();

    const questionId = customItem3.dataset.id;
    const HTMLbtn = `
    <div class="save-custom-ques-btn" data-id="${questionId}">Lưu</div>
    <div class="cancel-custom-ques-btn" data-id="${questionId}">Hủy</div>`;
    customItem3.insertAdjacentHTML("beforeend", HTMLbtn);
  }

  // delete question
  const btnDel = e.target.closest(".del-custom-ques-btn");
  if (btnDel) {
    const questionId = btnDel.dataset.id;
    const questionIndex = activityData.step2.customQuestions.findIndex(
      (item) => item.cqId == questionId,
    );
    if (questionIndex !== -1) {
      if (activityData.step2.customQuestions[questionIndex].status === "new") {
        activityData.step2.customQuestions.splice(questionIndex, 1);
      } else {
        activityData.step2.customQuestions[questionIndex].status = "delete";
      }
    }

    // const question = activityData.step2.customQuestions.find(
    //   (item) => item.cqId == questionId,
    // );
    // if (question) {
    //   if (question.status === "new") {
    //     activityData.step2.customQuestions =
    //       activityData.step2.customQuestions.filter(
    //         (item) => item.cqId == questionId,
    //       );
    //   } else {
    //     question.status = "delete";
    //   }
    // }

    const customItem = btnDel.parentElement;
    customItem.remove();
    return;
    // if (question && question.status === "new") {
    //   customItem.remove();
    // } else {
    //   renderCustomQuestions();
    // }
  }
});

// ===============step3 - created-act===================

function renderPreview() {
  console.log("renderPreview");
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

  document.getElementById("preview-act-img-avt").src =
    activityData.step1.actImgAvt || "";
  document.getElementById("preview-act-img-cover").src =
    activityData.step1.actImgCover || "";

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

  const visibleQuestions = activityData.step2.customQuestions.filter(
    (item) => item.status !== "delete",
  );
  if (visibleQuestions.length > 0) {
    let numberCustomQues = 0;
    visibleQuestions.forEach((customQues) => {
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
        loadPage(`pages/act-detail.php?id=${data.actCode}`);
      } else {
        alert(data.message);
      }
    });
});

// ===============searchAct - activity-Management===================

function searchActManagement() {
  const inputAct = document.getElementById("act-management");
  let keyword = inputAct.value.trim();
  loadPage(
    `pages/act-management.php?keyword=${encodeURIComponent(keyword)}&status=${currentStatus}`,
  );
}
document.addEventListener("click", function (e) {
  const btn = e.target.closest("#btn-search-act-management");
  if (!btn) return;
  e.preventDefault();
  searchActManagement();
});

document.addEventListener("keydown", function (e) {
  const input = e.target.closest("#act-management");
  if (!input) return;
  if (e.key === "Enter" || e.keyCode === 13) {
    e.preventDefault();
    searchActManagement();
  }
});

// =================chuyenSangEditActManagement - act-management============
let currentActManageId = null;
document.addEventListener("click", (e) => {
  const rowAct = e.target.closest(".row-act-management");
  if (!rowAct) return;
  currentActManageId = rowAct.dataset.id;
  loadPage(`pages/edit-management-act.php?id=${currentActManageId}`);
});

// =================dropdownStatus - act-management============
let currentStatus = "";
document.addEventListener("click", (e) => {
  const dropdown = document.querySelector(".status-act-dropdown");
  if (!dropdown) return;

  // click vào ô
  if (e.target.closest(".status-dropdown-selected")) {
    dropdown.querySelector(".status-dropdown-menu").classList.toggle("show");
    return;
  }

  // click chọn option
  const option = e.target.closest(".status-option");
  if (option) {
    document.getElementById("selected-status").textContent = option.textContent;
    dropdown.querySelector(".status-dropdown-menu").classList.remove("show");

    currentStatus = option.dataset.status;
    searchActManagement();
    return;
  }
});

// function filterStatus() {
//   const keyword = document.getElementById("act-management").value.trim();
//   loadPage(
//     `pages/act-management.php?keyword=${encodeURIComponent(keyword)}&status=${currentStatus}`,
//   );
// }

// =================deleteModal - act-management============
let deleteActId = null;
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".delete-management-act-btn");
  if (!btn) return;
  deleteActId = btn.dataset.id;
  document.getElementById("delete-act-message").textContent =
    `Bạn có chắc chắn muốn xóa hoạt động "${btn.dataset.name}"?`;
  document.getElementById("delete-act-modal").classList.add("show");
});

// =================deleteAct - act-management============
document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-confirm-delete-act");
  if (!btn) return;
  fetch("delete.php", {
    method: "POST",
    body: new URLSearchParams({
      id: deleteActId,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        // alert("Xóa hoạt động thành công!");
        loadPage("pages/act-management.php");
      } else {
        alert(data.message);
      }
    });
});

document.addEventListener("click", (e) => {
  const btnCancel = e.target.closest("#btn-cancel-delete-act");
  if (!btnCancel) return;
  document.getElementById("delete-act-modal").classList.remove("show");
});

// =================renderCustomQuestions - edit-management-act============
function renderCustomQuestions() {
  const container = document.querySelector(".custom-ques-container");
  container.innerHTML = "";
  activityData.step2.customQuestions
    .filter((item) => item.status !== "delete")
    .forEach((question) => {
      const div = document.createElement("div");
      div.classList.add("custom-ques-item");
      div.dataset.id = question.cqId;

      div.innerHTML = `
        <div class="custom-ques-input">
            <input
                type="text"
                value="${question.cqContent}"
                readonly
                class="is-saved">
        </div>

        <div class="edit-custom-ques-btn"
              data-id="${question.cqId}">
              Chỉnh sửa
        </div>

        <div class="del-custom-ques-btn"
              data-id="${question.cqId}">
              Xóa
        </div>
    `;

      container.append(div);
    });
}

// =================khoi tao trang edit - edit-management-act============

function initEditActivity() {
  console.log("init");
  const editData = document.getElementById("edit-data");
  if (!editData) return;
  const customQuestions = JSON.parse(editData.dataset.custom);
  activityData.step2.customQuestions = customQuestions.map((item) => ({
    cqId: item.MaCauHoi,
    cqContent: item.TenHienThi,
    status: "old",
  }));

  activityData.step1.actName = document.getElementById("act-name").value;
  activityData.step1.actLocate = document.getElementById("act-locate").value;
  activityData.step1.actObject = document.getElementById("act-object").value;
  activityData.step1.actStart = document.getElementById("act-start").value;
  activityData.step1.actEnd = document.getElementById("act-end").value;
  activityData.step1.actMaxSlot = document.getElementById("act-max-slot").value;
  activityData.step1.actPoint = document.getElementById("act-point").value;
  activityData.step1.actBonus = document.getElementById("bonus").value;
  activityData.step1.actContent = document.getElementById("act-content").value;
  // ảnh cũ

  activityData.step1.actImgAvt = document.getElementById("img-avt-present")
    ? document.getElementById("img-avt-present").src
    : "";

  activityData.step1.actImgCover = document.getElementById("img-cover-present")
    ? document.getElementById("img-cover-present").src
    : "";
  renderCustomQuestions();
  renderPreview();
}

// =================bat su kien thay doi anh - edit-management-act============
document.addEventListener("change", function (e) {
  if (e.target.id === "act-img-avt") {
    const file = e.target.files[0];
    if (file) {
      activityData.step1.actImgAvt = URL.createObjectURL(file);
    }
  }

  if (e.target.id === "act-img-cover") {
    const file = e.target.files[0];
    if (file) {
      activityData.step1.actImgCover = URL.createObjectURL(file);
    }
  }
});

// ===============updateAct - edit-management-act===================
document.addEventListener("click", (e) => {
  const btn = e.target.closest("#btn-update-act");
  if (!btn) {
    return;
  }

  e.preventDefault();

  activityData.step1.actName = document.getElementById("act-name").value;
  activityData.step1.actLocate = document.getElementById("act-locate").value;
  activityData.step1.actObject = document.getElementById("act-object").value;
  activityData.step1.actStart = document.getElementById("act-start").value;
  activityData.step1.actEnd = document.getElementById("act-end").value;
  activityData.step1.actMaxSlot = document.getElementById("act-max-slot").value;
  activityData.step1.actPoint = document.getElementById("act-point").value;
  activityData.step1.actBonus = document.getElementById("bonus").value;
  document.getElementById("bonusId").value = document.querySelector(
    "[data-type='bonus']",
  ).dataset.id;
  activityData.step1.actBonusId = document.getElementById("bonusId").value;

  activityData.step1.actContent = document.getElementById("act-content").value;

  const bonusIdInput = document.getElementById("bonusId");
  if (bonusIdInput) {
    activityData.step1.actBonusId = bonusIdInput.value;
  } else {
    const bonusDataset = document.querySelector("[data-type='bonus']");
    activityData.step1.actBonusId = bonusDataset ? bonusDataset.dataset.id : "";
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

  // vì có file ảnh nên dùng form data mới gửi đc dữ liệu
  const formData = new FormData();
  formData.append("actId", currentActManageId);
  formData.append("activityData", JSON.stringify(activityData));
  const avtFile = document.getElementById("act-img-avt").files[0];
  if (avtFile) {
    formData.append("actImgAvt", avtFile);
  }
  const coverFile = document.getElementById("act-img-cover").files[0];
  if (coverFile) {
    formData.append("actImgCover", coverFile);
  }

  fetch(`pages/edit-management-act.php?id=${currentActManageId}`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        loadPage(`pages/act-detail.php?id=${data.actCode}`);
      } else {
        alert(data.message);
      }
    });
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
  } else if (e.target.closest(".list-register-btn")) {
    showCta(2);
  } else if (e.target.closest(".take-attendance-btn")) {
    showCta(3);
  }
});

// ===============searchStudent - act-detail===================

function searchActStudent() {
  const inputAct = document.getElementById("act-student");
  let keyword = inputAct.value.trim();
  const currentActId = document.getElementById("act-detail-container").dataset
    .id;
  fetch(
    `pages/student-list.php?id=${currentActId}&keyword=${encodeURIComponent(keyword)}&status=${currentStatus}`,
  )
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("student-list-body").innerHTML = html;
    });
}

document.addEventListener("click", function (e) {
  const btn = e.target.closest("#btn-search-act-student");
  if (!btn) return;
  e.preventDefault();
  searchActStudent();
});

document.addEventListener("keydown", function (e) {
  const input = e.target.closest("#act-student");
  if (!input) return;
  if (e.key === "Enter" || e.keyCode === 13) {
    e.preventDefault();
    searchActStudent();
  }
});

// =================dropdownStatus - act-detail============
// let currentStatus = "";
document.addEventListener("click", (e) => {
  const dropdown = document.querySelector(".status-student-dropdown");
  if (!dropdown) return;

  // click vào ô
  if (e.target.closest(".status-dropdown-selected")) {
    dropdown.querySelector(".status-dropdown-menu").classList.toggle("show");
    return;
  }

  // click chọn option
  const option = e.target.closest(".status-option");
  if (option) {
    document.getElementById("selected-status").textContent = option.textContent;
    dropdown.querySelector(".status-dropdown-menu").classList.remove("show");

    currentStatus = option.dataset.status;
    searchActStudent();
    return;
  }
});

// =================closeForm - act-detail============
document.addEventListener("click", async function (e) {
  const btn = e.target.closest(".btn-close-form");
  if (!btn) return;
  const formId = btn.dataset.formid;
  // gui yeu cau den Apps Script
  const response = await fetch(
    "https://script.google.com/macros/s/AKfycbyKjOsqGZHpH5Lz3UhEnG40mWLU3dc_aODOissZGAb18ZzcSp4bL-neO30CUN5mTlW5MA/exec",
    {
      method: "POST",
      body: new URLSearchParams({
        action: "closeForm",
        formId: formId,
      }),
    },
  );
  // Nhan ket qua sau khi chay ham closeForm ở Apps Script
  const result = await response.json();
  if (result.message) {
    btn.textContent = "Đã đóng form";
    btn.classList.add("closed");
    btn.disabled = true;
  }
});

// =================getListResponseForm - act-detail============
document.addEventListener("click", async function (e) {
  const btn = e.target.closest("#btn-attendance");
  if (!btn) return;

  const res = await fetch("pages/attendance.php", {
    method: "POST",
    body: new URLSearchParams({
      actId: btn.dataset.actId,
    }),
  });

  const result = await res.json();
  console.log(result);

  if (result.success) {
    console.log("Đang load lại");
    const html = await fetch(
      `pages/student-list.php?id=${btn.dataset.actId}`,
    ).then((r) => r.text());

    document.getElementById("student-list-body").innerHTML = html;
  }
});
