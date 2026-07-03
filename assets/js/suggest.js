let timeout;
let controller;
let unitId = null;
let maxPoint = 0;

// const suggestBox = input.parentElement.nextElementSibling;
document.addEventListener("click", function (e) {
  if (!e.target.classList.contains("suggest-item")) {
    return;
  }
  const suggestBox = e.target.parentElement;
  const input =
    suggestBox.previousElementSibling.querySelector(".search-input");

  input.value = e.target.dataset.name;
  input.dataset.id = e.target.dataset.id;

  if (input.dataset.type === "bonus") {
    input.dataset.maxPoint = e.target.dataset.maxPoint;
  }
  // luu id neu la unit
  if (input.dataset.type === "unit") {
    unitId = e.target.dataset.id;

    // xoa noi dung class neu unit thay doi
    if (document.querySelector("[data-type='class']"))
      document.querySelector("[data-type='class']").value = "";
  }
  suggestBox.innerHTML = "";
});

document.addEventListener("input", function (e) {
  const input = e.target;

  if (!input.classList.contains("search-input")) {
    return;
  }

  const suggestBox = input.parentElement.nextElementSibling;

  // reset lai gia tri unitId khi sua o unit
  if (input.dataset.type === "unit" && input.value.trim() === "") {
    unitId = null;
  }

  clearTimeout(timeout);
  const keyword = input.value.trim();

  if (keyword === "") {
    suggestBox.innerHTML = "";
    return;
  }

  timeout = setTimeout(() => {
    // huy request cu
    if (controller) controller.abort();
    controller = new AbortController();

    if (input.dataset.type === "class" && !unitId) {
      suggestBox.innerHTML =
        "<div class='report-before-search'>Vui lòng chọn đơn vị trước</div>";
      return;
    }

    const formData = new FormData();
    formData.append("type", input.dataset.type);
    formData.append("keyword", keyword);

    if (input.dataset.type === "class") {
      formData.append("unit_id", unitId);
    }

    let linkSearchPHP = "";

    if (input.dataset.type === "unit" || input.dataset.type === "class") {
      linkSearchPHP = "includes/search.php";
    } else {
      linkSearchPHP = "../includes/search.php";
    }

    fetch(linkSearchPHP, {
      method: "POST",
      body: formData,
      signal: controller.signal, //cho phep huy request
    })
      .then((res) => res.json())
      .then((data) => {
        suggestBox.innerHTML = "";

        if (!data || data.length === 0) {
          suggestBox.innerHTML =
            "<div class='empty-result-search'>Không tìm thấy dữ liệu</div>";
          return;
        }

        data.forEach((item) => {
          const div = document.createElement("div");
          div.classList.add("suggest-item");
          div.dataset.name = item.name;
          div.dataset.id = item.id;
          if (input.dataset.type === "bonus") {
            div.dataset.maxPoint = item.maxPoint;
          }
          div.textContent = item.name;
          suggestBox.append(div);
        });
      });
  }, 300);

  document.addEventListener("click", function (e) {
    if (!input.contains(e.target) && !suggestBox.contains(e.target)) {
      suggestBox.innerHTML = "";
    }
  });
});
