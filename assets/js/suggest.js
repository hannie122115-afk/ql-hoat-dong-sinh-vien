console.log("JS loaded");

document.querySelectorAll(".register-input-block").forEach((block) => {
  let input = block.querySelector(".search-input");
  let type = block.querySelector(".type").value;
  let suggestions = block.querySelector(".suggestions");

  input.addEventListener("keyup", function () {
    let q = this.value;

    if (q.length == 0) {
      suggestions.innerHTML = "";
      return;
    }

    fetch("suggest.php?q=" + q + "&type=" + type)
      .then((res) => res.json())
      .then((data) => {
        let html = "";

        data.forEach((item) => {
          html += `
                        <div onclick="selectItem('${item.name}', this)">
                            ${item.name}
                        </div>
                    `;
        });

        suggestions.innerHTML = html;
      });
  });
});

function selectItem(name, el) {
  let block = el.closest(".register-input-block");

  let input = block.querySelector(".search-input");
  let suggestions = block.querySelector(".suggestions");

  input.value = name;
  suggestions.innerHTML = "";
}
