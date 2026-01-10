function initPasswordToggle() {
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (togglePassword && passwordInput && toggleIcon) {
        togglePassword.addEventListener("click", () => {
            const type =
                passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            toggleIcon.src =
                type === "password"
                    ? "/images/view_password.png"
                    : "/images/hide_password.png";
        });
    }
}

export default initPasswordToggle;
