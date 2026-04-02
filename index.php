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
            <img src="main.png" alt="">
        </div>

    </section>
    <!--About-->

    <section class="about" id="about">
        <div class="about-img">
            <img src="about.png" alt="">
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
    <section class="products" id="products">
        <div class="heading">
            <h2>Our Popular Flavors</h2>
        </div>

        <!--contai ner-->

        <div class="product-container">

            <!--Box1-->
            <div class="box">
                <img src="p1.png" alt="Chocolate Ice Cream">
                <h3>Double Dark Chocolate</h3>
                <div class="content">
                    <span>Rs.450/=</span>
                    <a href="#">Order Now</a>
                </div>
            </div>

            <!--Box2-->
            <div class="box">
                <img src="p2.png" alt="Vanilla Ice Cream">
                <h3>Classic Vanilla Bean</h3>
                <div class="content">
                    <span>Rs.400/=</span>
                    <a href="#">Order Now</a>
                </div>
            </div>

            <!--Box3-->
            <div class="box">
                <img src="p3.png" alt="Strawberry Ice Cream">
                <h3>Fresh Strawberry</h3>
                <div class="content">
                    <span>Rs.450/=</span>
                    <a href="#">Order Now</a>
                </div>
            </div>

            <!--Box4-->
            <div class="box">
                <img src="p4.png" alt="Mint Ice Cream">
                <h3>Mint Choco Chip</h3>
                <div class="content">
                    <span>Rs.500/=</span>
                    <a href="#">Order Now</a>
                </div>
            </div>

            <!--Box5-->
            <div class="box">
                <img src="p5.png" alt="Fruit Ice Cream">
                <h3>Tutti Frutti Mix</h3>
                <div class="content">
                    <span>Rs.480/=</span>
                    <a href="#">Order Now</a>
                </div>
            </div>

            <!--Box6-->
            <div class="box">
                <img src="p6.png" alt="Sundae">
                <h3>Royal Sundae</h3>
                <div class="content">
                    <span>Rs.850/=</span>
                    <a href="#">Order Now</a>
                </div>
            </div>


        </div>


    </section>

    <!--Custormers-->

    <section class="custormers" id="custormers">

        <div class="heading">
            <h2>our custormer's</h2>
        </div>
        <!--container-->
        <div class="custormers-container">

            <div class="box">

                <div class="stars">
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star-half'></i>

                </div>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Suscipit porro quisquam optio sequi labore exercitationem
                    unde cupiditate est mollitia voluptatum. Laudantium voluptate
                    explicabo ad assumenda non neque corrupti eveniet voluptatem.

                </p>
                <h2>Imesh Bandara</h2>
                <img src="imesh.jpg" alt="">

            </div>

            <div class="box">

                <div class="stars">
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star-half'></i>

                </div>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Suscipit porro quisquam optio sequi labore exercitationem
                    unde cupiditate est mollitia voluptatum. Laudantium voluptate
                    explicabo ad assumenda non neque corrupti eveniet voluptatem.

                </p>
                <h2>Alexandra Daddario</h2>
                <img src="alexandra.jpg" alt="">

            </div>

            <div class="box">

                <div class="stars">
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>
                    <i class='bx  bx-star'></i>


                </div>
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Suscipit porro quisquam optio sequi labore exercitationem
                    unde cupiditate est mollitia voluptatum. Laudantium voluptate
                    explicabo ad assumenda non neque corrupti eveniet voluptatem.

                </p>
                <h2>Zark Zuckerberg</h2>
                <img src="mark.jpg" alt="">

            </div>

        </div>

    </section>

    <!--footer section-->

    <?php include 'includes/footer.php'; ?>

</body>

</html>