<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Links -->
     <?php require('inc/links.php');?>

    <title><?php echo $settings_r['site_title'] ?> - Home</title>
    <link rel="stylesheet" href="css/buttons.css" />
  

   

    <style>
        body {
            overflow-x: hidden;
        }

        .rooms {
            padding-top: 10rem;
        }

        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and(max-width:576px) {
            .availability-form {
                margin-top: 25px;
                padding: 0 35px;
            }

        }
    </style>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" /> -->

     
    <?php require('inc/header.php'); ?>

</head>

<body class="bg-light">

    <div class="position-relative">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/carousel/IMG_15372.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/IMG_93127.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/carousel/IMG_15372.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Availability Form -->
        <div class="container availability-form pt-5">

            <div class="row ">
                <div class="col-lg-12 bg-white shadow p-4 rounded" style="position:absolute;top:1rem">
                    <h5 class="md-4 text-custom">Check Booking Availability</h5>
                    <form action="rooms.php">
                        <div class="row align-items-end">
                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Check-In</label>
                                <input type="date" class="form-control shadow-none" name="checkin" required>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Check-Out</label>
                                <input type="date" class="form-control shadow-none" name="checkout" required>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Adult</label>
                                <select class="form-select shadow-none" name="adult">
                                    <?php
                                    $guests_q = mysqli_query($con, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children`
                                        FROM `rooms` WHERE `status`='1' AND `removed`='0'");

                                    $guests_res = mysqli_fetch_assoc($guests_q);
                                    for ($i = 0; $i <= $guests_res['max_adult']; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label class="form-label" style="font-weight:500;">Children</label>
                                <select class="form-select shadow-none" name="children">
                                    <?php
                                    $guests_q = mysqli_query($con, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children`
                                        FROM `rooms` WHERE `status`='1' AND `removed`='0'");

                                    $guests_res = mysqli_fetch_assoc($guests_q);
                                    for ($i = 0; $i <= $guests_res['max_children']; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="check_availability">
                            <div class="w-100 d-flex justify-content-center col-lg-1 mb-lg-3 mt-2">
                                <button type="submit" class="btn text-white shadow-none btn custom-btn  p-2 btn-sm-custom">Check</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Rooms -->
    <div class="rooms">
        <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Rooms</h2>
        <div class="container">
            <div class="row">
                <?php
                $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3", [1, 0], 'ii');
                while ($room_data = mysqli_fetch_assoc($room_res)) {
                    //get features of room
                    $fea_q = mysqli_query($con, "SELECT f.name FROM `features`f 
                            INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
                            WHERE rfea.room_id = '$room_data[id]'");

                    $features_data = "";
                    while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                        $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                $fea_row[name]
                            </span>";
                    }
                    //get facilities of room
                    $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                            INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                            WHERE rfac.room_id = '$room_data[id]'");

                    $facilities_data = "";
                    while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                        $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                $fac_row[name]
                            </span>";
                    }

                    //get thumbnail of image
                    $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                    $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                         WHERE `room_id`='$room_data[id]' 
                         AND `thumb`='1'");

                    if (mysqli_num_rows($thumb_q) > 0) {
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                    }

                    $book_btn = "";

                    if (!$settings_r['shutdown']) {
                        $login = 0;
                        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                            $login = 1;
                        }
                        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm custom-btn text-white custom-bg shadow-none'>Book Now</button>";
                    }

                    $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
                    WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESc LIMIT 20";

                    $rating_res = mysqli_query($con, $rating_q);
                    $rating_data = "";
                    $rating_fetch = mysqli_fetch_assoc($rating_res);
                    if ($rating_fetch['avg_rating'] != NULL) {
                        $rating_data = "<div class='rating mb-4'>
                            <h6 class='mb-1'>Rating</h6>
                            <span class='badge rounded-pill bg-light'>
                        ";
                        for ($i = 0; $i < $rating_fetch['avg_rating']; $i++) {
                            $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                        }
                        $rating_data .= "</span>
                            </div>
                        ";
                    }
                    //print room card
                    echo <<<data
                            <div class="col-lg-4 col-md-6 my-3">
                            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                <img src="$room_thumb" class="card-img-top">
                                <div class="card-body">
                                    <h5>$room_data[name]</h5>
                                    <h6 class="mb-1">$$room_data[price] per night</h6>

                                    <div class="features mb-4">
                                        <h6 class="mb-1">Features</h6>
                                        $features_data
                                    </div>
                                    <!-- Facilities -->
                                    <div class="facilities mb-4">
                                        <h6 class="mb-1">Amenities</h6>
                                        $facilities_data
                                    </div>

                                    
                                    <!-- guests -->
                                    <div class="guests mb-4">
                                        <h6 class="mb-1">Guests</h6>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            $room_data[adult] Adults
                                        </span>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            $room_data[children] Children
                                        </span>
                                    </div>

                                    <!-- Rating -->
                                    $rating_data
                                    
                                    <!-- side buttons -->
                                    <div class="d-flex justify-content-evenly mb-2">
                                        $book_btn
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-primary custom-bg shadow-none custom-btn-outline ">More Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        data;
                }
                ?>

                <div class="col-lg-12 text-center mt-5">
                    <a href="rooms.php" class="btn btn-md custom-btn-outline rounded fw-bold shadow-none">More Rooms</a>
                </div>



            </div>
        </div>
    </div>


    <!-- Facilities -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Facilities</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php
            $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY-id DESC LIMIT 5");
            $path = FACILITIES_IMG_PATH;
            while ($row = mysqli_fetch_assoc($res)) {
                echo <<<data
                    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4">
                        <img src="$path$row[icon]" width="60px">
                        <h5 class="mt-3">$row[name]</h5>
                    </div>
                    data;
            }
            ?>
            <div class="col-lg-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-md custom-btn-outline rounded fw-bold shadow-none">More Facilities</a>
            </div>
        </div>
    </div>

    <!-- testimonials -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Testimonials</h2>
    <div class="container mt-5">

        <div id="carouselExampleControls" class="carousel slide text-center carousel-dark" >
            <div class="carousel-inner">

                <?php
                $review_q = "SELECT rr.*, uc.fname AS uname, uc.profile, r.name AS rname FROM `rating_review` rr
            INNER JOIN `user_cred` uc ON rr.user_id = uc.id
            INNER JOIN `rooms` r ON rr.room_id = r.id 
            ORDER BY `sr_no` DESC LIMIT 6";

                $review_res = mysqli_query($con, $review_q);
                $img_path = USERS_IMG_PATH;
                if (mysqli_num_rows($review_res) == 0) {
                    echo 'No reviews yet!';
                } else {
                    $active = "active";
                    while ($row = mysqli_fetch_assoc($review_res)) {
                        $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                        for ($i = 1; $i < $row['rating']; $i++) {
                            $stars .= "<i class='bi bi-star-fill text-warning'></i> ";
                        }
                        echo <<<slides
                    <div class="carousel-item $active">
                        <img class="rounded-circle shadow-1-strong mb-4"
                        src="$img_path$row[profile]" alt="avatar"
                        style="width: 150px;" />
                        <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <h5 class="mb-3">$row[uname]</h5>
                            <p class="text-muted">$stars</p>
                            <p class="text-muted">
                            <i class="fas fa-quote-left pe-2"></i>
                            $row[review]
                            </p>
                        </div>
                    </div>
                    </div>
                slides;
                        $active = "";
                    }
                }
                ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    <!-- Reach us -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" height="320px" src="<?php echo $contact_r['iframe'] ?>" loading="lazy"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Contact us</h5>
                    <a href="tell: +<?php echo $contact_r['pn1'] ?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill">+<?php echo $contact_r['pn1'] ?></i>
                    </a>
                    <br>
                    <?php
                    if ($contact_r['pn2'] != '') {
                        echo <<<data
                            <a href="tell: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill">+$contact_r[pn2]</i>
                            </a>
                            data;
                    }
                    ?>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>Follow Us</h5>
                    <?php
                    if ($contact_r['tw'] != '') {
                        echo <<<data
                            <a href="$contact_r[tw]" class="d-inline-block-md-3">
                                <span class="badge bg-light text-dark fs-6 p-2">
                                    <i class="bi bi-twitter me-1"></i>Twitter
                                </span>
                            </a>
                            <br>
                            data;
                    }
                    ?>
                    <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block-md-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </span>
                    </a>
                    <br>
                    <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block-md-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram me-1"></i>Instagram
                        </span>
                    </a>
                    <br>

                </div>
            </div>
        </div>
    </div>

    <!-- Password reset modal -->

    <div class="modal fade" id="recoveryModal" aria-hidden="true" aria-labelledby="forgotModalLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form id="recovery-form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-shield-lock fs-3 me-2"></i>Set up new password
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input name="password" type="password" class="form-control shadow-none" required>
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn text shadow-none me-2" data-bs-dismis="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary shadow-none p-1 me-2">Submit</button>
                        </div>

                    </div>

                </form>


            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

    <?php

    if (isset($_GET['account_recovery'])) {
        $data = filteration($_GET);
        $t_date = date('Y-m-d');
        $query = select(
            "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1",
            [$data['email'], $data['token'], $t_date],
            'sss'
        );
        if (mysqli_num_rows($query) == 1) {
            echo <<<showModal
                <script>
                    var myModal = document.getElementById('recoveryModal');

                    myModal.querySelector("input[name='email']").value='$data[email]';
                    myModal.querySelector("input[name='token']").value='$data[token]';

                    var modal = bootstrap.Modal.getOrCreateInstance(myModal);
                    modal.show();
                </script>
            showModal;
        } else {
            alert("error", "Invalid or expired link");
        }
    }
    ?>

    <script>
        //recover account
        let recovery_form = document.getElementById('recovery-form');

        recovery_form.addEventListener('submit', (e) => {
            e.preventDefault();

            let data = new FormData(); //FormData used for image upload

            data.append('email', recovery_form.elements['email'].value);
            data.append('token', recovery_form.elements['token'].value);
            data.append('password', recovery_form.elements['password'].value);

            data.append('recover_user', '');

            // modal hide
            var myModal = document.getElementById('recoveryModal');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

            xhr.onload = function() {
                if (this.responseText == 'failed') {
                    alert('error', "Account reset failed.");
                } else {
                    alert('success', "Account reset successful.");
                    recovery_form.reset();
                }
            }
            xhr.send(data);

        });

        //check login
        function checkLoginToBook(status, room_id) {
            if (status) {
                window.location.href = 'confirm_booking.php?id=' + room_id;
            } else {
                alert('error', 'Please login to book room!');
            }
        }
    </script>

    <!-- Initialize Swiper -->
    <!-- <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script> -->

</body>

</html>