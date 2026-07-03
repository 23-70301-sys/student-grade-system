document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const toggleButton = document.getElementById("togglePassword");
    const submitButton = document.getElementById("submitBtn");

    if (!loginForm || !usernameInput || !passwordInput || !toggleButton || !submitButton) {
        return;
    }

    toggleButton.addEventListener("click", () => {
        const isPassword = passwordInput.getAttribute("type") === "password";
        
        passwordInput.setAttribute("type", isPassword ? "text" : "password");
        
        toggleButton.textContent = isPassword ? "Hide" : "Show";
        toggleButton.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");
        
        passwordInput.focus();
    });

    function evaluateFormState() {
        const usernameValue = usernameInput.value.trim();
        const passwordValue = passwordInput.value.trim();

        const isFormInvalid = usernameValue === "" || passwordValue === "";

        submitButton.disabled = isFormInvalid;

        if (isFormInvalid) {
            submitButton.style.opacity = "0.6";
            submitButton.style.cursor = "not-allowed";
        } else {
            submitButton.style.opacity = "1";
            submitButton.style.cursor = "pointer";
        }
    }
    
    usernameInput.addEventListener("input", evaluateFormState);
    passwordInput.addEventListener("input", evaluateFormState);

    loginForm.addEventListener("submit", (event) => {
        const cleanUser = usernameInput.value.trim();
        const cleanPass = passwordInput.value.trim();

        if (cleanUser === "" || cleanPass === "") {
            event.preventDefault(); // Halt active server communication pipeline
            alert("Please accurately complete all required input credentials.");
        }
    });

    evaluateFormState();
});