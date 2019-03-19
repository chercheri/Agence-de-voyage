var slideIndex_home = 0;
showSlides_home();

function showSlides_home() {
    var i;
    var slides = document.getElementsByClassName("mySlides-home");
    var dots = document.getElementsByClassName("dot-home");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex_home++;
    if (slideIndex_home > slides.length) {slideIndex_home = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active-home", "");
    }
    slides[slideIndex_home-1].style.display = "block";  
    dots[slideIndex_home-1].className += " active-home";
    setTimeout(showSlides_home, 7000); // Change image every 7 seconds
}