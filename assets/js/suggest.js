const input = document.querySelectorAll(".search-input");
let timeout;
let controller;
let unitId = null;

input.forEach((input) => {
  // const suggestBox = input.nextElementSibling;
  const suggestBox = input.parentElement.nextElementSibling;
  suggestBox.addEventListener("click", function (e) {
    if (e.target.classList.contains("suggest-item")) {
      input.value = e.target.dataset.name;

      // luu id neu la unit
      if (input.dataset.type === "unit") {
        unitId = e.target.dataset.id;

        // xoa noi dung class neu unit thay doi
        if (document.querySelector("[data-type='class'"))
          document.querySelector("[data-type='class'").value = "";
      }
      suggestBox.innerHTML = "";
    }
  });

  input.addEventListener("input", function () {
    // reset lai gia tri unitId khi sua o unit
    if (input.dataset.type === "unit" && this.value.trim() === "") {
      unitId = null;
    }

    clearTimeout(timeout);
    const keyword = this.value.trim();

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

      fetch("includes/search.php", {
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
            div.textContent = item.name;
            suggestBox.append(div);
          });
        });
    }, 300);
  });

  document.addEventListener("click", function (e) {
    if (!input.contains(e.target) && !suggestBox.contains(e.target)) {
      suggestBox.innerHTML = "";
    }
  });
});
