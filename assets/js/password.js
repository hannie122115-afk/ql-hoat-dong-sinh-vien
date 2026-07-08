// ================= mật khẩu =============

const toggleIcons = document.querySelectorAll(".toggle-password-icon");

toggleIcons.forEach(function (e) {
  e.addEventListener("click", function () {
    const passwordInput = this.previousElementSibling;
    if (passwordInput) {
      passwordInput.classList.toggle("hidden-password");

      if (this.classList.contains("fa-eye")) {
        this.classList.remove("fa-eye");
        this.classList.add("fa-eye-slash");
      } else {
        this.classList.remove("fa-eye-slash");
        this.classList.add("fa-eye");
      }
    }
  });
});
