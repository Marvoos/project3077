const passwordField = document.querySelector('.pass-div > input[type="password"]');
const eyeButton = document.querySelector('.pass-div span.fa-eye');
let isHidden = true;

eyeButton.addEventListener('click', () => {
    if (isHidden) {
        isHidden = false;
        passwordField.type = "text";
        eyeButton.classList.remove('fa-eye');
        eyeButton.classList.add('fa-eye-slash');
    } else {
        isHidden = true;
        passwordField.type = "password";
        eyeButton.classList.remove('fa-eye-slash');
        eyeButton.classList.add('fa-eye');
    }
});