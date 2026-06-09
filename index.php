<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoop Heaven - Premium Ice Cream</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <!--Navbar-->
    <?php include 'includes/header.php'; ?>
    <?php include('config/db.php'); ?>

    <!--home-->
    <section class="home" id="home">
        <div class="home-text">
            <h1>Scoop up<br>some happiness!</h1>
            <p>Premium artisanal ice cream made with love and the
                finest ingredients. Experience the joy of real cream,
                fresh fruits, and delightful flavors in every scoop.<br><br></p>
            <a href="#products" class="btn">View Menu</a>
        </div>
        <div class="home-img">
            <img src="asset/main.png" alt="">
        </div>

    </section>
    <!--About-->

    <section class="about" id="about">
        <div class="about-img">
            <img src="asset/about.png" alt="">
        </div>
        <div class="about-text">
            <h2>Our Sweet Story</h2>
            <p>It all started with a dream to create the perfect scoop.
                We believe that ice cream is more than just a dessert;
                it's a moment of joy, a celebration, and a memory in the making.
            </p>
            <p>
                Our ice creams are handcrafted daily using locally sourced
                dairy and fresh fruits. No artificial preservatives, just
                pure, creamy goodness that melts in your mouth and warms
                your heart. Come taste the difference!
            </p>
            <a href="#" class="btn">Read More</a>
        </div>

    </section>

    <!--Our Service-->
    <section id="our-service" aria-labelledby="our-service-heading">
        <div class="service-inner">
            <div class="service-content">
                <span class="service-eyebrow">Our Service</span>
                <h2 id="our-service-heading">We Put Service First</h2>
                <p class="service-subheading">
                    Every scoop is served with care—spotless spaces, thoughtful touches, and a team that treats you like family.
                </p>
                <div class="service-features">
                    <article class="service-feature" data-service-animate>
                        <div class="service-feature-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="service-feature-text">
                            <h3>Clean &amp; Hygienic</h3>
                            <p>Rigorous cleaning standards so every visit feels fresh and safe.</p>
                        </div>
                    </article>
                    <article class="service-feature" data-service-animate>
                        <div class="service-feature-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="service-feature-text">
                            <h3>Friendly Service</h3>
                            <p>Warm welcomes and genuine smiles with every order.</p>
                        </div>
                    </article>
                    <article class="service-feature" data-service-animate>
                        <div class="service-feature-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div class="service-feature-text">
                            <h3>Premium Quality</h3>
                            <p>Fine ingredients and careful prep in every scoop we serve.</p>
                        </div>
                    </article>
                    <article class="service-feature" data-service-animate>
                        <div class="service-feature-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="service-feature-text">
                            <h3>Customer Comfort</h3>
                            <p>Cozy seating and a relaxed pace so you can truly enjoy.</p>
                        </div>
                    </article>
                </div>
            </div>
            <div class="service-visual">
                <div class="service-image-wrap" data-service-animate-image>
                    <img
                        src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=800&q=80"
                        alt="Staff member serving ice cream in a bright, welcoming shop"
                        width="800"
                        height="1000"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>
    </section>

    <!--products-->

    <section class="trending" id="trending" style="padding-bottom: 20px;">
    <div class="heading">
        <span style="color: var(--main-color); font-weight: 600; text-transform: uppercase;">Most Loved</span>
        <h2>Trending Now</h2>
    </div>

    <div class="product-container">
        <?php
        // Query to find the top 3 flavors based on order count
        $trending_sql = "SELECT flavor_name, COUNT(*) as total_orders 
                         FROM orders 
                         GROUP BY flavor_name 
                         ORDER BY total_orders DESC 
                         LIMIT 3";
        $trending_result = mysqli_query($conn, $trending_sql);

        if (mysqli_num_rows($trending_result) > 0) {
            $details_stmt = mysqli_prepare($conn, "SELECT * FROM flavors WHERE name = ? LIMIT 1");
            if ($details_stmt) {
                while($t_row = mysqli_fetch_assoc($trending_result)) {
                    $f_name = $t_row['flavor_name'];
                    mysqli_stmt_bind_param($details_stmt, "s", $f_name);
                    if (mysqli_stmt_execute($details_stmt)) {
                        $details_res = mysqli_stmt_get_result($details_stmt);
                        if ($details = mysqli_fetch_assoc($details_res)) {
                            $tImg = $details['image_path'] ?? '';
                            if ($tImg !== '' && strpos($tImg, '/') === false) {
                                $tImg = 'asset/' . $tImg;
                            }
                            if ($tImg === '') {
                                $tImg = 'asset/main.png';
                            }
                            $safeImg = htmlspecialchars($tImg, ENT_QUOTES, 'UTF-8');
                            $safeName = htmlspecialchars($details['name'] ?? '', ENT_QUOTES, 'UTF-8');
                            $safePrice = htmlspecialchars($details['price'] ?? '', ENT_QUOTES, 'UTF-8');
                            ?>
                            <div class="box" style="border: 2px solid var(--main-color);">
                                <div style="position: absolute; top: 10px; right: 10px; background: gold; color: #333; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; z-index: 10;">
                                    🔥 Bestseller
                                </div>
                                <img src="<?php echo $safeImg; ?>" alt="<?php echo $safeName; ?>">
                                <h3><?php echo $safeName; ?></h3>
                                <div class="content">
                                    <span>Rs. <?php echo $safePrice; ?>/=</span>
                                    <button
                                        type="button"
                                        class="btn add-to-cart"
                                        data-id="<?php echo (int)($details['id'] ?? 0); ?>"
                                        data-name="<?php echo $safeName; ?>"
                                        data-price="<?php echo (float)($details['price'] ?? 0); ?>"
                                        data-image="<?php echo $safeImg; ?>"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                mysqli_stmt_close($details_stmt);
            }
        }
        } else {
            echo "<p style='text-align:center; width:100%;'>Start ordering to see what's trending!</p>";
        }
        ?>
    </div>
</section>

<hr style="border: 0; height: 1px; background: #eee; margin: 0 100px;">

    <section class="products" id="products">
        <div class="heading">
            <h2>Our Popular Flavors</h2>
        </div>

        <!--contai ner-->
        <div class="product-container">
    <?php
    
    // Popular flavors for the homepage in fixed display order.
    $sql = "SELECT * FROM flavors
            WHERE name IN (
                'Classic Vanilla Bean',
                'Fresh Strawberry',
                'Mint Chocolate Chip',
                'Tutti Frutti Mix',
                'Royal Hot Fudge Sundae'
            )
            ORDER BY FIELD(name,
                'Classic Vanilla Bean',
                'Fresh Strawberry',
                'Mint Chocolate Chip',
                'Tutti Frutti Mix',
                'Royal Hot Fudge Sundae'
            )";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $img = $row['image_path'] ?? '';
            // If DB stores just 'p2.png', load it from /asset/
            if ($img !== '' && strpos($img, '/') === false) {
                $img = 'asset/' . $img;
            }
            if ($img === '') {
                $img = 'asset/main.png';
            }
            $safeImg = htmlspecialchars($img, ENT_QUOTES, 'UTF-8');
            $safeName = htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8');
            $safePrice = htmlspecialchars($row['price'] ?? '', ENT_QUOTES, 'UTF-8');
            ?>
            <div class="box">
                <img src="<?php echo $safeImg; ?>" alt="<?php echo $safeName; ?>">
                <h3><?php echo $safeName; ?></h3>
                <div class="content">
                    <span>Rs. <?php echo $safePrice; ?>/=</span>
                    <button
                        type="button"
                        class="btn add-to-cart"
                        data-id="<?php echo (int)($row['id'] ?? 0); ?>"
                        data-name="<?php echo $safeName; ?>"
                        data-price="<?php echo (float)($row['price'] ?? 0); ?>"
                        data-image="<?php echo $safeImg; ?>"
                    >
                        Add to Cart
                    </button>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No popular flavors available at the moment.</p>";
    }
    ?>
</div>

    


    </section>

    <!--Custormers-->

    <section class="custormers" id="custormers">
    <div class="heading">
        <h2>Our Customer's Reviews</h2>
    </div>

    <div class="custormers-container">
        <?php
        $rev_query = "SELECT * FROM reviews ORDER BY id DESC LIMIT 3";
        $rev_result = mysqli_query($conn, $rev_query);

        if (mysqli_num_rows($rev_result) > 0) {
            while($rev = mysqli_fetch_assoc($rev_result)) {
                $safeName = htmlspecialchars($rev['name'] ?? '', ENT_QUOTES, 'UTF-8');
                $safeMessage = htmlspecialchars($rev['message'] ?? '', ENT_QUOTES, 'UTF-8');
                $starsCount = max(0, min(5, (int)($rev['stars'] ?? 5)));
                ?>
                <div class="box">
                    <div class="stars">
                        <?php 
                        for($i=0; $i<$starsCount; $i++) {
                            echo "<i class='bx bx-star'></i>";
                        }
                        ?>
                    </div>
                    <p><?php echo $safeMessage; ?></p>
                    <h2><?php echo $safeName; ?></h2>
                    <img src="user-icon.png" alt=""> </div>
                <?php
            }
        } else {
            echo "<p>No reviews yet. Be the first to review!</p>";
        }
        ?>
    </div>
</section>

<section class="add-review" style="padding: 50px 10%; background: #fef4f8;">
    <h3>Leave a Review</h3>
    <form action="submit_review.php" method="POST" style="max-width: 500px; display: flex; flex-direction: column; gap: 10px;">
        <input type="text" name="rev_name" placeholder="Your Name" required style="padding: 10px;">
        <textarea name="rev_msg" placeholder="Your Feedback" required style="padding: 10px;"></textarea>
        <select name="rev_stars" style="padding: 10px;">
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
        </select>
        <button type="submit" name="submit_rev" class="btn">Post Review</button>
    </form>
</section>
    <!--footer section-->

    <script>
        (function () {
            function ensureToast() {
                let el = document.querySelector('.toast');
                if (el) return el;
                el = document.createElement('div');
                el.className = 'toast';
                document.body.appendChild(el);
                return el;
            }

            function showToast(text) {
                const toastEl = ensureToast();
                toastEl.textContent = text;
                toastEl.classList.add('show');
                window.clearTimeout(showToast.__t);
                showToast.__t = window.setTimeout(() => {
                    toastEl.classList.remove('show');
                }, 2200);
            }

            function updateCartCount(cartCount) {
                const countEl = document.getElementById('cart-count');
                if (countEl) {
                    const count = parseInt(cartCount ?? 0);
                    countEl.textContent = count;
                    if (count > 0) {
                        countEl.style.display = 'inline-flex';
                    } else {
                        countEl.style.display = 'none';
                    }
                }
            }

            async function postCartAction(payload) {
                const res = await fetch('cart_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }

                const text = await res.text();
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('cart_handler.php non-JSON response:', text);
                    return { success: false, message: 'Cart request failed.' };
                }
            }

            document.addEventListener('click', async function (e) {
                const addBtn = e.target.closest('.add-to-cart');
                if (!addBtn) return;

                const id = addBtn.dataset.id;
                const name = addBtn.dataset.name;
                const price = addBtn.dataset.price;
                const image = addBtn.dataset.image;

                try {
                    console.log('Add to cart clicked:', { id, name, price, image });
                    const data = await postCartAction({
                        action: 'add',
                        id: id,
                        name: name,
                        price: price,
                        image: image,
                        quantity: 1
                    });

                    console.log('cart_handler response:', data);
                    if (data && data.success) {
                        updateCartCount(data.cartCount);
                        showToast('Item added to cart!');
                        if (window.openCartSidebar) {
                            window.openCartSidebar();
                        }
                    } else {
                        showToast((data && data.message) ? data.message : 'Unable to add to cart.');
                    }
                } catch (err) {
                    console.error('Cart AJAX error:', err);
                    showToast('Network error. Please try again.');
                }
            });
        })();
    </script>

    <?php include 'includes/footer.php'; ?>

</body>

</html>