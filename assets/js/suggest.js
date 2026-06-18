const input = document.querySelector(".search-input");
const suggestBox = document.querySelector(".suggest-box");
let timeout;
let controller;

input.addEventListener("input", function () {
  clearTimeout(timeout);

  const keyword = this.value.trim();

  if (keyword === "") {
    suggestBox.innerHTML = "";
    return;
  }

  timeout = setTimeout(() => {
    suggestBox.innerHTML =
      "<div class='loading-result-search'> Đang tìm ...</div>";
    // huy request cu
    if (controller) controller.abort();
    controller = new AbortController();

    const formData = new FormData();
    formData.append("type", input.dataset.type);
    formData.append("keyword", keyword);

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

        suggestBox.addEventListener("click", function (e) {
          if (e.target.classList.contains("suggest-item")) {
            input.value = e.target.dataset.name;
            suggestBox.innerHTML = "";
          }
        });

        data.forEach((item) => {
          const div = document.createElement("div");
          div.classList.add("suggest-item");
          div.dataset.name = item.name;
          div.dataset.id = item.id;

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
