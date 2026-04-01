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