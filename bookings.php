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

    <title><?php echo $settings_r['site_title'] ?> - Bookings</title>


</head>

<body>

    <!-- Header -->
    <?php require('inc/header.php');
        if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
            redirect('index.php');
        }
    ?>

    <div class="container">
        <div class="row">
            <!-- Main Heading -->
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">Bookings</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
                </div>
            </div>
        </div>
    </div>

    <?php

    $query = "SELECT bo.*, bd.* 
            FROM `booking_order` bo
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
            WHERE ((bo.booking_status ='booked')
            OR (bo.booking_status = 'cancelled'))
            AND (bo.user_id=?)
            ORDER BY bo.booking_id DESC";

    $result = select($query, [$_SESSION['uId']], 'i');
    while ($data = mysqli_fetch_assoc($result)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $status_bg = "";
        $btn = "";

        if ($data['booking_status'] == 'booked') {
            $status_bg = "bg-success";

            if ($data['arrival'] == 1) {
                $btn = "
                        <button type='button' class='btn btn-sm btn-dark mt-2 shadow-none'>
                            Rate & Review
                        </button>
                    ";
            } else {
                $btn = "
                        <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-sm btn-danger mt-2 shadow-none'>
                            Cancel
                        </button>
                    ";
            }
        } else {
            $status_bg = "bg-danger";
            if ($data['refund'] == 0) {
                $btn = "<span class='badge bg-primary'>Refund in process..</span>";
            }
        }

        echo <<<bookings
                <div class='col-md-4 px-4 mb-4'>
                    <div class='bg-white p-3 rounded shadow-sm'>
                        <h5 class='fw-bold'>$data[room_name]</h5>
                        <p>$$data[price] per night</p>
                        <p>
                            <b>Check-in: </b> $checkin <br>
                            <b>Check-out: </b> $checkout
                        </p>
                        <p>
                            <b>Total Amount: </b> $$data[total_pay] <br>
                            <b>Booking Id: </b> $data[booking_id]<br>
                            <b>Date: </b> $date
                        </p>
                        <p>
                            <span class='badge $status_bg'>$data[booking_status]</span>
                            <br>
                            $btn
                        </p>
                    </div>
                </div>
            bookings;
    }
    ?>

    <?php
        if(isset($_GET['cancel_status'])){
            alert('success','Booking cancelled!');
        }
    ?>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>

    <script>
        function cancel_booking(id)
        {
            if (confirm('Are you sure you want to cancel this booking?')) {

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/cancel_booking.php", true); //asynchronously by "true"
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if(this.responseText==1){
                        window.location.href="bookings.php?cancel_status=true";
                    }
                    else{
                        alert('error','Cancellation failed!');
                    }
                }
                xhr.send('cancel_booking&id='+id);
                // console.log('ccancel');
            }
        }
    </script>

</body>

</html>