const hamburger = document.getElementById("hamburger-btn");
const menu = document.getElementById("mobile-menu");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("open");
    menu.classList.toggle("open");
});