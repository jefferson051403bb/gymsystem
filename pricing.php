<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Pricing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- LINKS -->
    <?php require('inc/links.php') ?>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .pricing {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin: 2rem 0;
        }

        .pricing .plan {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        }

        .pricing .plan h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #000; /* Changed to black */
}

.pricing .plan .price {
    font-size: 3rem;
    font-weight: bold;
    color: #0070f3; /* Changed to blue */
    margin: 1rem 0;
}

.pricing .plan .price span {
    font-size: 1.5rem;
    color: #777; /* Retained as is for currency symbol */
}

.pricing .plan .list p {
    font-size: 1.2rem;
    color: #000; /* Changed to black */
}

.pricing .plan .list p i {
    color: #9CD02F; /* Retained as is for icons */
}


        .pricing .plan .btn {
        background-color: black;
        color: white;
        border: 1px solid black;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        text-transform: uppercase;
        font-weight: bold;
        }

        .pricing .plan .btn:hover {
        background-color: #335272;
        color: white;
        border-color: #335272;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
        .pricing {
        grid-template-columns: 1fr;
        }
        }
    </style>
</head>
<body>

    <!-- HEADER/NAVBAR -->
    <?php require('inc/header.php') ?>
    <!-- HEADER/NAVBAR -->

    <div class="container">
        <div class="my-5 px-4">
            <h2 class="fw-bold text-center">Gym Pricing Plans</h2>
            <div class="h-line bg-dark"></div>
        </div>

        <section class="pricing" id="pricing">

<div class="plan">
    <h3>Day Pass</h3>
    <div class="price"><span>₱</span>35<span>/day</span></div>
    <div class="list">
        <p>Enjoy a full day of access to all gym facilities, including cardio, weights, and group classes.</p>
    </div>
    <a href="payment.php" class="btn">Subscribe</a>
</div>

<div class="plan">
    <h3>Weekly Warrior</h3>
    <div class="price"><span>₱</span>245<span>/week</span></div>
    <div class="list">
        <p>Unlock a week of unlimited access to our gym, with additional perks like diet plans and group sessions.</p>
    </div>
    <a href="payment.php" class="btn">Subscribe</a>
</div>

<div class="plan">
    <h3>Monthly Master</h3>
    <div class="price"><span>₱</span>999<span>/mo</span></div>
    <div class="list">
        <p>Commit to a month of full access, including personalized training, diet planning, and progress tracking.</p>
    </div>
    <a href="payment.php" class="btn">Subscribe</a>
</div>

</section>
    </div>

    <!-- FOOTER -->
    <?php require('inc/footer.php') ?>
    <!-- FOOTER -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 4,
            spaceBetween: 40,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    </script>
</body>
</html>
