document.addEventListener("DOMContentLoaded", function() {
    let pageClass = document.body.classList[0]; // Az oldal osztályát lekéri
    let backgrounds = {
        "page1": "hatter.jpg",
        "page2": "blog.jpg",
        "page3": "tamogatas.jpg"
    };

    document.querySelector(".bg-pan-tl").style.backgroundImage = `url('${backgrounds[pageClass]}')`;
});

// Háttér mozgatása görgetésre
document.addEventListener("scroll", function () {
    const bgElement = document.querySelector(".bg-pan-tl");
    if (!bgElement) return;

    // Az oldal görgetési pozíciója
    const scrollPercent = window.scrollY / (document.body.scrollHeight - window.innerHeight) * 100;

    // Dinamikusan frissítjük a háttér pozícióját
    bgElement.style.backgroundPosition = `50% ${scrollPercent}%`;
});

// Görgetés gomb megjelenítése/elrejtése
document.addEventListener("DOMContentLoaded", function() {
    let scrollToTopButton = document.getElementById("scrollToTop");

    window.addEventListener("scroll", function() {
        if (window.scrollY > 300) { 
            scrollToTopButton.style.display = "block"; 
        } else {
            scrollToTopButton.style.display = "none"; 
        }
    });

    scrollToTopButton.addEventListener("click", function() {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});

// Kép tükrözése
document.querySelector(".fixed-image").style.transform = "scaleX(-1)";
