<?php
require('inc/essentials.php');
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
                <div class="col-lg-10  p-4overflow-hidden">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Molestias consectetur nemo odit, quae qui eligendi magni.
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>

</body>

</html>