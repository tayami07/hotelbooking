<?php

    //frontend purpose data
    define('SITE_URL','http://127.0.0.1/hotelbooking/');
    define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
    define('USERS_IMG_PATH',SITE_URL.'images/users/');
    define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
    define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');

    //backend upload process data needs this data
    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/hotelbooking/images/');
    define('ABOUT_FOLDER','about/');
    define('USERS_FOLDER','users/');
    define('FACILITIES_FOLDER','facilities/');
    define('ROOMS_FOLDER','rooms/');

    //sendgrid api key
    define('SENDGRID_API_KEY','');
    define('SENDGRID_EMAIL','');
    define('SENDGRID_NAME','THYZEN');


    //if user is not logged in redirect them to index.php
    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin'])&& $_SESSION['adminLogin']==true)){
            header("location: index.php");
        }
        // exit;
        // session_regenerate_id(true);

        //secures old session data but generates new id
         //new session id every time adminLogin is checked
    }

    //to redirect to the url
    function redirect($url){
        echo"<script>
            window.location.href='$url';
        </script>
        ";
    }


    function alert($type,$msg){
        $bs_class = ($type=="success") ? "alert-success":"alert-danger"; //alert-success,danger class
        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    //image

    function uploadImage($image,$folder)
    {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime,$valid_mime))
        {
            return 'inv_img';                      //invalid image
        }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_size';
        }
        else{
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path))
            {
                return $rname;
            }
            else{
                return 'upd_failed';
            }
        }
    }

    function uploadUserImage($image)
    {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img';
        }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_size';
        }
        else{
            $ext = pathinfo($image['name'],PATHINFO_DIRNAME);
            $rname = 'IMG_'.random_int(11111,99999).".jpeg";

            $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

            if($ext=='png' || $ext == 'PNG'){
                $img = imagecreatefrompng($image['tmp_name']);
            }
            else if($ext=='webp' || $ext == 'WEBP')
            {
                $img = imagecreatefromwebp($image['tmp_name']);
            }
            else{
                $img = imagecreatefromjpeg($image['tmp_name']);

            }

            if(imagejpeg($img,$img_path,75))
            {
                return $rname;
            }
            else{
                return 'upd_failed';
            }
            
        }
    }

    function uploadUserIdentification($image2)
    {
        $valid_mime2 = ['image/jpeg','image/png','image/webp'];
        $img_mime2 = $image2['type'];

        if(!in_array($img_mime2,$valid_mime2)){
            return 'inv_img';
        }
        else if(($image2['size']/(1024*1024))>2){
            return 'inv_size';
        }
        else{
            $ext2 = pathinfo($image2['name'],PATHINFO_DIRNAME);
            $rname2 = 'IMG_'.random_int(11111,99999).".jpeg";

            $img_path2 = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname2;

            if($ext2=='png' || $ext2 == 'PNG'){
                $img2 = imagecreatefrompng($image2['tmp_name']);
            }
            else if($ext2=='webp' || $ext2 == 'WEBP')
            {
                $img2 = imagecreatefromwebp($image2['tmp_name']);
            }
            else{
                $img2 = imagecreatefromjpeg($image2['tmp_name']);

            }

            if(imagejpeg($img2,$img_path2,75))
            {
                return $rname2;
            }
            else{
                return 'upd_failed';
            }
            
        }
    }

    function uploadSVGImage($image,$folder)
    {
        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type'];

        if(!in_array($img_mime,$valid_mime))
        {
            return 'inv_img';                      //invalid image mime or format
        }
        else if(($image['size']/(1024*1024))>1){
            return 'inv_size';                     //invalid size greater than 1mb 
        }
        else{
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path))
            {
                return $rname;
            }
            else{
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
