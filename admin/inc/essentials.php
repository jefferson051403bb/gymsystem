<?php

    //FRONT END PURPOSE

    define('SITE_URL','http://127.0.0.1/gymko/');
    define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
    define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
    define('TRAINORS_IMG_PATH',SITE_URL.'images/trainors/');
    
    //BACK END PURPOSE

    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/gymko/images/');
    define('ABOUT_FOLDER','about/');
    define('CAROUSEL_FOLDER','carousel/');
    define('USERS_FOLDER','users/');
    define('TRAINORS_FOLDER','trainors/');

    function adminLogin()
    {
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
            echo"<script>
                window.location.href='index.php';
            </script>";
            exit;
        }
    }

    function redirect($url)
    {
        echo"<script>
            window.location.href='$url';
        </script>";
        exit;
    }

    function alert($type,$msg)
    {
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert text-center" role="alert">
                <strong class="me-3">$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    function uploadImage($image,$folder)
    {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img'; //INVALID IMAGE MIME OR FORMAT
        }
        else if(($image['size']/(1024*1024))>30)
        {
            return 'inv_size'; //INVALID SIZE GREATER THAN 30mb
        }
        else
        {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else
            {
                return 'upd_failed';
            }
        }
    }

    function deleteImage($image,$folder)
    {
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }
        else{
            return false;
        }
    }

    function uploadUserImage($image)
    {
        $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
        $img_mime = $image['type'];
    
        // Check if the MIME type is valid
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img'; // INVALID IMAGE MIME OR FORMAT
        } else {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_' . random_int(11111, 99999) . ".jpeg";
    
            $img_path = UPLOAD_IMAGE_PATH . USERS_FOLDER . $rname;
    
            // Create an image resource based on the image type
            if (($ext == 'png' || $ext == 'PNG') && function_exists('imagecreatefrompng')) {
                $img = imagecreatefrompng($image['tmp_name']);
            } elseif (($ext == 'webp' || $ext == 'WEBP') && function_exists('imagecreatefromwebp')) {
                $img = imagecreatefromwebp($image['tmp_name']);
            } elseif (function_exists('imagecreatefromjpeg')) {
                $img = imagecreatefromjpeg($image['tmp_name']);
            } else {
                return 'gd_missing';
            }
    
            // Save the image as JPEG with a quality of 75
            if (imagejpeg($img, $img_path, 75)) {
                return $rname;
            } else {
                return 'upd_failed';
            }
        }
        
        function adminLogin() {
            session_start();
        
            // Check if the user is logged in
            if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                // Redirect to login page if not logged in
                header('Location: login.php');
                exit();
            }
        }
    }
    
    

?>