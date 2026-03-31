const jumboBody = document.querySelector(".jumbo .card-body");
const jumboImgBody = document.querySelector(".jumbo .card-img");
const jumbo = document.querySelector(".jumbo");
let currentSlide = 0;

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

const slideConstruction = () => {
    let slide = jumboSlides[currentSlide];

    const jumboTitle = document.createElement('h1');
    jumboTitle.classList.add('text-primary');
    jumboTitle.innerHTML = slide.title;

    const jumboSubtitle = document.createElement('h2');
    jumboSubtitle.classList.add('text-secondary');
    jumboSubtitle.innerHTML = slide.subtitle;

    const jumboDescription = document.createElement('p');
    jumboDescription.classList.add('text-primary');
    jumboDescription.innerHTML = slide.description;

    jumboBody.appendChild(jumboTitle);
    jumboBody.appendChild(jumboSubtitle);
    jumboBody.appendChild(jumboDescription);

    const jumboImg = document.createElement('img');
    jumboImg.src = slide.image;
    jumboImg.alt = "Jumbo Image";
    jumboImg.classList.add('card-img');

    const jumboImgCredit = document.createElement('p');
    jumboImgCredit.classList.add('img-credit-caption', 'p-sm');
    jumboImgCredit.innerHTML = slide.imageCredit;

    jumboImgBody.appendChild(jumboImg);
    jumboImgBody.appendChild(jumboImgCredit);

}

const roundBtnActive = () => {
    const roundBtnArray = document.querySelectorAll('.round-jumbo-btn');
    roundBtnArray.forEach((roundBtn) => {
        if (roundBtn.classList.contains('active')) {
            roundBtn.classList.remove('active');
        }
        roundBtnArray[currentSlide].classList.add('active');
    });
}


slideConstruction();

const jumboControls = document.createElement('div');
jumboControls.classList.add('w-full', 'flex', 'flex-row', 'justify-center', 'items-center', 'p-md');

jumboSlides.forEach((slide, index) => {
    const roundBtn = document.createElement('div');
    roundBtn.classList.add('round-jumbo-btn', 'm-sm');

    roundBtn.addEventListener('click', () => {
        while (jumboBody.firstChild) {
            jumboBody.removeChild(jumboBody.firstChild);
        }
        while (jumboImgBody.firstChild) {
            jumboImgBody.removeChild(jumboImgBody.firstChild);
        }

        currentSlide = index;
        slideConstruction();
        roundBtnActive();
    });

    jumboControls.appendChild(roundBtn);
    
});

jumbo.appendChild(jumboControls);

roundBtnActive();
const setSlideIteratively = () => {
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

setInterval(setSlideIteratively, 10000)