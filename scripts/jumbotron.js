// JavaScript for handling the functionality of the jumbotron on the homepage, including slide construction and navigation controls
// Select the necessary DOM elements for the jumbotron
// Select the card body where the title, subtitle, and description will be displayed
const jumboBody = document.querySelector(".jumbo .card-body");
// Select the card image container where the image and its credit will be displayed
const jumboImgBody = document.querySelector(".jumbo .card-img");
const jumbo = document.querySelector(".jumbo");
// Initialize the current slide index to 0
let currentSlide = 0;

// Define an array of slide objects, each containing the title, subtitle, description, image source, and image credit for a slide in the jumbotron
const jumboSlides = [
    {
        title: `Welcome to SLS`,
        subtitle: `The Simple Library System`,
        description: `
            Developed by a student from the <span class="link">University of Windsor</span>, the Simple Library System combines web technologies to provide the best experience for our community of readers.
            We provide this service to anyone who needs to borrow books, online, for free! 
            <br>
            <br>
            <a class="btn btn-primary" href="../browse/browse.php">Browse our catalog</a>
        `,
        image: `../images/home/pexels-sara-ahmed-library.jpg`,
        imageCredit: `image credit: <a class="link" href="https://www.pexels.com/@sara-ahmed-2149611392/">Sara Ahmed</a>`
    },
    {
        title: `Books & Scholarly Content`,
        subtitle: `Browse our collection`,
        description: `
        Explore a range of books, academic resources, and other curated content. We're here to be apart of the worldwide reading community
        and dedicate our services to providing resources to those who need it.
        <br>
        <br>
        For more information about our mission, please see the <a class="link" href="../info/about.php">about us</a> section in our site and make sure to <a class="link" href="../forms/contactus.php">contact us</a> for inquiries regarding
        partnership and more!`,
        image: `../images/home/shkrabaanthony-world-map.jpg`,
        imageCredit: `image credit: <a class="link" href="https://www.pexels.com/@shkrabaanthony/">Antoni Shkraba</a>`
    },
    {
        title: `Borrow with Ease`,
        subtitle: `Quick & Simple`,
        description: `
        Borrow and browse our catalog with just one click, view your <a class="link" href="../profile/history.php">history</a> and <a class="link" href="../profile/mybooks.php">borrowed books</a> while logged in,
        and make the best of the ten borrowing credits provided to you each month!
        <br>
        <br>
        Our system is designed to be as simple, effective, and accessible for everyone.
        <br>
        <br>
        `,
        image: `../images/home/gulfer-ergin-books-unsplash.jpg`,
        imageCredit: `image credit: <a class="link" href="https://unsplash.com/@gulfergin_01">Gülfer ERGİN</a>`
    }
]

// Function to construct the current slide's content and display it in the jumbotron
const slideConstruction = () => {
    // Get the current slide object based on the currentSlide index
    let slide = jumboSlides[currentSlide];
    // Create and populate the title, subtitle, and description elements for the current slide
    const jumboTitle = document.createElement('h1');
    // Add the text-primary class to the title for styling and set its inner HTML to the slide's title
    jumboTitle.classList.add('text-primary');
    jumboTitle.innerHTML = slide.title;

    // Create the subtitle element, add the text-secondary class for styling, and set its inner HTML to the slide's subtitle
    const jumboSubtitle = document.createElement('h2');
    jumboSubtitle.classList.add('text-secondary');
    jumboSubtitle.innerHTML = slide.subtitle;

    // Create the description element, add the text-primary class for styling, and set its inner HTML to the slide's description
    const jumboDescription = document.createElement('p');
    jumboDescription.classList.add('text-primary');
    jumboDescription.innerHTML = slide.description;

    // Append the title, subtitle, and description elements to the jumboBody container in the jumbotron
    jumboBody.appendChild(jumboTitle);
    jumboBody.appendChild(jumboSubtitle);
    jumboBody.appendChild(jumboDescription);

    // Create the image element for the current slide, set its source and alt text, and add the card-img class for styling
    const jumboImg = document.createElement('img');
    jumboImg.src = slide.image;
    jumboImg.alt = "Jumbo Image";
    jumboImg.classList.add('card-img');

    // Create the image credit element, add the img-credit-caption and p-sm classes for styling, and set its inner HTML to the slide's image credit
    const jumboImgCredit = document.createElement('p');
    jumboImgCredit.classList.add('img-credit-caption', 'p-sm');
    jumboImgCredit.innerHTML = slide.imageCredit;

    // Append the image and its credit to the jumboImgBody container in the jumbotron
    jumboImgBody.appendChild(jumboImg);
    jumboImgBody.appendChild(jumboImgCredit);

}

// Function to update the active state of the round navigation buttons based on the current slide index
const roundBtnActive = () => {
    // Select all round navigation buttons and iterate through them to update their active state
    const roundBtnArray = document.querySelectorAll('.round-jumbo-btn');
    roundBtnArray.forEach((roundBtn) => {
        if (roundBtn.classList.contains('active')) {
            roundBtn.classList.remove('active');
        }
        roundBtnArray[currentSlide].classList.add('active');
    });
}

// Initial construction of the first slide in the jumbotron when the page loads
slideConstruction();

// Create the round navigation buttons for the jumbotron and add click event listeners to them for slide navigation
const jumboControls = document.createElement('div');
jumboControls.classList.add('w-full', 'flex', 'flex-row', 'justify-center', 'items-center', 'p-md');

// Iterate through the jumboSlides array to create a round button for each slide and add it to the jumboControls container
jumboSlides.forEach((slide, index) => {
    // Create a round button element, add the appropriate classes for styling, and add a click event listener to navigate to the corresponding slide when clicked
    const roundBtn = document.createElement('div');
    roundBtn.classList.add('round-jumbo-btn', 'm-sm');
    // Add a click event listener to the round button to navigate to the corresponding slide when clicked
    roundBtn.addEventListener('click', () => {
        // Remove the existing content from the jumboBody and jumboImgBody containers before constructing the new slide's content
        while (jumboBody.firstChild) {
            jumboBody.removeChild(jumboBody.firstChild);
        }
        while (jumboImgBody.firstChild) {
            jumboImgBody.removeChild(jumboImgBody.firstChild);
        }
        // Update the currentSlide index to the index of the clicked round button and construct the new slide's content
        currentSlide = index;
        slideConstruction();
        roundBtnActive();
    });
    // Append the round button to the jumboControls container
    jumboControls.appendChild(roundBtn);
    
});

// Append the jumboControls container, which contains the round navigation buttons, to the jumbotron element
jumbo.appendChild(jumboControls);

roundBtnActive();
const setSlideIteratively = () => {
    // Update the currentSlide index to show the next slide, looping back to the first slide after reaching the end of the jumboSlides array
    if (currentSlide < jumboSlides.length - 1) {
        currentSlide += 1;
    }
    else if (currentSlide >= jumboSlides.length - 1) {
        currentSlide = 0;
    }
    while (jumboBody.firstChild) {
        jumboBody.removeChild(jumboBody.firstChild);
    }
    while (jumboImgBody.firstChild) {
        jumboImgBody.removeChild(jumboImgBody.firstChild);
    }

    slideConstruction();
    roundBtnActive();
   
    
}

// Set an interval to automatically change the slide every 10 seconds by calling the setSlideIteratively function
setInterval(setSlideIteratively, 10000)