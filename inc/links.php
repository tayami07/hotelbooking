<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>



<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<!-- CSS -->
<link rel="stylesheet" href="css/common1.css"/>

<!--Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


<?php

    session_start();
    date_default_timezone_set("Asia/Kathmandu");

    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');

    $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $settings_r = mysqli_fetch_assoc(select($settings_q,$values,'i'));

    if($settings_r['shutdown']){
        echo<<<alertbar
            <div class='bg-danger text-center p-2 fw-bold'>
                <i class="bi bi-exclamation-triangle-fill"></i>
                Bookings are temporarily closed!
            </div>
        alertbar;
    }
?>