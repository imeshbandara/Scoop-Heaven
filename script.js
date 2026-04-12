let search = document.querySelector('.search-box');

document.querySelector('#search-icon').onclick = ()=>{
    search.classList.toggle('active');

    navbar.classList.remove('active');
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu-icon').onclick = ()=>{
    navbar.classList.toggle('active');

    search.classList.remove('active');
}

window.onscroll =()=>{
    navbar.classList.remove('active');
    search.classList.remove('active');
}

// ===== Dark Mode Toggle =====
const darkModeToggle = document.querySelector('#dark-mode-toggle');

// Apply saved preference on page load
if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
    darkModeToggle.classList.replace('bx-moon', 'bx-sun');
}

darkModeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
        darkModeToggle.classList.replace('bx-moon', 'bx-sun');
    } else {
        localStorage.setItem('darkMode', 'disabled');
        darkModeToggle.classList.replace('bx-sun', 'bx-moon');
    }
});

(function () {
    var prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    function initOurServiceReveal() {
        var section = document.getElementById("our-service");
        if (!section) return;

        if (prefersReduced) {
            section.querySelectorAll("[data-service-animate], [data-service-animate-image]").forEach(function (el) {
                el.classList.add("is-visible");
            });
            return;
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                });
            },
            { root: null, rootMargin: "0px 0px -8% 0px", threshold: 0.12 }
        );

        section.querySelectorAll("[data-service-animate]").forEach(function (el, i) {
            el.style.transitionDelay = i * 0.08 + "s";
            observer.observe(el);
        });

        var imgWrap = section.querySelector("[data-service-animate-image]");
        if (imgWrap) {
            imgWrap.style.transitionDelay = "0.15s";
            observer.observe(imgWrap);
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initOurServiceReveal);
    } else {
        initOurServiceReveal();
    }
})();

// ===== Live Search Logic =====
const searchInput = document.querySelector('#flavor-search');
const productContainer = document.querySelector('.product-container');

if (searchInput && productContainer) {
    searchInput.addEventListener('keyup', function() {
        let searchTerm = this.value;

        // AJAX Request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_flavors.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if(this.status == 200) {
                productContainer.innerHTML = this.responseText;
            }
        }
        xhr.send('query=' + searchTerm);
    });
}