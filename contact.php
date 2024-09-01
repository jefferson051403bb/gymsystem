<?php

    // Initialize variables for pre-filled data
    $userName = '';
    $userEmail = '';

    // Check if user is logged in
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        // User is logged in, retrieve and set the user data
        $userName = $_SESSION['uName'];
        $userEmail = $_SESSION['uEmail'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM - Contact Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <?php require('inc/links.php') ?> 

    <style>
        .btn{
            background-color: #393E46 !important;
            border: 1px solid #393E46 !important;
        }

        .btn:hover{
            background-color: #096066 !important;
        }

        .btn1{
            border: 1px solid #09858d !important;
            color: #09858d !important;
            text-decoration: none !important;
        }

        .btn1:hover{
            background-color: #096066 !important;
            color: white !important;
        }

        /* Hide fields for logged-in users */
        .logged-in .hidden-field {
            display: none;
        }
    </style>
</head>
<body class="bg-light <?php echo isset($_SESSION['login']) && $_SESSION['login'] === true ? 'logged-in' : ''; ?>">
    <?php require('inc/header.php') ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold text-center">CONTACT US</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container">
        <?php 
            $contact_q = "SELECT * FROM `contact_details` WHERE `contact_id`=?";
            $values = [1];
            $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i')); 
        ?>

        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" height="320" src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>
                    <h5>Address</h5>
                    <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
                        <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?>
                    </a>
                    <h5 class="mt-4">Call us</h5>
                    <a href="tel:+<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1'] ?>
                    </a>
                    <br>
                    <?php
                        if ($contact_r['pn2'] != '') {
                            echo <<<data
                                <a href="tel:+$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                                </a>
                            data;
                        }
                    ?>
                    <h5 class="mt-4">Email</h5>
                    <a href="mailto:<?php echo $contact_r['email'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope-fill"></i> <?php echo $contact_r['email'] ?>
                    </a>
                    <h5 class="mt-4">Follow us</h5>
                    <?php
                        if ($contact_r['twt'] != '') {
                            echo <<<data
                                <a href="$contact_r[twt]" class="d-inline-block text-dark fs-5 me-2">
                                    <i class="bi bi-twitter-x me-1"></i>
                                </a>
                            data;
                        }
                    ?>
                    <a href="<?php echo $contact_r['ig'] ?>" class="d-inline-block text-dark fs-5 me-2">
                        <i class="bi bi-instagram me-1"></i>
                    </a>
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark fs-5">
                        <i class="bi bi-facebook me-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <form method="POST">
                        <h5>Send us a message.</h5>
                        <div class="mt-3 hidden-field">
                            <label class="form-label" style="font-weight: 500;">Name</label>
                            <input name="name" value="<?php echo htmlspecialchars($userName); ?>" type="text" class="form-control shadow-none" <?php echo isset($_SESSION['login']) ? 'readonly' : ''; ?>>
                        </div>
                        <div class="mt-3 hidden-field">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input name="email" value="<?php echo htmlspecialchars($userEmail); ?>" type="email" class="form-control shadow-none" <?php echo isset($_SESSION['login']) ? 'readonly' : ''; ?>>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Subject</label>
                            <input name="subject" required type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Message</label>
                            <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                        <button type="submit" name="send" class="btn text-white custom-bg mt-3">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php 
        if (isset($_POST['send'])) {
            $frm_data = filteration($_POST);

            // Ensure name and email are filled from the session if logged in
            if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
                $frm_data['name'] = $_SESSION['uName'];
                $frm_data['email'] = $_SESSION['uEmail'];
            }

            $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];

            $res = insert($q, $values, 'ssss');
            if ($res == 1) {
                alert('success', 'Mail sent!');
            } else {
                alert('error', 'Server down! Try again later!');
            }
        }
    ?>

    <?php require('inc/footer.php') ?>

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
