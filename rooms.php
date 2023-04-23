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
                        <h4 class="mt-2">Filters</h4>

                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">

                            <!-- availability filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Check Availability</span>
                                    <button id="chk_avail_btn" class="btn btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                

                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-3" name="checkin">

                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none" name="checkout">
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

            <!-- room cards -->
            <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
                
            </div>

        </div>
    </div>

    <script>
        let rooms_data = document.getElementById('rooms-data');

        function fetch_rooms() {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax/rooms.php?fetch_rooms", true);

            xhr.onprogress = function() {
                rooms_data.innerHTML=`<div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`;
            }

            xhr.onload = function() {
                rooms_data.innerHTML = this.responseText;
            }
            xhr.send();
        }
        fetch_rooms();
    </script>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>

</body>

</html>