<?php
require('inc/essentials.php');
require('inc/db_config.php');

adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read');
        } else {
            alert('error', 'Operation failed');
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'Data deleted');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deleted');
        } else {
            alert('error', 'Operation failed');
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Booking Records</title>

    <?php require('inc/links.php'); ?>
    <!-- <link rel="stylesheet" type="text/css" href="css/common.css"> -->
</head>

<body class="bg-light">


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
                <div class="p-4 overflow-hidden">

                    <div class="container-fluid" id="main-content">
                        <div class="row">
                            <div class="ms-auto -4 overflow-hidden">
                                <h3 class="mb-4">Booking Records</h3>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="text-end mb-4">
                                            <input type="text" id="search_input" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search">
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover border">
                                                <thead>
                                                    <tr class="bg-dark text-light">
                                                        <th scope="col">#</th>
                                                        <th scope="col">User Details</th>
                                                        <th scope="col">Room Details</th>
                                                        <th scope="col">Booking Details</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="table-data">
                                                </tbody>
                                            </table>
                                        </div>

                                        <nav>
                                            <ul class="pagination mt-2" id="table-pagination">
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

    <script src="scripts/booking_records.js"></script>


</body>

</html>