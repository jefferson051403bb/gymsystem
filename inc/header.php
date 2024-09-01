<?php

    $contact_q = "SELECT * FROM `contact_details` WHERE `contact_id`=?";
    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_q,$values,'i'));
    
    $contact_q = "SELECT * FROM `settings` WHERE `settings_id`=?";
    $values = [1];
    $contact_s = mysqli_fetch_assoc(select($contact_q,$values,'i'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>

        .dropdown-item.active{
            background-color: #09858d !important;
            color: white !important;
        }

        .dropdown-item:active{
            background-color: #09858d !important;
        }

        .dropdown-item:hover{
            background-color: #e0e0e0 !important;
        }

        .btn1{
            background-color: #323232 !important;
            border: 1px solid #323232 !important;
            color: white !important;
        }

        .btn1:hover{
            background-color: #096066 !important;
        }


        
    </style>
</head>
<body>


<!-- NAVBAR -->

<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <img src="images/mygym.jpg" alt="Logo" class="mr-2" style="height: 50px; width: 50px; border-radius: 50%;">
        <a class="navbar-brand me-4 fw-bold fs-3 h-font text-white whover" href="index.php"><?php echo $contact_s['site_title'] ?></a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
                <li class="nav-item text-danger">
                    <a class="navbut nav-link m-2" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="navbut nav-link m-2" href="trainors.php">Trainor</a>
                </li>
                <li class="nav-item">
                    <a class="navbut nav-link m-2" href="pricing.php">Plan</a>
                </li>
                <li class="nav-item">
                    <a class="navbut nav-link m-2" href="specialty.php">Services</a>
                </li>      
                <li class="nav-item">
                    <a class="navbut nav-link m-2" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="navbut nav-link m-2" href="contact.php">Contact Us</a>
                </li>            
            </ul>
        </div>
        <div class="drop">
            <?php
                if (isset($_SESSION['login']) && $_SESSION['login']==true)
                { 
                    echo<<<data
                    <div class="btn-group">
                        <button type="button" class="btn shadow-none mr-3 dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            $_SESSION[uName]
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end mr-3">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="appointment.php">Booking</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    data;    
                }
                else
                {
                    echo<<<data
                    <button type="button" class="btn shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Login
                    </button>
                    <button type="button" class="btn shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>
                    data;
                }
            ?>
    
        </div>
    </div>
</nav>

<!-- LOGIN MODAL -->

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="login-form">

                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Login
                    </h5>
                    <button type="button reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email/Mobile Number</label>
                            <input type="text" name="email_mob" required class="form-control shadow-none">
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Password</label>
                            <input type="password" name="pass" required class="form-control shadow-none">
                        </div class=>
                        <div class="d-flex align-items-center mb-4">
                            <a href="javascript: void(0)" class="text-secondary text-decoration-none small">Forgot Password?</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <button type="submit" class="btn btn1 btn-primary shadow-none me-lg-2 me-3 w-50 my-1">Login</button>
                        </div>
                        <div class="d-flex align-items-center mt-4 justify-content-center">
                            <a class="text-secondary text-decoration-none small">Don't have an account?</a>
                            <a href="javascript: void(0)" class="text-primary text-decoration-none small" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                    </div>                           
                </div>
            </form>               
        </div>
    </div>
</div>

<!-- REGISTER MODAL -->

<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form">

                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-lines-fill fs-3 me-2"></i>
                        User Registration
                    </h5>
                    <button type="button reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Your details must match your ID.
                        </span>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input name="dob" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="phonenum" value="63" type="number" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 p-0 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="3" required></textarea>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Password</label>
                                    <input name="pass" type="password" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input name="cpass" type="password" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-4">
                                    <label class="form-label">Picture</label>
                                    <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary shadow-none me-lg-2 me-3 w-50 my-1 qr-generator"onclick="generateQrCode()">Register</button>
                        </div>
                   
                </div>
            </form>               
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>

   
</script>

</body>
</html>


