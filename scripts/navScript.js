// Get references to the hamburger button and the mobile menu elements in the DOM
const hamburger = document.getElementById("hamburger-btn");
const menu = document.getElementById("mobile-menu");

// Add a click event listener to the hamburger button to toggle the "open" class on both the hamburger and menu elements, which controls the visibility of the mobile menu
hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("open");
    menu.classList.toggle("open");
});