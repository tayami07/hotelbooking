<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thyzen - About Us</title>

    <!-- Links -->
    <?php require('inc/links.php'); ?>

</head>

<body>


    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">About Us</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            <?php echo $settings_r['site_about'] ?>
        </p>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Thyzen - Your Zen</h3>
                <p>Sometime in the early 80s, the search for a quiet life away from the city brought us to Nagarkot. 
                    What started out as an organic apple orchard somehow turned into our mountain retreat on the persuasion of friends; 
                    especially since the view from here was not too bad. Over the last 30 years, we have been nurturing our garden and forest area 
                    spread across six acres. We feel very lucky to share our space with many species of trees, birds and animals, to the delight 
                    of many of our nature-loving guests. We are continually trying to make our presence here more sustainable, environmentally and 
                    socially. We find delight in the quiet and reassuring company of the mountains during the day, and the stars at night. 
                    
                    This is a place for rest.
                    
                    Welcome to our garden!
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
                <img src="images/fort1.jpg" class="w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/wifi.svg" width="70px">
                    <h4 class="mt-3">100+ Rooms</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/wifi.svg" width="70px">
                    <h4 class="mt-3">200+ Customers</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/wifi.svg" width="70px">
                    <h4 class="mt-3">100+ Reviews</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                    <img src="images/wifi.svg" width="70px">
                    <h4 class="mt-3">200+ Staffs</h4>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center">Management Team</h3>
    <div class="container px-4">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <?php
                $about_r = selectAll('team_details');
                $path = ABOUT_IMG_PATH;
                while ($row = mysqli_fetch_assoc($about_r)) {
                    echo <<<data
                        <div class="carousel-item active">
                            <img src="$path$row[picture]" class="d-block w-100" alt="...">
                            <h5 class="mt-2">$row[name]</h5>
                        </div>
                        data;
                }

                ?>
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
    </div>

    <?php require('inc/footer.php'); ?>

</body>

</html>