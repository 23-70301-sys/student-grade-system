// js/jsapp.js
// Client-side behavior for the Student Grade Management System

document.addEventListener('DOMContentLoaded', function () {
    setupPasswordToggle();
    setupLoginValidation();
});


function setupPasswordToggle() {
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (!toggleBtn || !passwordInput) return;

    toggleBtn.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        toggleBtn.textContent = isHidden ? '🙈' : '👁';
        toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
    });
}

function setupLoginValidation() {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    form.addEventListener('submit', function (e) {
        let isValid = true;

        emailError.textContent = '';
        passwordError.textContent = '';
        emailInput.classList.remove('input-invalid');
        passwordInput.classList.remove('input-invalid');

        const emailValue = emailInput.value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailValue === '') {
            emailError.textContent = 'Email is required.';
            emailInput.classList.add('input-invalid');
            isValid = false;
        } else if (!emailPattern.test(emailValue)) {
            emailError.textContent = 'Please enter a valid email address.';
            emailInput.classList.add('input-invalid');
            isValid = false;
        }

        const passwordValue = passwordInput.value.trim();

        if (passwordValue === '') {
            passwordError.textContent = 'Password is required.';
            passwordInput.classList.add('input-invalid');
            isValid = false;
        } else if (passwordValue.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters.';
            passwordInput.classList.add('input-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    [emailInput, passwordInput].forEach(function (input) {
        input.addEventListener('input', function () {
            input.classList.remove('input-invalid');
            const errorSpan = input.id === 'email' ? emailError : passwordError;
            errorSpan.textContent = '';
        });
    });
}