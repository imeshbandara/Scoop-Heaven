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

// ===== Scoop Heaven AJAX Cart =====
(function () {
    const toastEl = document.querySelector('.toast') || (() => {
        const el = document.createElement('div');
        el.className = 'toast';
        document.body.appendChild(el);
        return el;
    })();

    function showToast(text) {
        toastEl.textContent = text;
        toastEl.classList.add('show');
        window.clearTimeout(showToast.__t);
        showToast.__t = window.setTimeout(() => {
            toastEl.classList.remove('show');
        }, 2200);
    }

    function updateCartCount(cartCount) {
        const countEl = document.getElementById('cart-count');
        if (countEl) countEl.textContent = String(cartCount ?? 0);
    }

    function formatAddToast(message, name) {
        // Example requirement: "Vanilla Bean added to cart!"
        const rawName = (name || '').trim();
        if (!rawName) return message;
        const shortName = rawName.replace(/^Classic\s+/i, '').trim();
        if (!shortName) return message;
        return `${shortName} added to cart!`;
    }

    function renderCartTable(data) {
        const tbody = document.getElementById('cart-items-body');
        if (!tbody) return;

        const items = Array.isArray(data.items) ? data.items : [];
        tbody.innerHTML = '';

        items.forEach((item) => {
            const id = item.id ?? 0;
            const name = item.name ?? '';
            const price = Number(item.price ?? 0);
            const qty = Number(item.quantity ?? 0);
            const image = item.image ?? '';
            const lineTotal = price * qty;

            const tr = document.createElement('tr');
            tr.setAttribute('data-id', String(id));

            tr.innerHTML = `
                <td>
                    <div class="cart-item">
                        <img class="cart-item__img" src="${image}" alt="">
                        <div class="cart-item__meta">
                            <div class="cart-item__name">${name}</div>
                        </div>
                    </div>
                </td>
                <td>Rs. ${price.toFixed(2)}</td>
                <td>
                    <div class="cart-qty">
                        <button class="cart-qty-btn qty-minus" type="button" data-action="decrement" data-id="${id}" data-quantity="${qty}" aria-label="Decrease quantity">-</button>
                        <span class="cart-qty-value">${qty}</span>
                        <button class="cart-qty-btn qty-plus" type="button" data-action="increment" data-id="${id}" data-quantity="${qty}" aria-label="Increase quantity">+</button>
                    </div>
                </td>
                <td class="cart-line-total">Rs. ${lineTotal.toFixed(2)}</td>
                <td>
                    <button class="cart-remove-btn" type="button" data-id="${id}" aria-label="Remove item">Remove</button>
                </td>
            `;

            tbody.appendChild(tr);
        });

        const subtotalEl = document.getElementById('cart-subtotal');
        const grandTotalEl = document.getElementById('cart-grand-total');
        if (subtotalEl) subtotalEl.textContent = `Rs. ${(Number(data.subtotal ?? 0)).toFixed(2)}`;
        if (grandTotalEl) grandTotalEl.textContent = `Rs. ${(Number(data.grandTotal ?? 0)).toFixed(2)}`;

        updateCartCount(data.cartCount ?? 0);
    }

    async function postCartAction(payload) {
        const res = await fetch('cart_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });
        const text = await res.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('cart_handler.php non-JSON response:', text);
            return { success: false, message: 'Cart request failed.' };
        }
    }

    document.addEventListener('click', async (e) => {
        const qtyBtn = e.target.closest('.cart-qty-btn');
        if (qtyBtn) {
            const id = qtyBtn.dataset.id;
            const action = qtyBtn.dataset.action;
            const currentQty = Number(qtyBtn.dataset.quantity ?? 0);
            const newQty = action === 'increment' ? currentQty + 1 : currentQty - 1;

            try {
                const data = await postCartAction({ action: 'update', id: id, quantity: newQty });
                if (data && data.success) {
                    renderCartTable(data);
                    showToast(data.message || 'Cart updated.');
                } else {
                    showToast((data && data.message) ? data.message : 'Unable to update cart.');
                }
            } catch (err) {
                showToast('Network error. Please try again.');
            }
            return;
        }

        const removeBtn = e.target.closest('.cart-remove-btn');
        if (removeBtn) {
            const id = removeBtn.dataset.id;
            try {
                const data = await postCartAction({ action: 'remove', id: id });
                if (data && data.success) {
                    renderCartTable(data);
                    showToast(data.message || 'Item removed.');
                } else {
                    showToast((data && data.message) ? data.message : 'Unable to remove item.');
                }
            } catch (err) {
                showToast('Network error. Please try again.');
            }
            return;
        }
    });
})();