// JavaScript for handling password visibility toggle on the login and registration forms
// Select the password input field
const passwordField = document.querySelector('.pass-div > input[type="password"]');
// Select the eye icon button for toggling password visibility
const eyeButton = document.querySelector('.pass-div span.fa-eye');
// Variable to track whether the password is currently hidden or visible
let isHidden = true;

// Add a click event listener to the eye button to toggle password visibility
eyeButton.addEventListener('click', () => {
    // Toggle the isHidden variable to switch between hidden and visible states
    if (isHidden) {
        // If the password is currently hidden, show it by changing the input type to "text" and updating the eye icon
        isHidden = false;
        // Change the input type to "text" to show the password
        passwordField.type = "text";
        // Update the eye icon to indicate that the password is now visible
        eyeButton.classList.remove('fa-eye');
        eyeButton.classList.add('fa-eye-slash');
    } else {
        // If the password is currently visible, hide it by changing the input type back to "password" and updating the eye icon
        isHidden = true;
        // Change the input type back to "password" to hide the password
        passwordField.type = "password";
        // Update the eye icon to indicate that the password is now hidden
        eyeButton.classList.remove('fa-eye-slash');
        eyeButton.classList.add('fa-eye');
    }
});