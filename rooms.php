<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/common.css"/>
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
    <div class="container border border-black">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-0">
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

                <!-- Card1 -->
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <!-- Image -->
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="images/carousel/IMG_93127.png" class="img-fluid rounded-start" style="height:20rem; object-fit:cover">
                        </div>
                        <!-- Hotel mini details -->
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">

                            <h5 class="mb-3">Simple room</h5>
                            <div class="features mb-4">
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">
                                    2 Rooms
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">
                                    2 Bathrooms
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap lh-base">
                                    Balcony
                                </span>
                            </div>

                            <!-- facilities -->
                            <div class="facilities mb-3">
                                <h6 class="mb-1">Amenities</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Wifi
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Wifi
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Wifi
                                </span>

                            </div>

                            <!-- guests -->
                            <div class="guests mb-3">
                                <h6 class="mb-1">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    2 adults
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    2 children
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
                                <div class="text-center">
                                    <h6 class="mb-4">$100</h6>
                                    <a href="#" class="btn btn-sm w-100 btn-primary text-white shadow-none mb-2 custom-btn">Book Now</a>
                                    <a href="#" class="btn btn-sm w-100 btn-primary text-white shadow-none">More Details</a>
                                </div>

                        </div>



                    </div>
                </div>

                <!-- Card2 -->
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <!-- Image -->
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="..." class="img-fluid rounded-start" alt="...">
                        </div>
                        <!-- Hotel mini details -->
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-1">Annapurna</h5>

                            <div class="services mb-4">
                                <h6 class="mb-1">Location</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">Kuala Lumpur</span>
                            </div>

                            <div class="features mb-3">
                                <h6 class="mb-3">Features</h6>

                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 room
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Bathroom
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Balcony
                                </span>
                            </div>



                            <div class="services mb-3">
                                <h6 class="mb-1">Services</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">Car Park</span>
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

                        <!-- Description and prices -->
                        <div class="col-md-2 text-center">
                            <!-- <h6 class="mb-4"></h6>
                            <a href="#" class="btn btn-sm w-100 text-white bg-primary custom-bg shadow-none mb-2">Book Now</a> -->
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Ea enim maxime libero illum facilis mollitia obcaecati.</p>
                            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">Show prices</a>

                        </div>

                    </div>
                </div>

                <!-- Card3 -->
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <!-- Image -->
                        <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                            <img src="..." class="img-fluid rounded-start" alt="...">
                        </div>
                        <!-- Hotel mini details -->
                        <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-1">Annapurna</h5>

                            <div class="services mb-4">
                                <h6 class="mb-1">Location</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">Kuala Lumpur</span>
                            </div>

                            <div class="features mb-3">
                                <h6 class="mb-3">Features</h6>

                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 room
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Bathroom
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    Balcony
                                </span>
                            </div>



                            <div class="services mb-3">
                                <h6 class="mb-1">Services</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">Wifi</span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">Car Park</span>
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

                        <!-- Description and prices -->
                        <div class="col-md-2 text-center">
                            <!-- <h6 class="mb-4"></h6>
                            <a href="#" class="btn btn-sm w-100 text-white bg-primary custom-bg shadow-none mb-2">Book Now</a> -->
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Ea enim maxime libero illum facilis mollitia obcaecati.</p>
                            <a href="#" class="btn btn-sm w-100 btn-outline-dark shadow-none">Show prices</a>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>

</body>

</html>