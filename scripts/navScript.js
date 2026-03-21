
/** 
 * 
 * 
 * Mobile navigation event listeners
 * This allows for more space in the navbar.
 * Allows the usr to toggle the nav to take up the page screen
 * 
 */

// Query for the hamburger div. This div contains three divs which make up the lines
const hamburgerBtn = document.querySelector('.hamburger');
// Query for the mobile nav menu which is hidden by default
const mobileNavMenu = document.querySelector('.hidden-nav');
// Query for the close button. This div contains two divs which make up the 'X' icon
const xBtn = document.querySelector('.close-x');

// Event listener for the hamburger button. Event is a click
hamburgerBtn.addEventListener('click', () => {
    // If the mobile nav menu is already hidden
    if (mobileNavMenu.classList.contains('hidden-nav')) {
        // Remove the hidden-nav class. The nav is technically displayed beyond the screen
        mobileNavMenu.classList.remove('hidden-nav');
        // Add the show-nav class to the navigation. This allows for a smooth transition
        mobileNavMenu.classList.add('show-nav');
        // Hide the hamburger button
        hamburgerBtn.classList.add('hidden');
        // Show the close button
        xBtn.classList.remove('hidden');
    }
});

// Event listener for the close button. Event is a click
xBtn.addEventListener('click', () => {
    // If the mobile nav is not hidden
    if (mobileNavMenu.classList.contains('show-nav')) {
        // Remove the show-nav class
        mobileNavMenu.classList.remove('show-nav');
        // Add the hidden nav class for a smoother transition
        mobileNavMenu.classList.add('hidden-nav');
        // Show the hamburger button
        hamburgerBtn.classList.remove('hidden');
        // Hide the close button
        xBtn.classList.add('hidden');
    }
});

/**
 * End of mobile navigation logic
 */