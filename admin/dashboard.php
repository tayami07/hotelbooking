<?php
require('inc/essentials.php');
require('inc/db_config.php');

adminLogin();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dasboard</title>

    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light h-100">



    <div class="row">
        <div class="col-12">
            <!-- Heading -->
            <div class="w-100">
                <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">

                    <h3 class="mb-0 h-font">THYZEN - ADMIN</h3>
                    <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
                </div>



            </div>

        </div>
        <div class="col-3">
            <?php require('inc/adminheader.php') ?>
        </div>
        <div class="container-fluid col-9 mt-3" id="main-content">
            <div class="row">
                <div class="col-lg-10  p-4 overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3>DASHBOARD</h3>
                        <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown mode is active</h6>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-4">
                            <a href="" class="text-decoration-none">
                                <div class="card text-center text-success p-3">
                                    <h6>New bookings</h6>
                                    <h1 class="mt-2 mb-0">5</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="" class="text-decoration-none">
                                <div class="card text-center text-warning p-3">
                                    <h6>Refund bookings</h6>
                                    <h1 class="mt-2 mb-0">5</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="user_queries.php" class="text-decoration-none">
                                <div class="card text-center text-info p-3">
                                    <h6>User Queries</h6>
                                    <h1 class="mt-2 mb-0">5</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-4">
                            <a href="" class="text-decoration-none">
                                <div class="card text-center text-success p-3">
                                    <h6>Reviews and Ratings</h6>
                                    <h1 class="mt-2 mb-0">5</h1>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3>Booking analytics</h3>
                        <select class="form-select shadow-none bg-light w-auto">
                            <option value="1">Past 30 days</option>
                            <option value="2">Past 90 days</option>
                            <option value="3">Past 1 year</option>
                            <option value="4">All time</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>

</body>

</html>