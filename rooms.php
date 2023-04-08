<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/buttons.css" />
    <title>Thyzen - Hotels</title>

    <!-- Links -->
    <?php require('inc/links.php');

    ?>



</head>

<body>

    <!-- Header -->
    <?php require('inc/header.php'); ?>

    <!-- Main Heading -->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Hotels</h2>

        <div class="h-line bg-dark"></div>
    </div>

    <!-- Filter -->
    <div class="container-fluid custom-bg">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid dlex-lg-column align-items-stretch">
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <h4 class="mt-2">Filter</h4>


                            <!-- availability filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5>Check Availability</h5>

                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-3">

                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none">
                            </div>
                            <!-- Services checkbox -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5>Services</h5>

                                <div class="mb-2">
                                    <input type="checkbox" id="f1" class="form-check-iput shadow-none me-1">
                                    <label for="f1" class="form-check-label">Facility one</label>
                                </div>

                                <div class="mb-2">
                                    <input type="checkbox" id="f2" class="form-check-iput shadow-none me-1">
                                    <label for="f2" class="form-check-label">Facility two</label>
                                </div>
                                <div class="mb-2">
                                    <input type="checkbox" id="f3" class="form-check-iput shadow-none me-1">
                                    <label for="f3" class="form-check-label">Facility three</label>
                                </div>
                            </div>
                            <!-- Number of people Filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="mb-3" style="font-size: 18px;">Guest</h5>
                                <div class="d-flex">
                                    <div class="me-3 me-md-4">
                                        <label class="form-label">Adult</label>
                                        <input type="number" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="number" class="form-control shadow-none">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Room card -->
            <div class="col-lg-9 col-md-12 px-4">
                <?php
                $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?", [1, 0], 'ii');
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
                    //print room card
                    echo <<<data
                        <div class="card mb-4 border-0 shadow">
                            <div class="row g-0 p-3 align-items-center">
                                
                                <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                    <img src="$room_thumb" class="img-fluid rounded-start" style="height:20rem; object-fit:cover">
                                </div>
                                <!-- Hotel mini details -->
                                <div class="col-md-5 px-lg-3 px-md-3 px-0">
        
                                    <h5 class="mb-3">$room_data[name]</h5>
                                    <div class="features mb-3">
                                        <h6 class="mb-1">Features</h6>
                                        $features_data
                                    </div>
        
                                    <!-- facilities -->
                                    <div class="facilities mb-3">
                                        <h6 class="mb-1">Amenities</h6>
                                        $facilities_data
                                    </div>
        
                                    <!-- guests -->
                                    <div class="guests mb-3">
                                        <h6 class="mb-1">Guests</h6>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            $room_data[adult] Adults
                                        </span>
                                        <span class="badge rounded-pill bg-light text-dark text-wrap">
                                            $room_data[children] Children
                                        </span>
                                    </div>
                                
        
                                    <!-- Rating -->
                                    <div class="rating mb-4">
                                        <h6 class="mb-1">Rating</h6>
                                        <span class="badge rounded-pill bg-white">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </span>
                                    </div>
        
                                    <!-- Guests for Room -->
                                    <!-- <div class="guests mb-4">
                                            <h6 class="mb-1">Guests</h6>
                                            <span class="badge rounded-pil bg-light text-dark text-wrap">
                                                2 Adults
                                            </span>
                                            <span class="badge rounded-pil bg-light text-dark text-wrap">
                                                2 Children
                                            </span>
                                        </div> -->
                                </div>
        
                                <div class="col-2">
                                    <!-- buttons -->
                                    <div class="mt-lg-0 mt-md-0 mt-4 text-center">
                                        <h6 class="mb-4">$$room_data[price] per night</h6>
                                        <a href="#" class="btn btn-sm w-100 btn-primary text-white shadow-none mb-2 custom-btn">Book Now</a>
                                        <a href="room_details.php?id=$room_data[id]" class="btn btn-sm w-100 btn-primary text-white shadow-none">More Details</a>
                                    </div>
        
                                </div>
        
        
        
                            </div>
                        </div>
                        data;
                }
                ?>

                <!-- Card1 -->
                
            </div>

        </div>
    </div>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>

</body>

</html>