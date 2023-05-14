<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/common.css" />
    <!-- Links -->
    <?php require('inc/links.php'); ?>
    <?php require('config.php'); ?>

    <title><?php echo $settings_r['site_title'] ?> - Payment Status</title>





</head>

<body>
    <?php
    require('inc/header.php');
    ?>


    <!-- Filter -->
    <div class="container">
        <div class="row">
            <!-- Main Heading -->
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">Payment Status</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
                </div>
            </div>


        <?php

            $frm_data = filteration($_GET);

            if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
                redirect('index.php');
            }

            $booking_q = "SELECT * FROM `booking_order` bo 
                INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
                WHERE bo.booking_id=? AND bo.user_id=? AND bo.booking_status!=?
            ";
            $booking_res = select($booking_q,[$frm_data['booking_id'],$_SESSION['uId'],'pending'],'sis');

            if(mysqli_num_rows($booking_res)==0){
                redirect('index.php');
            }
            
            $booking_fetch = mysqli_fetch_assoc($booking_res);
            if($booking_fetch['booking_status']=="booked")
            {
                echo<<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            Payment successful! Your booking was successful. You can view your booking in your bookings page.
                            <br>
                            <a href='bookings.php'>Go to bookings</a>
                        </p>
                    </div>
                data;
            }
            else{
                echo<<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-success">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Failed to book the room! Please try again!
                            <br>
                            <a href='bookings.php'>Go to bookings</a>
                        </p>
                    </div>
                data;
            }

            ?>

        </div>
    </div>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>


</body>

</html>