class Carrusel {
    slideIndex = 1;

    constructor() {
        this.showSlides(this.slideIndex);
    }

    plusSlides(n) {
        this.slideIndex += n;
        this.showSlides(this.slideIndex);
    }

    currentSlide(n) {
        this.slideIndex = n;
        this.showSlides(this.slideIndex);
    }

    showSlides(n) {
        let i;
        let slides = document.querySelectorAll("body div div");


        if (n > slides.length) {
            this.slideIndex = 1
        }

        if (n < 1) {
            this.slideIndex = slides.length
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slides[this.slideIndex - 1].style.display = "block";
    }
}

let carrusel = new Carrusel();